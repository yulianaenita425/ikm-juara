<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class IKMController extends Controller 
{
    /**
     * Menampilkan halaman utama manajemen IKM dengan Statistik Widget
     */
public function index()
{
    // 1. Hitung total KESELURUHAN dari database (bukan cuma yang tampil di halaman)
    $totalinvestasi = DB::table('pelaku_usaha')->sum('investasi');
    $totalTenagaKerja = DB::table('pelaku_usaha')->sum('tenaga_kerja');
    $totalSemuaData = DB::table('pelaku_usaha')->count(); 
    $totalPelakuUnik = DB::table('pelaku_usaha')
                    ->select('nib')
                    ->distinct()
                    ->get()
                    ->count();

    $data = DB::table('pelaku_usaha')->orderBy('id', 'desc')->get();

    // 3. Kirim semuanya ke view
    return view('admin.pelaku_usaha.index', compact(
        'data', 
        'totalinvestasi', 
        'totalTenagaKerja', 
        'totalSemuaData', 
        'totalPelakuUnik'
    ));
}

/**
     * Fungsi untuk Import Data dari Excel dengan Deteksi Duplikat NIB + KBLI
     * Dan statistik jumlah data berhasil/dilewati
     */
    public function import(Request $request) 
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);

        try {
            $file = $request->file('file');
            $rows = Excel::toArray([], $file)[0];
            $dataRows = array_slice($rows, 1);

            $listDilewati = [];
            $newDataToInsert = [];
            $berhasil = 0;
            $dilewati = 0;

            foreach ($dataRows as $row) {
                // 1. Ambil data mentah & Validasi Dasar
                $rawNib = $row[1] ?? null;
                $kbli = (string) ($row[11] ?? '');

                // Lewati jika baris kosong atau NIB bukan angka
                if (!$rawNib || !is_numeric($rawNib)) continue;

                // 2. Format leading zero (NIB 13 digit, NIK 16 digit)
                $nib = str_pad(number_format((float)$rawNib, 0, '', ''), 13, "0", STR_PAD_LEFT);
                $nik = isset($row[2]) ? str_pad(number_format((float)$row[2], 0, '', ''), 16, "0", STR_PAD_LEFT) : '-';

                // 3. Cek Duplikat NIB + KBLI
                $isExists = DB::table('pelaku_usaha')
                            ->where('nib', $nib)
                            ->where('kbli', $kbli)
                            ->exists();

                if ($isExists) {
                    $dilewati++;
                    $listDilewati[] = "NIB: $nib - " . ($row[5] ?? 'Tanpa Nama');
                    continue;
                }

                // 4. Konversi Format Tanggal Indonesia ke MySQL (Y-m-d)
                $tanggalFinal = null;
                if (!empty($row[18])) {
                    $bulanIndo = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                    $bulanAngka = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
                    $tglClean = str_replace($bulanIndo, $bulanAngka, $row[18]);
                    try {
                        $tanggalFinal = \Carbon\Carbon::createFromFormat('j m Y', $tglClean)->format('Y-m-d');
                    } catch (\Exception $e) { 
                        $tanggalFinal = null; 
                    }
                }

                $newDataToInsert[] = [
                    'nib'              => $nib,
                    'nik'              => $nik,
                    'skala_usaha'      => $row[3] ?? '-',
                    'jenis_perusahaan' => $row[4] ?? '-',
                    'nama_perusahaan'  => $row[5] ?? '-',
                    'nama_proyek'      => $row[6] ?? '-',
                    'nama_pemilik'     => $row[7] ?? '-',
                    'alamat_usaha'     => $row[8] ?? '-',
                    'kecamatan'        => $row[9] ?? '-',
                    'kelurahan'        => $row[10] ?? '-',
                    'kbli'             => $kbli,
                    'uraian_kbli'      => $row[12] ?? '-',
                    'tingkat_risiko'   => $row[13] ?? '-',
                    'investasi'        => (int)preg_replace('/[^0-9]/', '', ($row[14] ?? 0)) ?: 0,
                    'tenaga_kerja'     => (int)preg_replace('/[^0-9]/', '', ($row[15] ?? 0)) ?: 0,
                    'no_telp'          => $row[16] ?? '-',
                    'email'            => $row[17] ?? '-',
                    'tgl_terbit'       => $tanggalFinal,
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ];
                $berhasil++;
            }

            // 5. Simpan Data Baru dalam Chunk (per 100 baris)
            if (!empty($newDataToInsert)) {
                foreach (array_chunk($newDataToInsert, 100) as $chunk) {
                    DB::table('pelaku_usaha')->insert($chunk);
                }
            }

            // 6. Response dengan data statistik untuk Modal
            return redirect()->back()->with([
                'import_status'   => true,
                'jumlah_berhasil' => $berhasil,
                'jumlah_dilewati' => $dilewati,
                'list_dilewati'   => $listDilewati,
                'success'         => "Proses import selesai. $berhasil data berhasil masuk."
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    /**
     * Fungsi Download Template Excel On-the-Fly
     */
    public function downloadTemplate()
    {
        $fileName = 'template_pelaku_usaha.xlsx';
        $header = [
            ['No', 'NIB', 'NIK', 'Skala Usaha', 'Jenis Perusahaan', 'Nama Perusahaan', 'Nama Proyek', 'Nama Pemilik', 'Alamat Usaha', 'Kecamatan', 'Kelurahan', 'KBLI', 'Uraian KBLI', 'Tingkat Risiko', 'Jumlah investasi', 'Jumlah Tenaga Kerja', 'Nomor Telp', 'Email', 'Tanggal Terbit']
        ];

        return Excel::download(new class($header) implements \Maatwebsite\Excel\Concerns\FromArray {
            protected $data;
            public function __construct(array $data) { $this->data = $data; }
            public function array(): array { return $this->data; }
        }, $fileName);
    }
}
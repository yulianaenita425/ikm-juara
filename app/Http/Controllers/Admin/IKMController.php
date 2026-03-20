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
     * Menampilkan halaman utama manajemen IKM
     */
    public function index()
    {
        $data = DB::table('pelaku_usaha')->orderBy('id', 'desc')->paginate(50);
        return view('admin.pelaku_usaha.index', compact('data'));
    }

    /**
     * Fungsi untuk Import Data dari Excel dengan Deteksi Duplikat NIB + KBLI
     */
public function import(Request $request) 
{
    $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);

    try {
        $file = $request->file('file');
        $rows = Excel::toArray([], $file)[0];
        $dataRows = array_slice($rows, 1);

        $skippedDuplicates = [];
        $newDataToInsert = [];

foreach ($dataRows as $row) {
            // 1. Lewati jika baris kosong atau NIB tidak ada
            if (empty($row[1])) continue;

            // 2. OPTIMASI: Lewati jika NIB bukan angka (mencegah error format)
            if (!is_numeric($row[1])) continue;

            // Format NIB, NIK & KBLI
            $nib = str_pad(number_format((float)$row[1], 0, '', ''), 13, "0", STR_PAD_LEFT);
            $nik = str_pad(number_format((float)$row[2], 0, '', ''), 16, "0", STR_PAD_LEFT);
            $kbli = (string) ($row[11] ?? '');

            // CEK APAKAH KOMBINASI NIB + KBLI SUDAH ADA?
            $isExists = DB::table('pelaku_usaha')
                            ->where('nib', $nib)
                            ->where('kbli', $kbli)
                            ->exists();

            if ($isExists) {
                // Jika sudah ada, masukkan ke daftar "Dilewati"
                $skippedDuplicates[] = "NIB: " . $nib . " - " . ($row[5] ?? 'Tanpa Nama');
            } else {
                // Jika BELUM ada, siapkan untuk di-insert
                $tanggalFinal = null;
                if (!empty($row[18])) {
                    $bulanIndo = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                    $bulanAngka = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
                    $tglClean = str_replace($bulanIndo, $bulanAngka, $row[18]);
                    try {
                        $tanggalFinal = \Carbon\Carbon::createFromFormat('j m Y', $tglClean)->format('Y-m-d');
                    } catch (\Exception $e) { $tanggalFinal = null; }
                }

// ... dalam perulangan foreach ...

$newDataToInsert[] = [
    'nib'              => $nib,                      // Index 1 (Kolom B)
    'nik'              => $nik,                      // Index 2 (Kolom C)
    'skala_usaha'      => $row[3] ?? '-',            // Index 3 (Kolom D)
    'jenis_perusahaan' => $row[4] ?? '-',            // Index 4 (Kolom E)
    'nama_perusahaan'  => $row[5] ?? '-',            // Index 5 (Kolom F)
    'nama_proyek'      => $row[6] ?? '-',            // Index 6 (Kolom G)
    'nama_pemilik'     => $row[7] ?? '-',            // Index 7 (Kolom H)
    'alamat_usaha'     => $row[8] ?? '-',            // Index 8 (Kolom I)
    'kecamatan'        => $row[9] ?? '-',            // Index 9 (Kolom J)
    'kelurahan'        => $row[10] ?? '-',           // Index 10 (Kolom K)
    'kbli'             => $kbli,                     // Index 11 (Kolom L)
    'uraian_kbli'      => $row[12] ?? '-',           // Index 12 (Kolom M)
    'tingkat_risiko'   => $row[13] ?? '-',           // Index 13 (Kolom N)
    'investasi'        => (int)preg_replace('/[^0-9]/', '', ($row[14] ?? 0)) ?: 0, // Index 14 (Kolom O)
    'tenaga_kerja'     => (int)preg_replace('/[^0-9]/', '', ($row[15] ?? 0)) ?: 0, // Index 15 (Kolom P)
    'no_telp'          => $row[16] ?? '-',           // Index 16 (Kolom Q)
    'email'            => $row[17] ?? '-',           // Index 17 (Kolom R)
    'tgl_terbit'       => $tanggalFinal,             // Index 18 (Kolom S)
    'created_at'       => now(),
    'updated_at'       => now(),
];
            }
        }

        // Simpan HANYA data yang benar-benar baru
        if (!empty($newDataToInsert)) {
            foreach (array_chunk($newDataToInsert, 100) as $chunk) {
                DB::table('pelaku_usaha')->insert($chunk);
            }
        }

        // Pesan sukses & Popup peringatan data yang ditolak
        if (count($skippedDuplicates) > 0) {
            $msg = count($newDataToInsert) . " data baru berhasil disimpan.";
            return redirect()->back()->with([
                'success' => $msg,
                'warning_duplicates' => $skippedDuplicates
            ]);
        }

        return redirect()->back()->with('success', 'Semua data baru berhasil diimport!');

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

        // Header sesuai dengan indeks array pada fungsi import (18 Kolom Data)
        $header = [
            ['No', 'NIB', 'NIK', 'Skala Usaha', 'Jenis Perusahaan', 'Nama Perusahaan', 'Nama Proyek', 'Nama Pemilik', 'Alamat Usaha', 'Kecamatan', 'Kelurahan', 'KBLI', 'Uraian KBLI', 'Tingkat Risiko', 'Jumlah Investasi', 'Jumlah Tenaga Kerja', 'Nomor Telp', 'Email', 'Tanggal Terbit']
        ];

        return Excel::download(new class($header) implements \Maatwebsite\Excel\Concerns\FromArray {
            protected $data;
            public function __construct(array $data) { $this->data = $data; }
            public function array(): array { return $this->data; }
        }, $fileName);
    }
}
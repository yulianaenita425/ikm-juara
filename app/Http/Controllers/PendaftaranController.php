<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Exception;
use App\Exports\PendaftarExport;
use Maatwebsite\Excel\Facades\Excel;

class PendaftaranController extends Controller
{
    /**
     * Menampilkan daftar pendaftar aktif dengan statistik kuota yang dioptimalkan
     */
    public function dataPendaftar(Request $request)
    {
        // 1. Inisialisasi Query untuk Tabel Pendaftar Aktif
        $query = DB::table('registrasi_pelatihan')->whereNull('deleted_at');

        // Fitur Filter Kegiatan
        if ($request->filled('kegiatan')) {
            $query->where('nama_kegiatan', $request->kegiatan);
        }

        $pendaftar = $query->orderBy('created_at', 'desc')->get();
        
        // 2. Ambil daftar kegiatan unik untuk dropdown filter
        $list_kegiatan = DB::table('list_kegiatan')->pluck('nama_kegiatan');

        // 3. OPTIMASI LOGIKA STATISTIK: 
        // Menggunakan leftJoin untuk menghitung kuota terisi secara real-time
        $statistik = DB::table('list_kegiatan as lk')
            ->leftJoin('registrasi_pelatihan as rp', function($join) {
                $join->on('lk.nama_kegiatan', '=', 'rp.nama_kegiatan')
                     ->whereNull('rp.deleted_at');
            })
            ->select(
                'lk.nama_kegiatan as nama',
                'lk.kuota_peserta as kuota',
                DB::raw('count(rp.id) as terisi')
            )
            ->where('lk.status', 'aktif')
            ->groupBy('lk.nama_kegiatan', 'lk.kuota_peserta')
            ->get()
            ->map(function ($item) {
                $item->sisa = $item->kuota - $item->terisi;
                $item->persentase = $item->kuota > 0 
                    ? round(($item->terisi / $item->kuota) * 100) 
                    : 0;
                return $item;
            });

        return view('admin.pendaftar', compact('pendaftar', 'list_kegiatan', 'statistik'));
    }

    /**
     * Proses simpan pendaftaran (Formulir User)
     */
    public function store(Request $request) 
    {
        // Validasi diperketat namun disesuaikan dengan struktur DB (NIK 16, NIB maks 16)
        $request->validate([
            'nama_kegiatan'     => 'required',
            'nik'               => 'required|string|size:16',
            'nib'               => 'required|string|max:16', 
            'foto_ktp'          => 'required|image|max:5120',
            'nama_lengkap'      => 'required|string|max:255',
            'whatsapp'          => 'required|string|max:255',
            'email'             => 'required|email|max:255',
            'nama_usaha'        => 'required|string|max:255',
            'tanggal_lahir'     => 'required|date',
            'alamat_usaha'      => 'required|string',
            'kecamatan'         => 'required|string|max:255',
            'kelurahan'         => 'required|string|max:255',
            'level_digital'     => 'required|string',
            'target_6_bulan'    => 'required|string',
        ]);

        try {
            // 1. Handle Upload Foto ke ImgBB
            $uploadKtp = null;
            if ($request->hasFile('foto_ktp')) {
                $file = $request->file('foto_ktp');
                $response = Http::asMultipart()->post('https://api.imgbb.com/1/upload', [
                    'key'   => env('IMGBB_API_KEY'),
                    'image' => base64_encode(file_get_contents($file->getRealPath())),
                ]);

                if ($response->successful()) {
                    $uploadKtp = $response->json()['data']['url'];
                } else {
                    throw new Exception("Gagal mengunggah foto KTP ke server gambar.");
                }
            }

            // 2. Pembersihan & Pengolahan Data
            // Data checkbox tantangan & media dikonversi ke JSON string untuk kolom LongText
            $tantangan = json_encode($request->input('tantangan', []));
            $media = json_encode($request->input('media', []));
            
            // Menghapus format titik rupiah agar tersimpan sebagai angka murni di varchar
            $omzetClean = preg_replace('/[^0-9]/', '', $request->omzet_bulanan ?? 0);

            // 3. Eksekusi Insert ke Database
            DB::table('registrasi_pelatihan')->insert([
                'nama_kegiatan'        => $request->nama_kegiatan,
                'nama_lengkap'         => $request->nama_lengkap,
                'nik'                  => $request->nik,
                'nib'                  => $request->nib,
                'email'                => $request->email,
                'whatsapp'             => $request->whatsapp,
                'jenis_kelamin'        => $request->jenis_kelamin,
                'tanggal_lahir'        => $request->tanggal_lahir,
                'foto_ktp'             => $uploadKtp,
                'nama_usaha'           => $request->nama_usaha,
                'alamat_usaha'         => $request->alamat_usaha,
                'kelurahan'            => $request->kelurahan,
                'kecamatan'            => $request->kecamatan,
                'kota'                 => $request->input('kota', 'Madiun'), // Default Madiun sesuai DB
                'jenis_usaha'          => $request->jenis_usaha,
                'tahun_mulai'          => $request->tahun_mulai,
                'skala_usaha'          => $request->skala_usaha,
                'omzet_bulanan'        => $omzetClean, 
                'stabilitas_omzet'     => $request->stabilitas_omzet,
                'tantangan_usaha'      => $tantangan,
                'media_penjualan'      => $media,
                'karyawan_tetap'       => $request->karyawan_tetap ?? 0,
                'karyawan_tidak_tetap' => $request->karyawan_tidak_tetap ?? 0,
                'sistem_usaha'         => $request->sistem_usaha,
                'level_digital'        => $request->level_digital ?? 'Pemula',
                'pernah_pelatihan'     => $request->pernah_pelatihan,
                'harapan_pelatihan'    => $request->harapan_pelatihan ?? '-',
                'target_6_bulan'       => $request->target_6_bulan ?? '-',
                'created_at'           => now(),
                'updated_at'           => now(),
                'deleted_at'           => null,
            ]);

            return back()->with('success', 'Pendaftaran Berhasil Disimpan!');
        } catch (Exception $e) {
            // Mengembalikan input agar user tidak perlu mengetik ulang jika terjadi error
            return back()->withInput()->with('error', 'Gagal memproses pendaftaran: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan data yang dihapus sementara
     */
    public function recycleBin()
    {
        $pendaftar = DB::table('registrasi_pelatihan')
            ->whereNotNull('deleted_at')
            ->orderBy('deleted_at', 'desc')
            ->get();

        return view('admin.recycle_bin', compact('pendaftar'));
    }

    /**
     * Memulihkan data dari Recycle Bin
     */
    public function restore($id)
    {
        try {
            DB::table('registrasi_pelatihan')->where('id', $id)->update(['deleted_at' => null]);
            return redirect()->route('admin.recycle')->with('success', 'Data pendaftar berhasil dipulihkan.');
        } catch (Exception $e) {
            return back()->with('error', 'Gagal memulihkan data: ' . $e->getMessage());
        }
    }

    /**
     * Hapus permanen data dari database
     */
    public function forceDelete($id)
    {
        try {
            DB::table('registrasi_pelatihan')->where('id', $id)->delete();
            return redirect()->route('admin.recycle')->with('success', 'Data telah dihapus permanen dari sistem.');
        } catch (Exception $e) {
            return back()->with('error', 'Gagal menghapus permanen: ' . $e->getMessage());
        }
    }

    /**
     * Ekspor data pendaftar aktif ke Excel
     */
    public function exportExcel()
    {
        try {
            return Excel::download(new PendaftarExport, 'data_pendaftar_ikm_aktif.xlsx');
        } catch (Exception $e) {
            return back()->with('error', 'Gagal ekspor excel: ' . $e->getMessage());
        }
    }

    /**
     * Soft Delete (Pindahkan ke Recycle Bin)
     */
    public function destroy($id)
    {
        try {
            DB::table('registrasi_pelatihan')->where('id', $id)->update(['deleted_at' => now()]);
            return redirect()->route('admin.pendaftar')->with('success', 'Data pendaftar dipindahkan ke Recycle Bin.');
        } catch (Exception $e) {
            return back()->with('error', 'Gagal membuang data: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan halaman formulir pendaftaran untuk user
     */
    public function formulir()
    {
        $list_kegiatan = DB::table('list_kegiatan')->where('status', 'aktif')->get();
        return view('daftar', compact('list_kegiatan'));
    }
}
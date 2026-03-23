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
     * Menampilkan daftar pendaftar aktif (Hanya yang belum dihapus)
     * Menggabungkan logika tabel pendaftar dan statistik kuota
     */
    public function dataPendaftar(Request $request)
    {
        // 1. Inisialisasi Query untuk Tabel Pendaftar (Filter Utama: deleted_at NULL)
        $query = DB::table('registrasi_pelatihan')->whereNull('deleted_at');

        // Fitur Filter Kegiatan (Dropdown filter di tabel)
        if ($request->has('kegiatan') && $request->kegiatan != '') {
            $query->where('nama_kegiatan', $request->kegiatan);
        }

        $pendaftar = $query->orderBy('created_at', 'desc')->get();
        
        // 2. Ambil daftar kegiatan unik untuk dropdown filter di view
        // Diambil dari list_kegiatan agar konsisten dengan master data
        $list_kegiatan = DB::table('list_kegiatan')->pluck('nama_kegiatan');

        // 3. LOGIKA STATISTIK: Menghitung kuota (Perbaikan error baris 19)
        $statistik = DB::table('list_kegiatan')
            ->where('status', 'aktif')
            ->get()
            ->map(function ($kegiatan) {
                // Hitung jumlah pendaftar per kegiatan yang tidak dihapus
                $terisi = DB::table('registrasi_pelatihan')
                    ->where('nama_kegiatan', $kegiatan->nama_kegiatan)
                    ->whereNull('deleted_at')
                    ->count();

                return (object) [ // Mengubah ke object agar mudah dipanggil dengan $stat->nama di blade
                    'nama'       => $kegiatan->nama_kegiatan,
                    'kuota'      => $kegiatan->kuota_peserta,
                    'terisi'     => $terisi,
                    'sisa'       => $kegiatan->kuota_peserta - $terisi,
                    'persentase' => $kegiatan->kuota_peserta > 0 
                                    ? round(($terisi / $kegiatan->kuota_peserta) * 100) 
                                    : 0
                ];
            });

        // 4. Mengirim semua data ke view yang sama
        return view('admin.pendaftar', compact('pendaftar', 'list_kegiatan', 'statistik'));
    }

    /**
     * Sisa method di bawah ini tetap sama (index dihapus/digabung ke dataPendaftar)
     */

    public function recycleBin()
    {
        $pendaftar = DB::table('registrasi_pelatihan')
            ->whereNotNull('deleted_at')
            ->orderBy('deleted_at', 'desc')
            ->get();

        return view('admin.recycle_bin', compact('pendaftar'));
    }

    public function restore($id)
    {
        try {
            DB::table('registrasi_pelatihan')->where('id', $id)->update(['deleted_at' => null]);
            return redirect()->route('admin.recycle')->with('success', 'Data pendaftar berhasil dipulihkan.');
        } catch (Exception $e) {
            return back()->with('error', 'Gagal mempulihkan data: ' . $e->getMessage());
        }
    }

    public function forceDelete($id)
    {
        try {
            DB::table('registrasi_pelatihan')->where('id', $id)->delete();
            return redirect()->route('admin.recycle')->with('success', 'Data telah dihapus permanen dari sistem.');
        } catch (Exception $e) {
            return back()->with('error', 'Gagal menghapus permanen: ' . $e->getMessage());
        }
    }

    public function store(Request $request) 
    {
        $request->validate([
            'nik'               => 'required|numeric|digits:16',
            'nib'               => 'required|numeric|digits:13',
            'foto_ktp'          => 'required|image|max:5120',
            'nama_lengkap'      => 'required|string|max:255',
            'whatsapp'          => 'required|string|max:20',
            'email'             => 'required|email|max:255',
            'nama_usaha'        => 'required|string|max:255',
            'tanggal_lahir'     => 'required|date',
            'level_digital'     => 'required|string',
            'target_6_bulan'    => 'required|string',
            'alamat_usaha'      => 'required|string|max:500',
            'kecamatan'         => 'required|string',
            'kelurahan'         => 'required|string',
        ]);

        try {
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
                    throw new Exception("Gagal upload ke ImgBB: " . $response->reason());
                }
            }

            $tantangan = $request->input('tantangan', []);
            $media = $request->input('media', []);
            $omzetClean = str_replace('.', '', $request->omzet_bulanan ?? 0);

            DB::table('registrasi_pelatihan')->insert([
                'nama_kegiatan'        => $request->nama_kegiatan,
                'nama_lengkap'         => $request->nama_lengkap,
                'nik'                  => $request->nik,
                'nib'                  => $request->nib,
                'email'                => $request->email,
                'whatsapp'             => $request->whatsapp,
                'jenis_kelamin'        => $request->jenis_kelamin,
                'tanggal_lahir'        => $request->tanggal_lahir ?? '2000-01-01',
                'foto_ktp'             => $uploadKtp,
                'nama_usaha'           => $request->nama_usaha,
                'alamat_usaha'         => $request->alamat_usaha,
                'kota'                 => $request->input('kota', 'Kota Madiun'),
                'kelurahan'            => $request->kelurahan,
                'kecamatan'            => $request->kecamatan,
                'jenis_usaha'          => $request->jenis_usaha,
                'tahun_mulai'          => $request->tahun_mulai,
                'skala_usaha'          => $request->skala_usaha,
                'omzet_bulanan'        => $omzetClean, 
                'stabilitas_omzet'     => $request->stabilitas_omzet,
                'tantangan_usaha'      => json_encode($tantangan),
                'media_penjualan'      => json_encode($media),
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

            return back()->with('success', 'Pendaftaran BERHASIL!');
        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Gagal memproses: ' . $e->getMessage());
        }
    }

    public function exportExcel()
    {
        try {
            return Excel::download(new PendaftarExport, 'data_pendaftar_ikm_aktif.xlsx');
        } catch (Exception $e) {
            return back()->with('error', 'Gagal ekspor excel: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('registrasi_pelatihan')->where('id', $id)->update(['deleted_at' => now()]);
            return redirect()->route('admin.pendaftar')->with('success', 'Data pendaftar dipindahkan ke Recycle Bin.');
        } catch (Exception $e) {
            return back()->with('error', 'Gagal membuang data: ' . $e->getMessage());
        }
    }

    public function formulir()
    {
        $list_kegiatan = DB::table('list_kegiatan')->where('status', 'aktif')->get();
        return view('pendaftaran', compact('list_kegiatan'));
    }
}
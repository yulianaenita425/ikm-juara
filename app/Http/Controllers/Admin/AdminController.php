<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PelakuUsaha;
use App\Models\Kegiatan; // Model untuk jumlah kegiatan
use App\Models\Pendaftar; // Model untuk jumlah pendaftar
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
public function publikasi()
{
    // JANGAN tambahkan ->where('is_active', 1) di sini
    $publikasi = DB::table('publikasi')->orderBy('tanggal', 'desc')->get();
    return view('admin.publikasi', compact('publikasi'));
}

public function toggle($id)
{
    // Mengambil data dari tabel publikasi
    $publikasi = \DB::table('publikasi')->where('id', $id)->first();
    
    if ($publikasi) {
        \DB::table('publikasi')->where('id', $id)->update([
            // Membalikkan nilai is_active
            'is_active' => !$publikasi->is_active,
            'updated_at' => now()
        ]);
        return back()->with('success', 'Status berhasil diperbarui!');
    }
    
    return back()->with('error', 'Data tidak ditemukan.');
}

    public function storePublikasi(Request $request) 
    {
        $request->validate([
            'judul'     => 'required',
            'deskripsi' => 'required',
            'gambar'    => 'required|image|max:2048'
        ]);

        $imageUrl = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $response = Http::asMultipart()->post('https://api.imgbb.com/1/upload', [
                'key'   => env('IMGBB_API_KEY'),
                'image' => base64_encode(file_get_contents($file->path())),
            ]);

            if ($response->successful()) {
                $imageUrl = $response->json()['data']['url'];
            } else {
                return redirect()->back()->with('error', 'Gagal upload ke ImgBB. Periksa API Key.');
            }
        }

        if ($imageUrl) {
            DB::table('publikasi')->insert([
                'judul'      => $request->judul,
                'gambar'     => $imageUrl,
                'tanggal'    => $request->tanggal,
                'waktu'      => $request->waktu,
                'deskripsi'  => $request->deskripsi,
                'status'     => $request->status,
                'is_active'  => $request->is_active,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            return redirect()->back()->with('success', 'Berita berhasil diterbitkan!');
        }
        return redirect()->back()->with('error', 'Gambar gagal diproses.');
    }

    public function deletePublikasi($id)
    {
        DB::table('publikasi')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Berita berhasil dihapus!');
    }
public function dashboardAdmin()
{
    // Mengambil data statistik dari tabel yang sesuai di database
    $totalPelakuUsaha = DB::table('pelaku_usaha')->count();
    $totalAdmin = DB::table('users')->count();
    $totalKegiatan = DB::table('list_kegiatan')->count();
    $totalPendaftar = DB::table('registrasi_pelatihan')->count();

    // Data untuk grafik (Seperangkat data kecamatan/kelurahan)
$dataKecamatan = DB::table('pelaku_usaha')
        ->select('kecamatan', DB::raw('count(*) as total'))
        ->groupBy('kecamatan')
        ->get();
        // SOLUSI image_994985.png: Ambil data untuk Grafik Kelurahan
    $Kelurahan = DB::table('pelaku_usaha')
        ->select('kelurahan', DB::raw('count(*) as total'))
        ->groupBy('kelurahan')
        ->get();

    // Mengirimkan SEMUA variabel ke dashboard.blade.php
return view('admin.dashboard', compact(
        'totalPelakuUsaha', 
        'totalAdmin', 
        'totalKegiatan', 
        'totalPendaftar',
        'dataKecamatan',
        'Kelurahan',
    ));
}
public function settings() {
    $users = User::all();
    $totalIkm = DB::table('pelaku_usaha')->count(); 
    $totalAdmin = User::count();
    $totalKegiatan = DB::table('list_kegiatan')->count();
    return view('admin.pengaturan', compact('users', 'totalIkm', 'totalAdmin', 'totalKegiatan'));
    }

    /**
     * Alias untuk fungsi settings jika rute lain memanggil 'index' atau 'pengaturan'
     */
    public function index() { return $this->settings(); }
    public function pengaturan() { return $this->settings(); }

    /**
     * Menyimpan administrator baru ke database.
     * Menggunakan validasi yang paling ketat dari baris kode sebelumnya.
     */
    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        return redirect()->back()->with('success', 'Administrator baru berhasil ditambahkan!');
    }

    /**
     * Menghapus administrator dengan proteksi berlapis.
     * Fitur: Tidak bisa hapus diri sendiri & tidak bisa hapus admin terakhir.
     */
    public function deleteAdmin($id)
    {
        $user = User::findOrFail($id);
        
        // FITUR 1: Mencegah admin menghapus dirinya sendiri
        if (Auth::id() == $user->id) {
            return redirect()->back()->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }

        // FITUR 2: Mencegah penghapusan jika hanya tersisa satu admin di sistem
        if (User::count() <= 1) {
            return redirect()->back()->with('error', 'Tidak bisa menghapus administrator terakhir di sistem!');
        }

        $user->delete();
        return redirect()->back()->with('success', 'Akun administrator berhasil dihapus!');
    }
public function updateAdmin(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'username' => 'required|string|unique:users,username,' . $id,
        'password' => 'nullable|min:6', // Password boleh kosong saat edit
    ]);

    $user = User::findOrFail($id);
    $user->name = $request->name;
    $user->username = $request->username;

    // Hanya update password jika inputan password diisi
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return redirect()->back()->with('success', 'Data Administrator berhasil diperbarui!');
}
}
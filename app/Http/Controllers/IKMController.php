<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Konsultasi; // Pastikan ini ada untuk memanggil "gudang" data

class IKMController extends Controller
{
    // Fungsi 1: Untuk menampilkan halaman beranda
public function index()
{
    // Mengambil SEMUA data dari tabel konsultasi, urutkan dari yang terbaru
    $semua_pendaftar = Konsultasi::latest()->get();

    return view('beranda', [
        'nama_aplikasi' => 'Inovasi IKM Juara',
        'layanan' => ['Konsultasi Legalitas', 'Pelatihan IKM', 'Pendaftaran Sertifikasi'],
        'pendaftar' => $semua_pendaftar // Kirim data pendaftar ke View
    ]);
}

    // Fungsi 2: Untuk memproses penyimpanan data (Harus di luar fungsi index)
    public function simpan(Request $request) 
    {
        // Proses memasukkan data ke tabel 'konsultasi'
        Konsultasi::create([
            'nama_ikm' => $request->nama_ikm,
            'jenis_usaha' => $request->jenis_usaha,
            'keluhan' => $request->keluhan,
        ]);

        // Setelah simpan, balik lagi ke halaman depan sambil bawa pesan sukses
        return redirect('/')->with('sukses', 'Data Anda berhasil dikirim! Tim IKM Juara akan menghubungi Anda.');
    }
}
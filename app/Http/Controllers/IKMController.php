<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Konsultasi; 

class IKMController extends Controller
{
    // Menampilkan halaman beranda
    public function index()
    {
        $semua_pendaftar = Konsultasi::latest()->get();

        return view('beranda', [
            'nama_aplikasi' => 'Inovasi IKM Juara',
            'layanan' => ['Konsultasi Legalitas', 'Pelatihan IKM', 'Pendaftaran Sertifikasi'],
            'pendaftar' => $semua_pendaftar 
        ]);
    }

    // Memproses pendaftaran dari form
    public function simpan(Request $request) 
    {
        Konsultasi::create([
            'nama_ikm' => $request->nama_ikm,
            'jenis_usaha' => $request->jenis_usaha,
            'keluhan' => $request->keluhan,
        ]);

        return redirect('/')->with('sukses', 'Data Anda berhasil dikirim!');
    }
    public function import(Request $request) 
    {
        // Validasi file
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        // Proses import menggunakan class yang sudah Anda buat di folder Imports
        Excel::import(new IKMImport, $request->file('file'));
        
        return redirect()->back()->with('success', 'Data Berhasil Diimport!');
    }

    public function export() 
    {
        return Excel::download(new IKMExport, 'data-ikm.xlsx');
    }
}
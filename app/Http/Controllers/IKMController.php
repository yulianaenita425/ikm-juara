<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Konsultasi;
use Illuminate\Support\Facades\DB; // Untuk statistik IKM
use Maatwebsite\Excel\Facades\Excel; // Penting: Jangan lupa import ini agar fitur excel tidak error
use App\Imports\IKMImport; // Pastikan namespace ini sesuai dengan file import Anda
use App\Exports\IKMExport; // Pastikan namespace ini sesuai dengan file export Anda

class IKMController extends Controller
{
// UPDATE FUNGSI INDEX (Untuk welcome.blade.php)
public function index()
{
    // Ambil data dari tabel statistik_kecamatan
    $stats = DB::table('statistik_kecamatan')->get();
    
    // Hitung total manual dari jumlah yang diinput admin
    $totalIkm = $stats->sum('jumlah_ikm');

    // Susun data untuk Chart
    $dataChart = [
        'Kartoharjo' => $stats->where('kecamatan', 'Kartoharjo')->first()->jumlah_ikm ?? 0,
        'Manguharjo' => $stats->where('kecamatan', 'Manguharjo')->first()->jumlah_ikm ?? 0,
        'Taman'      => $stats->where('kecamatan', 'Taman')->first()->jumlah_ikm ?? 0,
    ];

    // Ambil waktu update terakhir dari salah satu data
    $terakhirUpdate = $stats->max('updated_at');

    return view('welcome', compact('totalIkm', 'dataChart', 'terakhirUpdate'));
}

// Tambahkan di dalam class IKMController

public function halamanStatistik()
{
    // Mengambil data dari tabel statistik_kecamatan untuk ditampilkan di form
    $stats = DB::table('statistik_kecamatan')->get();
    
    return view('admin.statistik', compact('stats'));
}

// FUNGSI BARU UNTUK ADMIN (Simpan Input Manual)
public function updateStatistik(Request $request)
{
    foreach ($request->kecamatan as $nama_kec => $jumlah) {
        DB::table('statistik_kecamatan')
            ->where('kecamatan', $nama_kec)
            ->update([
                'jumlah_ikm' => $jumlah,
                'updated_at' => now()
            ]);
    }

    return redirect()->back()->with('success', 'Statistik berhasil diperbarui!');
}

    /**
     * Import Data Excel (Fitur Lama)
     */
    public function import(Request $request) 
    {
        // Validasi file
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        // Proses import menggunakan class IKMImport
        Excel::import(new IKMImport, $request->file('file'));
        
        return redirect()->back()->with('success', 'Data Berhasil Diimport!');
    }

    /**
     * Export Data Excel (Fitur Lama)
     */
    public function export() 
    {
        return Excel::download(new IKMExport, 'data-ikm.xlsx');
    }
}
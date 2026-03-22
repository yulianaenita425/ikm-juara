<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

// Impor Controller
use App\Http\Controllers\IKMController as PublicIKMController;
use App\Http\Controllers\Admin\IKMController as AdminIKMController;
use App\Http\Controllers\PelakuUsahaController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [PublicIKMController::class, 'index'])->name('home');
Route::get('/daftar', function () {
    return view('daftar');
})->name('daftar');
Route::post('/simpan-pendaftaran', [PublicIKMController::class, 'simpan'])->name('pendaftaran.simpan');

/*
|--------------------------------------------------------------------------
| Pelaku Usaha Routes (Manajemen Database)
|--------------------------------------------------------------------------
*/

// 1. Menampilkan Halaman Utama dengan Pagination
// Hapus Route::get('/pelaku-usaha', function() { ... }) yang lama, ganti jadi:
Route::get('/pelaku-usaha', [AdminIKMController::class, 'index'])->name('pelaku-usaha.index');

// 2. Simpan Data Baru (KOREKSI: Pengaman Skala Usaha & Email)
Route::post('/pelaku-usaha', function (Request $request) {
    $data = $request->except(['_token', '_method']);

    // Pindahkan tki ke tenaga_kerja jika ada, lalu hapus tki
    if (isset($data['tki'])) {
        $data['tenaga_kerja'] = $data['tki'];
    }
    unset($data['tki']); // WAJIB DIHAPUS

    $defaults = [
        'email'         => '-',
        'skala_usaha'   => 'Usaha Mikro',
        'nama_proyek'   => '-',
        'tenaga_kerja'  => 0,
        'nama_pemilik'  => '-',
        'nik'           => '-',
        'no_telp'       => '-',
        'tingkat_risiko'=> 'Rendah'
    ];

    foreach ($defaults as $field => $defaultValue) {
        if (empty($data[$field])) {
            $data[$field] = $defaultValue;
        }
    }

    DB::table('pelaku_usaha')->insert(array_merge($data, [
        'created_at' => now(),
        'updated_at' => now()
    ]));

    return redirect()->back()->with('success', 'Data Berhasil Ditambahkan!');
})->name('pelaku-usaha.store');

// 3. Update Data (DIBERSIHKAN DARI FIELD 'tki')
Route::put('/pelaku-usaha/{id}', function (Request $request, $id) {
    $data = $request->except(['id', '_token', '_method']);
    
    // 1. Penanganan Tenaga Kerja (TKI)
    if ($request->has('tki')) {
        $data['tenaga_kerja'] = $request->tki;
    }
    unset($data['tki']);

    // 2. Pengaman Default yang support angka '0'
    // Kita cek apakah input benar-benar tidak diisi (null atau string kosong)
    if (!isset($data['tenaga_kerja']) || $data['tenaga_kerja'] === '') $data['tenaga_kerja'] = 0;
    if (empty($data['nama_proyek'])) $data['nama_proyek'] = '-';
    
    // Khusus Email dan No HP agar bisa diisi 0 atau kosong
    if (!isset($data['email']) || $data['email'] === '') $data['email'] = '-';
    if (!isset($data['no_telp']) || $data['no_telp'] === '') $data['no_telp'] = '-';

    // 3. Eksekusi
    DB::table('pelaku_usaha')
        ->where('id', $id)
        ->update(array_merge($data, ['updated_at' => now()]));
        
    return redirect()->back()->with('success', 'Data Berhasil Diperbarui!');
})->name('pelaku-usaha.update');

// 4. Hapus Data
Route::delete('/pelaku-usaha/{id}', function ($id) {
    DB::table('pelaku_usaha')->where('id', $id)->delete();
    return redirect()->back()->with('success', 'Data Berhasil Dihapus!');
})->name('pelaku-usaha.destroy');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    Route::get('/login', function () { return view('admin.login'); })->name('admin.login');
    Route::get('/dashboard', function () { return view('admin.dashboard'); })->name('admin.dashboard');
    
    Route::get('/data-ikm', [AdminIKMController::class, 'index'])->name('admin.data-ikm');
    Route::post('/import-ikm', [AdminIKMController::class, 'import'])->name('admin.import-ikm');
    Route::get('/export-ikm', [AdminIKMController::class, 'export'])->name('admin.export-ikm');
    Route::get('/download-template', [AdminIKMController::class, 'downloadTemplate'])->name('admin.download-template');
});
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

// Impor Controller
use App\Http\Controllers\IKMController as PublicIKMController;
use App\Http\Controllers\Admin\IKMController as AdminIKMController;
use App\Http\Controllers\PendaftaranController;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Http\Controllers\KegiatanController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [PublicIKMController::class, 'index'])->name('home');

// Route Registrasi Umum
Route::get('/daftar', function () {
    return view('daftar');
})->name('daftar');

Route::post('/simpan-pendaftaran', [PublicIKMController::class, 'simpan'])->name('pendaftaran.simpan');

/*
|--------------------------------------------------------------------------
| Fitur: Pendaftaran Pelatihan UMKM (Sinkron dengan Step-Form & ImgBB)
|--------------------------------------------------------------------------
*/
// OPTIMASI: Mengarahkan ke Controller formulir agar data $list_kegiatan terisi
Route::get('/daftar-pelatihan', [PendaftaranController::class, 'formulir'])->name('pendaftaran.index');

// Memproses data dari form pendaftaran ke database & ImgBB
Route::post('/daftar-pelatihan', [PendaftaranController::class, 'store'])->name('pendaftaran.store');


/*
|--------------------------------------------------------------------------
| Pelaku Usaha Routes (Manajemen Database / CRUD Langsung)
|--------------------------------------------------------------------------
*/
// 1. Menampilkan Halaman Utama dengan Pagination
Route::get('/pelaku-usaha', [AdminIKMController::class, 'index'])->name('pelaku-usaha.index');

// 2. Simpan Data Baru
Route::post('/pelaku-usaha', function (Request $request) {
    $data = $request->except(['_token', '_method']);

    if (isset($data['tki'])) {
        $data['tenaga_kerja'] = $data['tki'];
    }
    unset($data['tki']); 

    $defaults = [
        'email'          => '-',
        'skala_usaha'    => 'Usaha Mikro',
        'nama_proyek'    => '-',
        'tenaga_kerja'   => 0,
        'nama_pemilik'   => '-',
        'nik'            => '-',
        'no_telp'        => '-',
        'tingkat_risiko' => 'Rendah'
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

// 3. Update Data
Route::put('/pelaku-usaha/{id}', function (Request $request, $id) {
    $data = $request->except(['id', '_token', '_method']);
    
    if ($request->has('tki')) {
        $data['tenaga_kerja'] = $request->tki;
    }
    unset($data['tki']);

    if (!isset($data['tenaga_kerja']) || $data['tenaga_kerja'] === '') $data['tenaga_kerja'] = 0;
    if (empty($data['nama_proyek'])) $data['nama_proyek'] = '-';
    if (!isset($data['email']) || $data['email'] === '') $data['email'] = '-';
    if (!isset($data['no_telp']) || $data['no_telp'] === '') $data['no_telp'] = '-';

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
| Admin Routes (Dashboard & Database Pendaftar)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    Route::get('/login', function () { return view('admin.login'); })->name('admin.login');
    Route::get('/dashboard', function () { return view('admin.dashboard'); })->name('admin.dashboard');
    
    Route::get('/data-ikm', [AdminIKMController::class, 'index'])->name('admin.data-ikm');
    Route::post('/import-ikm', [AdminIKMController::class, 'import'])->name('admin.import-ikm');
    Route::get('/export-ikm', [AdminIKMController::class, 'export'])->name('admin.export-ikm');
    Route::get('/download-template', [AdminIKMController::class, 'downloadTemplate'])->name('admin.download-template');

    // FITUR: Manajemen Pendaftar Pelatihan
    Route::get('/pendaftar', [PendaftaranController::class, 'dataPendaftar'])->name('admin.pendaftar');
    Route::get('/pendaftar/export', [PendaftaranController::class, 'exportExcel'])->name('admin.pendaftar.export');
    
    Route::get('/pendaftar/recycle-bin', [PendaftaranController::class, 'recycleBin'])->name('admin.recycle');
    Route::post('/pendaftar/restore/{id}', [PendaftaranController::class, 'restore'])->name('admin.restore');
    Route::delete('/pendaftar/force-delete/{id}', [PendaftaranController::class, 'forceDelete'])->name('admin.force_delete');
    Route::delete('/pendaftar/{id}', [PendaftaranController::class, 'destroy'])->name('admin.pendaftar.destroy');

    // Grouping Kegiatan
    Route::name('admin.')->group(function () {
        Route::get('/kegiatan', [KegiatanController::class, 'index'])->name('kegiatan.index'); // Tambahkan .index
        Route::post('/kegiatan/store', [KegiatanController::class, 'store'])->name('kegiatan.store');
        Route::delete('/kegiatan/{id}', [KegiatanController::class, 'destroy'])->name('kegiatan.destroy');
        
    // Contoh routing sederhana
Route::get('/admin/data-pendaftar', function () {
    return view('admin.pendaftar'); // Mengarah ke resources/views/admin/pendaftar.blade.php
})->name('admin.pendaftar');

    // Pastikan ada name('admin.kegiatan')
Route::get('/admin/kegiatan', [KegiatanController::class, 'index'])->name('admin.kegiatan');
        });
});

/*
|--------------------------------------------------------------------------
| Utility / Testing Routes
|--------------------------------------------------------------------------
*/
Route::get('/test-cloudinary', function () {
    try {
        $upload = Cloudinary::upload('https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_92x30dp.png', [
            'folder' => 'test_koneksi',
        ]);
        return "Berhasil Terhubung! URL: " . $upload->getSecurePath();
    } catch (\Exception $e) {
        return "Gagal Total: " . $e->getMessage();
    }
    
});
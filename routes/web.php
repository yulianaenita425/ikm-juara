<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

// Impor Controller
use App\Http\Controllers\IKMController as PublicIKMController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\IKMController as AdminIKMController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PublikasiController;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

/*
|--------------------------------------------------------------------------
| AUTHENTICATION & BYPASS
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/masuk-sekarang', function() {
    $user = \App\Models\User::first(); 
    if($user) {
        auth()->login($user);
        return redirect()->route('admin.dashboard');
    }
    return "Database kosong, tidak ada user untuk login.";
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (PROTECTED)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // DASHBOARD - Menggunakan DashboardController agar lebih rapi
    Route::get('/dashboard', [AdminController::class, 'dashboardAdmin'])->name('dashboard');

    Route::get('/publikasi', [AdminController::class, 'publikasi'])->name('publikasi');
    Route::post('/publikasi/store', [AdminController::class, 'storePublikasi'])->name('publikasi.store');
    // Pastikan baris ini ada di routes/web.php
    Route::patch('/admin/publikasi/{id}/toggle', [\App\Http\Controllers\Admin\AdminController::class, 'toggle'])->name('admin.publikasi.toggle');
    Route::delete('/publikasi/{id}', [AdminController::class, 'destroyPublikasi'])->name('publikasi.destroy');

    // DATA IKM & Import/Export (Fitur Lama)
    Route::get('/data-ikm', [AdminIKMController::class, 'dataIkmAdmin'])->name('data-ikm');
    Route::post('/import-ikm', [AdminIKMController::class, 'import'])->name('import-ikm');
    Route::get('/export-ikm', [AdminIKMController::class, 'export'])->name('export-ikm');
    Route::get('/download-template', [AdminIKMController::class, 'downloadTemplate'])->name('download-template');

    // PENDAFTAR PELATIHAN (Fitur Lama)
    Route::get('/pendaftar', [PendaftaranController::class, 'dataPendaftar'])->name('pendaftar');
    Route::get('/pendaftar/export', [PendaftaranController::class, 'exportExcel'])->name('pendaftar.export');
    Route::get('/pendaftar/recycle-bin', [PendaftaranController::class, 'recycleBin'])->name('recycle');
    Route::post('/pendaftar/restore/{id}', [PendaftaranController::class, 'restore'])->name('restore');
    Route::delete('/pendaftar/force-delete/{id}', [PendaftaranController::class, 'forceDelete'])->name('force_delete');
    Route::delete('/pendaftar/{id}', [PendaftaranController::class, 'destroy'])->name('pendaftar.destroy');

    // KEGIATAN (Fitur Lama)
    Route::get('/kegiatan', [KegiatanController::class, 'index'])->name('kegiatan.index');
    Route::post('/kegiatan/store', [KegiatanController::class, 'store'])->name('kegiatan.store');
    Route::delete('/kegiatan/{id}', [KegiatanController::class, 'destroy'])->name('kegiatan.destroy');

    // PENGATURAN & ADMIN MANAGEMENT (Fitur Lama)
    Route::get('/pengaturan', [AdminController::class, 'settings'])->name('pengaturan');
    Route::post('/pengaturan/store', [AdminController::class, 'storeAdmin'])->name('users.store');
    Route::put('/pengaturan/update/{id}', [AdminController::class, 'updateAdmin'])->name('users.update');
    Route::delete('/pengaturan/destroy/{id}', [AdminController::class, 'deleteAdmin'])->name('users.destroy');

    // STATISTIK (Fitur Lama)
    Route::get('/statistik', [PublicIKMController::class, 'halamanStatistik'])->name('statistik');
    Route::post('/statistik/update', [PublicIKMController::class, 'updateStatistik'])->name('statistik.update');
});

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (Halaman Depan)
|--------------------------------------------------------------------------
*/
Route::get('/', [PublicIKMController::class, 'getStatistikManual'])->name('home');

Route::get('/daftar', function () {
    $kegiatan = DB::table('list_kegiatan')
                ->where('is_active', 1) 
                ->orderBy('id', 'desc')
                ->get();
    return view('pendaftaran', compact('kegiatan'));
})->name('daftar');

Route::post('/simpan-pendaftaran', [PublicIKMController::class, 'simpan'])->name('pendaftaran.simpan');
Route::get('/daftar-pelatihan', [PendaftaranController::class, 'formulir'])->name('pendaftaran.index');
Route::post('/daftar-pelatihan', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
Route::get('/welcome', function () { return view('welcome'); });

/*
|--------------------------------------------------------------------------
| CRUD PELAKU USAHA (Direct DB Update)
|--------------------------------------------------------------------------
*/
Route::get('/pelaku-usaha', [AdminIKMController::class, 'index'])->name('pelaku-usaha.index');

Route::post('/pelaku-usaha', function (Request $request) {
    $data = $request->except(['_token', '_method']);
    if (isset($data['tki'])) { $data['tenaga_kerja'] = $data['tki']; }
    unset($data['tki']); 
    DB::table('pelaku_usaha')->insert(array_merge($data, [
        'created_at' => now(), 
        'updated_at' => now()
    ]));
    return redirect()->back()->with('success', 'Data Berhasil Ditambahkan!');
})->name('pelaku-usaha.store');

Route::put('/pelaku-usaha/{id}', function (Request $request, $id) {
    $data = $request->except(['id', '_token', '_method']);
    DB::table('pelaku_usaha')->where('id', $id)->update(array_merge($data, [
        'updated_at' => now()
    ]));
    return redirect()->back()->with('success', 'Data Berhasil Diperbarui!');
})->name('pelaku-usaha.update');

Route::delete('/pelaku-usaha/{id}', function ($id) {
    DB::table('pelaku_usaha')->where('id', $id)->delete();
    return redirect()->back()->with('success', 'Data Berhasil Dihapus!');
})->name('pelaku-usaha.destroy');

Route::get('/profil', function () { return view('profil');})->name('profil');
Route::get('/profil-dinas', function () { return view('profil-dinas');})->name('profil-dinas');
Route::get('/alur-pendaftaran', function () { return view('alur-pendaftaran'); })->name('alur-pendaftaran');
Route::get('/faq', function () { return view('faq'); })->name('faq');

/*
|--------------------------------------------------------------------------
| UTILITY & DEBUG
|--------------------------------------------------------------------------
*/
Route::get('/cek-db', function() {
    try {
        $user = User::all();
        return response()->json(['status' => 'Koneksi DB Oke', 'data' => $user]);
    } catch (\Exception $e) { 
        return "Gagal koneksi: " . $e->getMessage(); 
    }
});
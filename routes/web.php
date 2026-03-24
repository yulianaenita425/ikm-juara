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
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

/*
|--------------------------------------------------------------------------
| BYPASS LOGIN (Gunakan ini jika Form Login Error)
|--------------------------------------------------------------------------
*/
Route::get('/masuk-sekarang', function() {
    // Ambil user pertama yang ada di database (pasti ada 'admin')
    $user = \App\Models\User::first(); 
    
    if($user) {
        auth()->login($user);
        return redirect('/admin/dashboard');
    }
    return "Database kosong, tidak ada user untuk login.";
});

/*
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (PROTECTED)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Data IKM & Import/Export
    Route::get('/data-ikm', [AdminIKMController::class, 'index'])->name('admin.data-ikm');
    Route::post('/import-ikm', [AdminIKMController::class, 'import'])->name('admin.import-ikm');
    Route::get('/export-ikm', [AdminIKMController::class, 'export'])->name('admin.export-ikm');
    Route::get('/download-template', [AdminIKMController::class, 'downloadTemplate'])->name('admin.download-template');

    // Pendaftar Pelatihan
    Route::get('/pendaftar', [PendaftaranController::class, 'dataPendaftar'])->name('admin.pendaftar');
    Route::get('/pendaftar/export', [PendaftaranController::class, 'exportExcel'])->name('admin.pendaftar.export');
    Route::get('/pendaftar/recycle-bin', [PendaftaranController::class, 'recycleBin'])->name('admin.recycle');
    Route::post('/pendaftar/restore/{id}', [PendaftaranController::class, 'restore'])->name('admin.restore');
    Route::delete('/pendaftar/force-delete/{id}', [PendaftaranController::class, 'forceDelete'])->name('admin.force_delete');
    Route::delete('/pendaftar/{id}', [PendaftaranController::class, 'destroy'])->name('admin.pendaftar.destroy');

    // Kegiatan
    Route::get('/kegiatan', [KegiatanController::class, 'index'])->name('admin.kegiatan.index');
    Route::post('/kegiatan/store', [KegiatanController::class, 'store'])->name('admin.kegiatan.store');
    Route::delete('/kegiatan/{id}', [KegiatanController::class, 'destroy'])->name('admin.kegiatan.destroy');

    // Pengaturan
    Route::get('/pengaturan', [AdminController::class, 'settings'])->name('admin.pengaturan');
    Route::post('/pengaturan', [AdminController::class, 'storeAdmin'])->name('admin.store');
    Route::delete('/pengaturan/{id}', [AdminController::class, 'deleteAdmin'])->name('admin.delete');
});

/*
|--------------------------------------------------------------------------
| PUBLIC & CRUD ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', [PublicIKMController::class, 'index'])->name('home');
Route::get('/daftar', function () { return view('daftar'); })->name('daftar');
Route::post('/simpan-pendaftaran', [PublicIKMController::class, 'simpan'])->name('pendaftaran.simpan');
Route::get('/daftar-pelatihan', [PendaftaranController::class, 'formulir'])->name('pendaftaran.index');
Route::post('/daftar-pelatihan', [PendaftaranController::class, 'store'])->name('pendaftaran.store');

// CRUD Pelaku Usaha
Route::get('/pelaku-usaha', [AdminIKMController::class, 'index'])->name('pelaku-usaha.index');
Route::post('/pelaku-usaha', function (Request $request) {
    $data = $request->except(['_token', '_method']);
    if (isset($data['tki'])) { $data['tenaga_kerja'] = $data['tki']; }
    unset($data['tki']); 
    DB::table('pelaku_usaha')->insert(array_merge($data, ['created_at' => now(), 'updated_at' => now()]));
    return redirect()->back()->with('success', 'Data Berhasil Ditambahkan!');
})->name('pelaku-usaha.store');

Route::put('/pelaku-usaha/{id}', function (Request $request, $id) {
    $data = $request->except(['id', '_token', '_method']);
    DB::table('pelaku_usaha')->where('id', $id)->update(array_merge($data, ['updated_at' => now()]));
    return redirect()->back()->with('success', 'Data Berhasil Diperbarui!');
})->name('pelaku-usaha.update');

Route::delete('/pelaku-usaha/{id}', function ($id) {
    DB::table('pelaku_usaha')->where('id', $id)->delete();
    return redirect()->back()->with('success', 'Data Berhasil Dihapus!');
})->name('pelaku-usaha.destroy');

/*
|--------------------------------------------------------------------------
| UTILITY
|--------------------------------------------------------------------------
*/
Route::get('/cek-db', function() {
    try {
        $user = User::all();
        return response()->json(['status' => 'Koneksi DB Oke', 'data' => $user]);
    } catch (\Exception $e) { return "Gagal koneksi: " . $e->getMessage(); }
});
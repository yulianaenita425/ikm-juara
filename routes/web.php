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
Route::middleware(['auth'])->prefix('admin')->group(function () {
    
    // DASHBOARD
    Route::get('/dashboard', [AdminController::class, 'dashboardAdmin'])->name('admin.dashboard');
    
// Manajemen Publikasi
Route::get('/publikasi', [AdminController::class, 'publikasi'])->name('admin.publikasi');
Route::post('/publikasi/store', [AdminController::class, 'storePublikasi'])->name('admin.publikasi.store');
Route::delete('/publikasi/destroy/{id}', [AdminController::class, 'deletePublikasi'])->name('admin.publikasi.destroy');

    // DATA IKM & Import/Export
    Route::get('/data-ikm', [AdminIKMController::class, 'dataIkmAdmin'])->name('admin.data-ikm');
    Route::post('/import-ikm', [AdminIKMController::class, 'import'])->name('admin.import-ikm');
    Route::get('/export-ikm', [AdminIKMController::class, 'export'])->name('admin.export-ikm');
    Route::get('/download-template', [AdminIKMController::class, 'downloadTemplate'])->name('admin.download-template');

    // PENDAFTAR PELATIHAN
    Route::get('/pendaftar', [PendaftaranController::class, 'dataPendaftar'])->name('admin.pendaftar');
    Route::get('/pendaftar/export', [PendaftaranController::class, 'exportExcel'])->name('admin.pendaftar.export');
    Route::get('/pendaftar/recycle-bin', [PendaftaranController::class, 'recycleBin'])->name('admin.recycle');
    Route::post('/pendaftar/restore/{id}', [PendaftaranController::class, 'restore'])->name('admin.restore');
    Route::delete('/pendaftar/force-delete/{id}', [PendaftaranController::class, 'forceDelete'])->name('admin.force_delete');
    Route::delete('/pendaftar/{id}', [PendaftaranController::class, 'destroy'])->name('admin.pendaftar.destroy');

    // KEGIATAN
    Route::get('/kegiatan', [KegiatanController::class, 'index'])->name('admin.kegiatan.index');
    Route::post('/kegiatan/store', [KegiatanController::class, 'store'])->name('admin.kegiatan.store');
    Route::delete('/kegiatan/{id}', [KegiatanController::class, 'destroy'])->name('admin.kegiatan.destroy');

    // PENGATURAN & ADMIN MANAGEMENT
    Route::get('/pengaturan', [AdminController::class, 'settings'])->name('admin.pengaturan');
    Route::post('/pengaturan/store', [AdminController::class, 'storeAdmin'])->name('admin.users.store');
    Route::put('/pengaturan/update/{id}', [AdminController::class, 'updateAdmin'])->name('admin.users.update');
    Route::delete('/pengaturan/destroy/{id}', [AdminController::class, 'deleteAdmin'])->name('admin.users.destroy');

    // STATISTIK (MANUAL)
    Route::get('/statistik', [PublicIKMController::class, 'halamanStatistik'])->name('admin.statistik');
    Route::post('/statistik/update', [PublicIKMController::class, 'updateStatistik'])->name('admin.statistik.update');
});

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (Halaman Depan)
|--------------------------------------------------------------------------
| KOREKSI: Gunakan getStatistikManual agar data 460 muncul.
*/
Route::get('/', [PublicIKMController::class, 'getStatistikManual'])->name('home');

Route::get('/daftar', function () {
    $kegiatan = DB::table('list_kegiatan')->get(); 
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

<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

// Alias untuk Controller
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
| Pelaku Usaha Routes (Manajemen Database Pelaku Usaha)
|--------------------------------------------------------------------------
*/

// 1. Menampilkan Halaman Pelaku Usaha dengan Pagination 50
Route::get('/pelaku-usaha', function () {
    $data = DB::table('pelaku_usaha')
              ->orderBy('id', 'desc')
              ->paginate(50);

    return view('admin.pelaku_usaha.index', compact('data'));
})->name('pelaku-usaha.index');

// 2. Simpan Data Baru
Route::post('/pelaku-usaha/store', function (Request $request) {
    $request->validate([
        'nib' => 'required|numeric|digits:13',
        'nik' => 'required|numeric|digits:16',
        'kbli' => 'required|numeric|digits:5',
        'email' => 'required|email',
        'investasi' => 'required|numeric',
        'tenaga_kerja' => 'required|numeric',
        'tgl_terbit' => 'required|date',
        'nama_perusahaan' => 'required',
        'nama_pemilik' => 'required',
    ]);

    DB::table('pelaku_usaha')->insert([
        'nib'              => $request->nib,
        'nik'              => $request->nik,
        'skala_usaha'      => $request->skala_usaha,
        'jenis_perusahaan' => $request->jenis_perusahaan,
        'nama_perusahaan'  => $request->nama_perusahaan,
        'nama_proyek'      => $request->nama_proyek,
        'nama_pemilik'     => $request->nama_pemilik,
        'alamat_usaha'     => $request->alamat_usaha,
        'kecamatan'        => $request->kecamatan,
        'kelurahan'        => $request->kelurahan,
        'kbli'             => $request->kbli,
        'uraian_kbli'      => $request->uraian_kbli,
        'tingkat_risiko'   => $request->tingkat_risiko,
        'investasi'        => $request->investasi,
        'tenaga_kerja'     => $request->tenaga_kerja,
        'no_telp'          => $request->no_telp,
        'email'            => $request->email,
        'tgl_terbit'       => $request->tgl_terbit,
        'created_at'       => now(),
        'updated_at'       => now(),
    ]);

    return redirect()->back()->with('success', 'Data Berhasil Disimpan!');
})->name('pelaku-usaha.store');

// 3. Update Data Berdasarkan ID (OPTIMASI: Mendukung POST & PUT)
Route::match(['post', 'put'], '/pelaku-usaha/update/{id}', function (Request $request, $id) {
    try {
        // Melakukan update data
        DB::table('pelaku_usaha')
            ->where('id', $id)
            ->update(array_merge(
                $request->except(['id', '_token', '_method']),
                ['updated_at' => now()]
            ));
            
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Data updated']);
        }
        return redirect()->back()->with('success', 'Data Berhasil Diperbarui!');
        
    } catch (\Exception $e) {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
        return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
})->name('pelaku-usaha.update');

// 4. Hapus Data Permanen
Route::delete('/pelaku-usaha/delete/{id}', function ($id) {
    DB::table('pelaku_usaha')->where('id', $id)->delete();
    return response()->json(['success' => true]);
})->name('pelaku-usaha.destroy');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {
    
    Route::get('/login', function () {
        return view('admin.login');
    })->name('admin.login');

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/data-ikm', [AdminIKMController::class, 'index'])->name('admin.data-ikm');
    // Pastikan seperti ini di web.php
Route::post('/import-ikm', [AdminIKMController::class, 'import'])->name('admin.import-ikm');
    Route::get('/export-ikm', [AdminIKMController::class, 'export'])->name('admin.export-ikm');
    
    Route::get('/download-template', [AdminIKMController::class, 'downloadTemplate'])->name('admin.download-template');

    Route::get('/', function () {
        $data = DB::table('pelaku_usaha')->orderBy('id', 'desc')->paginate(50);
        return view('admin.pelaku_usaha.index', compact('data'));
    });
});

Route::resource('pelaku-usaha-resource', PelakuUsahaController::class)->names('pelaku-usaha-res');
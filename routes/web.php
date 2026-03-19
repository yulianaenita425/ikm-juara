<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IKMController; // Import Controller Anda

Route::get('/', [IKMController::class, 'index']);
Route::post('/simpan-konsultasi', [IKMController::class, 'simpan']);
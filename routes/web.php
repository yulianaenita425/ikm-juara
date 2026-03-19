<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome'); // Ganti 'welcome' menjadi 'landing' jika nama filenya landing.blade.php
});
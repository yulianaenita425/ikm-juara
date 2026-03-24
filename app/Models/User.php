<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users'; // Memastikan tabel yang dibaca adalah 'users'

    protected $fillable = [
        'name',
        'username', // Menambahkan username agar bisa diisi
        'password',
        'role',
    ];
// TAMBAHKAN INI: Memberitahu Laravel kolom login adalah username
    public function getAuthIdentifierName()
    {
        return 'username';
    }
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // PENTING: Jika password di DB tidak menggunakan kolom 'password', tentukan di sini.
    // Tapi karena kolom Anda sudah bernama 'password', ini sudah aman.
}
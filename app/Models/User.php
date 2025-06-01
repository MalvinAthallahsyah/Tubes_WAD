<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    // Ini buat pake fitur factory, notifikasi, dll
    use HasFactory, Notifiable;

    /**
     * Kolom-kolom yang boleh diisi pake User::create
     * Ini penting, biar ga sembarang kolom bisa diisi
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Kolom-kolom yang dirahasiakan (ga muncul waktu dijadiin JSON/array)
     * Penting buat nyembunyiin data sensitif kayak password
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Kalo mau tambah method lain, tulis di sini
    // Misalnya relasi ke tabel lain, dll
}

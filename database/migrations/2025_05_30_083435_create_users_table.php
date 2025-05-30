<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Ini class buat bikin tabel users ya
return new class extends Migration
{
    // Ini fungsi buat bikin tabel
    public function up(): void
    {
        // Bikin tabel namanya 'users'
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });
    }

    // Ini fungsi kalo mau rollback (hapus tabel)
    public function down(): void
    {
        // Hapus tabel users
        Schema::dropIfExists('users');
    }
};

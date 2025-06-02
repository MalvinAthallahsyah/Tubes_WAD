<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Cek dulu, admin 'admin1@email.com' udah ada di database apa belum
        // Biar gak dobel datanya kalau seeder-nya dijalanin berkali-kali
        $adminYangSudahAda = User::where('email', 'admin1@email.com')->first();

        // Kalau '$adminYangSudahAda' itu kosong (artinya adminnya belum ada), baru kita buat
        if (!$adminYangSudahAda) {
            // Bikin data admin baru pakai User::create()
            User::create([
                'name' => 'Admin Satu',
                'email' => 'admin1@email.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',

                'nim' => 'ADMIN001',
                'phone' => '081234567890',
            ]);

            // Kasih feedback di console kalau admin berhasil dibuat
            $this->command->info('Admin user (admin1@email.com) successfully added');

        } else {
            // If the admin already exists, inform in the console
            $this->command->info('Admin user (admin1@email.com) already exists, nothing added');
        }

        // INFO
        // Kalau mau nambahin user dummy lain buat testing, bisa di sini
        // Contohnya udah ada di bawah, tinggal di-uncomment aja kalau perlu

        /*
        User::create([
            'name' => 'User Tes Satu',
            'email' => 'tes@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user', // Pastikan role-nya 'user'
            'email_verified_at' => now(),
        ]);
        $this->command->info('User tes (tes@example.com) berhasil ditambahkan.');
        */
    }
}

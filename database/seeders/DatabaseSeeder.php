<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// Pastikan Anda juga meng-import CategorySeeder jika belum
// use Database\Seeders\CategorySeeder; // Laravel 10+ biasanya tidak perlu import eksplisit di sini jika namespace-nya benar

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // PANGGIL CATEGORY SEEDER DI SINI:
        $this->call([
            CategorySeeder::class,
            // Anda bisa menambahkan seeder lain di sini jika ada, contoh:
            // ProductSeeder::class,
        ]);
    }
}
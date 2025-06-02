<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// Tidak perlu import CategorySeeder secara eksplisit jika berada di namespace yang sama (Database\Seeders)
// Namun, jika Anda ingin lebih eksplisit, Anda bisa menambahkan:
// use Database\Seeders\CategorySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Membuat user factory (jika Anda memerlukannya)
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Panggil CategorySeeder Anda di sini:
        $this->call([
            CategorySeeder::class,
            // Anda bisa menambahkan seeder lain di sini jika ada di masa mendatang
            // Contoh: ProductSeeder::class,
        ]);
    }
}
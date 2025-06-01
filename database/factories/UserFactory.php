<?php

<<<<<<< HEAD
namespace Database\Factories; // Pastikan namespace ini benar

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash; // <--- TAMBAHKAN BARIS INI
=======
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
>>>>>>> origin/main

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
<<<<<<< HEAD
class UserFactory extends Factory // Pastikan nama class ini benar
{
    /**
=======
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
>>>>>>> origin/main
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
<<<<<<< HEAD
            'password' => Hash::make('password'), // <--- BARIS INI TELAH DIPERBAIKI
=======
            'password' => static::$password ??= Hash::make('password'),
>>>>>>> origin/main
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> origin/main

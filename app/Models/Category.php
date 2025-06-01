<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Opsional, jika Anda akan menggunakan factory
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory; // Opsional, jika Anda akan menggunakan factory

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'image_path',
        // 'slug', // Tambahkan 'slug' jika Anda menggunakannya di migrasi
    ];

    /**
     * Mendapatkan semua produk yang termasuk dalam kategori ini.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
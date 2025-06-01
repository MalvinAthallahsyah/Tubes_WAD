<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable // Using Authenticatable is fine even if auth is separate
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'nim',
        'phone',
        'faculty',
        'major',
        'bio',
        'street_address',
        'city',
        'province',
        'postal_code',
        'profile_photo',
    ];

    protected $hidden = [ // Standard practice
        'password',
        'remember_token',
    ];

    protected function casts(): array // For newer Laravel versions
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // role logic here:
    // public function isAdmin(): bool
    // {
    //     // return $this->role === 'admin'; // Example
    //     return false; // Placeholder
    // }
}

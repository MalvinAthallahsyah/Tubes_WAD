<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

// Ini middleware buat filter user biasa dan admin
class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Cek dulu usernya sudah login belum
        if (!auth()->check()) {
            // Kalau belum login, kembalikan ke halaman login
            return redirect('/login')->with('error', 'Please login first');
        }

        // Cek apakah user yang login punya role admin
        if (auth()->user()->role != 'admin') {
            // Kalau bukan admin, redirect ke dashboard biasa
            return redirect('/dashboard')->with('error', 'You are not authorized to access this page');
        }

        // Kalau admin, boleh lanjut ke halaman admin
        return $next($request);
    }
}

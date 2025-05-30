<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // Halaman yang dituju setelah register berhasil
    protected $redirectTo = '/home';

    /// Method buat nampilin form register
    public function showRegistrationForm()
    {
        // Cek manual aja, kalo udah login, ga boleh register lagi
        if (auth()->check()) {
            return redirect($this->redirectTo);
        }

        // Nampilin view register
        return view('auth.register');
    }

    /// Method buat proses register
    public function register(Request $request)
    {
        // Validasi data
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Bikin user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Login langsung
        auth()->login($user);

        // Redirect ke home
        return redirect($this->redirectTo);
    }
}

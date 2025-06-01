<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Ga perlu pake trait yang ribet

class LoginController extends Controller
{
    // Nah ini buat nentuin mau diarahin kemana abis login
    protected $redirectTo = '/dashboard';

    /// Ini method buat nampilin halaman login ya
    public function showLoginForm()
    {
        // Cek manual aja, kalo udah login, ga boleh akses halaman ini
        if (auth()->check()) {
            return redirect($this->redirectTo);
        }

        // Ini manggil view login.blade.php dari folder auth
        return view('auth.login');
    }

    /// Nah ini buat ngeproses data login dari form
    public function login(Request $request)
    {
        // Kalo udah login, ngapain login lagi WKKKWAK
        if (auth()->check()) {
            return redirect($this->redirectTo);
        }

        // Cek dulu datanya valid ga (DIUBAH INI)
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Ambil data dari form
        $email = $request->input('email');
        $password = $request->input('password');
        $remember = $request->has('remember'); // cek kotak remember di-klik ga

        // Coba login pake data yang dimasukin
        if (auth()->attempt(['email' => $email, 'password' => $password], $remember)) {
            // Kalo berhasil login

            // Update session dulu buat keamanan
            $request->session()->regenerate();

            // Balikin ke halaman home atau halaman yang diminta sebelumnya
            return redirect()->intended($this->redirectTo);
        }

        // Kalo gagal login, balikin ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'Invalid email or password. Please try again.',
        ])->withInput($request->only('email'));
    }

    /// Ini buat logout ya
    public function logout(Request $request)
    {
        // Kalo ga login, ngapain logout
        if (!auth()->check()) {
            return redirect('/login');
        }

        // Logout dulu
        auth()->logout();

        // Hapus session & bikin token baru
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Balik ke halaman utama
        return redirect('/login')->with('message', 'You have been logged out successfully.');
    }

    /// Ini buat nampilin halaman lupa password ya tapi asih belumm buat
    public function showForgotPasswordForm()
    {
        // Kalo udah login, ga perlu lupa password
        if (auth()->check()) {
            return redirect($this->redirectTo);
        }

        return view('auth.forgot-password');
    }
}

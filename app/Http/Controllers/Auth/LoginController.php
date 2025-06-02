<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth; // Uncomment jika belum ada dan dibutuhkan untuk auth()->user()

class LoginController extends Controller
{
    // Tujuan redirect default setelah login untuk user biasa
    protected $redirectTo = '/dashboard';

    public function showLoginForm()
    {
        if (auth()->check()) {
            return redirect($this->redirectTo);
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        if (auth()->check()) {
            return redirect($this->redirectTo);
        }

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password'); // Lebih ringkas ambil kredensial
        $remember = $request->filled('remember'); // pakai filled() untuk boolean

        if (auth()->attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = auth()->user(); // Ambil user yang login

            // Pastikan method isAdmin() ada di model User (app/Models/User.php)
            if ($user && $user->isAdmin()) {
                // Jika admin, arahkan ke dashboard admin
                return redirect()->route('admin.dashboard'); // Pastikan route 'admin.dashboard' ada
            }
            // Jika bukan admin, arahkan ke tujuan biasa
            return redirect()->intended($this->redirectTo);
        }

        return back()->withErrors([
            'email' => 'Invalid email or password. Please try again.',
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('message', 'You have been logged out successfully.');
    }

    public function showForgotPasswordForm()
    {
        if (auth()->check()) {
            return redirect($this->redirectTo);
        }
        return view('auth.forgot-password');
    }
}

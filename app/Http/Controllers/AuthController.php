<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Menampilkan form login.
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * Menangani permintaan login.
     */
    public function login(Request $request)
    {
        // 1. Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Coba untuk melakukan autentikasi
        if (Auth::attempt($credentials)) {
            // Jika berhasil, regenerate session
            $request->session()->regenerate();

            // 3. Redirect ke halaman home
            return redirect()->intended('home');
        }

        // 4. Jika gagal, kembali ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password yang diberikan tidak cocok.',
        ])->onlyInput('email');
    }

    /**
     * Menangani permintaan logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
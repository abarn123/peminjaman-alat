<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Menampilkan form login
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Memproses login user
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Redirect berdasarkan role
            if (Auth::user()->role == "admin") {
                return redirect('/admin/dashboard');
            }
            if (Auth::user()->role == "petugas") {
                return redirect('/petugas/dashboard');
            }
            // Default untuk role peminjam
            ActivityLog::record('Login', 'Pengguna melakukan login');
            return redirect('/peminjam/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.'
        ])->onlyInput('email');
    }

    /**
     * Memproses logout user
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }
}
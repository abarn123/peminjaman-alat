<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman form login.
     * 
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Menampilkan halaman registrasi
     * 
     *
     * @return \Illuminate\View\View
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Memproses login user.
     * Validasi email dan password, jika benar login dan redirect ke dashboard sesuai role
     * 
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validasi input email dan password dari form login
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Coba autentikasi dengan email dan password
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // klo berhasil(true), regenerate session ID untuk keamanan
            $request->session()->regenerate();

            // Redirect ke dashboard sesuai role user yang login
            if (Auth::user()->role == "admin") {
                return redirect('/admin/dashboard');
            }
            if (Auth::user()->role == "petugas") {
                return redirect('/petugas/dashboard');
            }
            
            // Default redirect untuk role peminjam
            ActivityLog::record('Login', 'Pengguna melakukan login');
            return redirect('/peminjam/dashboard');
        }

        // Jika autentikasi gagal, balikin ke form login
        return back()->withErrors([
            'email' => 'Email atau password salah.',
            'password' => 'password tidak sesuai'
        ])->onlyInput('email');
    }

        //Fungsi register - Memproses pendaftaran user baru
        /**
         * Memproses registrasi user baru.
         * Validasi input (nama, email, password), buat user baru dengan role default 'peminjam',
         * login otomatis, catat log aktivitas, lalu redirect ke halaman login.
         *
         * @param Request $request
         * @return \Illuminate\Http\RedirectResponse
         */
        public function register(Request $request)
            {
                // Validasi input: nama, email unik, password minimal 6 karakter dan confirmed
                $request->validate([
                    'name' => 'required|string|max:255',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required|min:6|confirmed',
                ]);

                // Buat user baru khusus peminjam
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),  // Hash password untuk keamanan
                    'role' => 'peminjam', 
                ]);

                // Login otomatis user yang baru terdaftar
                Auth::login($user);

                // Catat aktivitas registrasi ke log
                ActivityLog::record('Registrasi', 'Pengguna baru mendaftar: ' . $user->name);

                // Redirect ke halaman login dengan success message
                return redirect('login')->with('success', 'Akun berhasil dibuat, Silahkan login. ' .  '!');
            }

    /**
     * Memproses logout user.
     * Logout user dari session, invalidate session lama, generate token baru untuk keamanan,
     * lalu redirect ke halaman login.
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
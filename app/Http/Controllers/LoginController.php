<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password', 'role');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // VALIDASI ROLE
            if (auth()->user()->role !== $request->role) {
                Auth::logout();
                return back()->with([
                    'swal' => [
                        'icon'  => 'error',
                        'title' => 'Akses Ditolak',
                        'text'  => 'Role tidak sesuai dengan akun'
                    ]
                ]);
            }
            // REDIRECT + SWEETALERT
            if ($request->role === 'admin') {
                return redirect()->route('pemerintah.dashboard')->with([
                    'swal' => [
                        'icon'  => 'success',
                        'title' => 'Login Berhasil',
                        'text'  => 'Selamat datang Admin Pemerintah'
                    ]
                ]);
            }

            return redirect()->route('sekolah.dashboard')->with([
                'swal' => [
                    'icon'  => 'success',
                    'title' => 'Login Berhasil',
                    'text'  => 'Selamat datang di Dashboard Sekolah'
                ]
            ]);

        }

        return back()->with([
            'swal' => [
                'icon'  => 'error',
                'title' => 'Login Gagal',
                'text'  => 'Email atau password salah'
            ]
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
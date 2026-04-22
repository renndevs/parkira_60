<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LogAktivitas;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        // 1. tangkap dan validasi isian form dari user
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        // 2. suruh mesin Auth laravel nyocokin ke database
        if (Auth::attempt($credentials)) {
            // kalo cocok, buatin sesi baru (tiket masuk) biar aman dari hacker
            $request->session()->regenerate();

            // CATAT LOG LOGIN
            LogAktivitas::create([
                'id_user'   => Auth::id(),
                'aktivitas' => 'Berhasil Login ke dalam sistem',
                'waktu_aktivitas' => now()
            ]);

            // 3. CEK ROLE USER UNTUK MENGARAHKAN KE HALAMAN YANG BENAR
            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/dashboard');
            } elseif (Auth::user()->role === 'petugas') {
                return redirect()->intended('/transaksi');
            } elseif (Auth::user()->role === 'owner') {
                // INI TAMBAHANNYA BIAR OWNER BISA MASUK
                return redirect()->intended('/owner/laporan');
            }
        }

        // 3. kalo username/password salah, balikin ke halaman login bawa pesan error
        return back()->withErrors([
            'username' => 'username atau password salah nih!',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        // CATAT LOG LOGOUT (Taruh sebelum Auth::logout)
        LogAktivitas::create([
            'id_user'   => Auth::id(),
            'aktivitas' => 'Logout dari sistem',
            'waktu_aktivitas' => now()
        ]);

        // cabut tiket masuknya
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // lempar balik ke halaman login
        return redirect('/');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LogAktivitas;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            LogAktivitas::create([
                'id_user'   => Auth::id(),
                'aktivitas' => 'Berhasil Login ke dalam sistem',
                'waktu_aktivitas' => now()
            ]);

            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/dashboard');
            } elseif (Auth::user()->role === 'petugas') {
                return redirect()->intended('/transaksi');
            } elseif (Auth::user()->role === 'owner') {
                return redirect()->intended('/owner/laporan');
            }
        }

        return back()->withErrors([
            'username' => 'username atau password salah nih!',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        LogAktivitas::create([
            'id_user'   => Auth::id(),
            'aktivitas' => 'Logout dari sistem',
            'waktu_aktivitas' => now()
        ]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Manggil model tb_user
use Illuminate\Support\Facades\Hash; // Alat buat enkripsi password
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // 1. Fungsi buat nampilin data ke tabel
    public function index()
    {
        // Ambil semua data user
        $users = User::all();
        // Bawa datanya ke file kelolaAkun.blade.php
        return view('admin.kelolaAkun', compact('users'));
    }

    // 2. Fungsi buat nyimpen data dari form popup (modal)
    public function store(Request $request)
    {
        // Validasi simpel: pastikan gak ada yang kosong & username gak boleh kembar
        $request->validate([
            'nama_lengkap' => 'required',
            'username'     => 'required|unique:tb_user,username',
            'password'     => 'required',
            'role'         => 'required'
        ]);

        // Simpan langsung ke database
        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'username'     => $request->username,
            'password'     => Hash::make($request->password), // Password wajib di-hash!
            'role'         => $request->role,
        ]);

        // --- DI DALAM FUNGSI store ---
        LogAktivitas::create([
            'id_user'   => Auth::id(),
            'aktivitas' => 'Menambah akun pengguna baru: ' . $request->nama_lengkap . ' (' . $request->role . ')',
            'waktu_aktivitas' => now()
        ]);

        // Lempar balik ke halaman sebelumnya
        return back();
    }

    // 3. Fungsi Update Data
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'nama_lengkap' => $request->nama_lengkap,
            'username'     => $request->username,
            'role'         => $request->role,
        ]);

        // Jika password diisi, baru kita update passwordnya
        if ($request->password) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        // --- DI DALAM FUNGSI update ---
        LogAktivitas::create([
            'id_user'   => Auth::id(),
            'aktivitas' => 'Mengubah informasi akun: ' . $request->nama_lengkap,
            'waktu_aktivitas' => now()
        ]);

        return back();
    }

    // 4. Fungsi Hapus Data
    public function destroy($id)
    {
        // --- DI DALAM FUNGSI destroy ---
        // Ambil nama dulu sebelum datanya dihapus
        $userHapus = User::where('id_user', $id)->first();
        LogAktivitas::create([
            'id_user'   => Auth::id(),
            'aktivitas' => 'Menghapus akun pengguna: ' . $userHapus->nama_lengkap,
            'waktu_aktivitas' => now()
        ]);

        $userHapus->delete();
        return back();
    }
}

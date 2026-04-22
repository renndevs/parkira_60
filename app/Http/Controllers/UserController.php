<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.kelolaAkun', compact('users'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'username'     => 'required|unique:tb_user,username',
            'password'     => 'required',
            'role'         => 'required'
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'username'     => $request->username,
            'password'     => Hash::make($request->password),
            'role'         => $request->role,
        ]);

        LogAktivitas::create([
            'id_user'   => Auth::id(),
            'aktivitas' => 'Menambah akun pengguna baru: ' . $request->nama_lengkap . ' (' . $request->role . ')',
            'waktu_aktivitas' => now()
        ]);

        return back();
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'nama_lengkap' => $request->nama_lengkap,
            'username'     => $request->username,
            'role'         => $request->role,
        ]);

        if ($request->password) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        LogAktivitas::create([
            'id_user'   => Auth::id(),
            'aktivitas' => 'Mengubah informasi akun: ' . $request->nama_lengkap,
            'waktu_aktivitas' => now()
        ]);

        return back();
    }

    public function destroy($id)
    {
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

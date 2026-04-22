<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kendaraan;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;

class KendaraanController extends Controller
{
    public function index()
    {
        $kendaraans = Kendaraan::all();
        return view('admin.dataKendaraan', compact('kendaraans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'plat_nomor'       => 'required',
            'jenis_kendaraan' => 'required',
            'pemilik'         => 'required',
            'warna'           => 'required',
        ]);

        Kendaraan::create([
            'plat_nomor'       => $request->plat_nomor,
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'pemilik'         => $request->pemilik,
            'warna'           => $request->warna,
        ]);

        LogAktivitas::create([
            'id_user'   => Auth::id(),
            'aktivitas' => 'Mendaftarkan kendaraan baru: ' . $request->plat_nomor . ' (' . ucfirst($request->jenis_kendaraan) . ')',
            'waktu_aktivitas' => now()
        ]);

        return back();
    }

    public function update(Request $request, $id)
    {
        $kendaraan = Kendaraan::where('id_kendaraan', $id)->first();

        $kendaraan->update([
            'plat_nomor'       => $request->plat_nomor,
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'pemilik'         => $request->pemilik,
            'warna'           => $request->warna,
        ]);

        LogAktivitas::create([
            'id_user'   => Auth::id(),
            'aktivitas' => 'Mengubah data kendaraan dengan plat: ' . $request->plat_nomor,
            'waktu_aktivitas' => now()
        ]);

        return back();
    }

    public function destroy($id)
    {
        $kendaraanHapus = Kendaraan::where('id_kendaraan', $id)->first();
        LogAktivitas::create([
            'id_user'   => Auth::id(),
            'aktivitas' => 'Menghapus data kendaraan: ' . $kendaraanHapus->plat_nomor,
            'waktu_aktivitas' => now()
        ]);

        $kendaraanHapus->delete();
        return back();
    }
}

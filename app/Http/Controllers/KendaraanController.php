<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kendaraan; // Panggil model Kendaraan
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;

class KendaraanController extends Controller
{
    // 1. Tampilkan Data (Read)
    public function index()
    {
        $kendaraans = Kendaraan::all();
        return view('admin.dataKendaraan', compact('kendaraans'));
    }

    // 2. Simpan Data Baru (Create)
    public function store(Request $request)
    {
        // Validasi form gak boleh kosong
        $request->validate([
            'plat_nomor'       => 'required',
            'jenis_kendaraan' => 'required',
            'pemilik'         => 'required',
            'warna'           => 'required',
        ]);

        // Simpan ke database
        Kendaraan::create([
            'plat_nomor'       => $request->plat_nomor,
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'pemilik'         => $request->pemilik,
            'warna'           => $request->warna,
        ]);

        // --- DI DALAM FUNGSI store ---
        LogAktivitas::create([
            'id_user'   => Auth::id(),
            'aktivitas' => 'Mendaftarkan kendaraan baru: ' . $request->plat_nomor . ' (' . ucfirst($request->jenis_kendaraan) . ')',
            'waktu_aktivitas' => now()
        ]);

        return back(); // Balik ke halaman tadi
    }

    // 3. Update Data (Update)
    public function update(Request $request, $id)
    {
        // Cari data berdasarkan id_kendaraan
        $kendaraan = Kendaraan::where('id_kendaraan', $id)->first();

        // Update datanya
        $kendaraan->update([
            'plat_nomor'       => $request->plat_nomor,
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'pemilik'         => $request->pemilik,
            'warna'           => $request->warna,
        ]);

        // --- DI DALAM FUNGSI update ---
        LogAktivitas::create([
            'id_user'   => Auth::id(),
            'aktivitas' => 'Mengubah data kendaraan dengan plat: ' . $request->plat_nomor,
            'waktu_aktivitas' => now()
        ]);

        return back();
    }

    // 4. Hapus Data (Delete)
    public function destroy($id)
    {
        // --- DI DALAM FUNGSI destroy ---
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AreaParkir; // Panggil model AreaParkir
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;

class AreaParkirController extends Controller
{
    // 1. Tampilkan Data
    public function index()
    {
        $areaParkirs = AreaParkir::all();
        return view('admin.areaParkir', compact('areaParkirs')); // Sesuai format camelCase
    }

    // 2. Simpan Data Baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_area' => 'required',
            'kapasitas' => 'required|numeric',
        ]);

        AreaParkir::create([
            'nama_area' => $request->nama_area,
            'kapasitas' => $request->kapasitas,
            'terisi'    => 0, // Otomatis mulai dari 0 saat area dibuat
        ]);

        // --- DI DALAM FUNGSI store ---
        LogAktivitas::create([
            'id_user'   => Auth::id(),
            'aktivitas' => 'Menambah area parkir baru: ' . $request->nama_area . ' (Kapasitas: ' . $request->kapasitas . ')',
            'waktu_aktivitas' => now()
        ]);

        return back();
    }

    // 3. Update Data
    public function update(Request $request, $id)
    {
        $area = AreaParkir::where('id_area', $id)->first();

        $area->update([
            'nama_area' => $request->nama_area,
            'kapasitas' => $request->kapasitas,
            // Kolom 'terisi' tidak kita update di sini agar datanya tidak rusak
        ]);

        // --- DI DALAM FUNGSI update ---
        LogAktivitas::create([
            'id_user'   => Auth::id(),
            'aktivitas' => 'Mengubah kapasitas/nama area: ' . $request->nama_area,
            'waktu_aktivitas' => now()
        ]);

        return back();
    }

    // 4. Hapus Data
    public function destroy($id)
    {
        // --- DI DALAM FUNGSI destroy ---
        $areaHapus = AreaParkir::where('id_area', $id)->first();
        LogAktivitas::create([
            'id_user'   => Auth::id(),
            'aktivitas' => 'Menghapus area parkir: ' . $areaHapus->nama_area,
            'waktu_aktivitas' => now()
        ]);

        $areaHapus->delete();
        return back();
    }
}

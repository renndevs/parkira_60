<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AreaParkir;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;

class AreaParkirController extends Controller
{
    public function index()
    {
        $areaParkirs = AreaParkir::all();
        return view('admin.areaParkir', compact('areaParkirs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_area' => 'required',
            'kapasitas' => 'required|numeric',
        ]);

        AreaParkir::create([
            'nama_area' => $request->nama_area,
            'kapasitas' => $request->kapasitas,
            'terisi'    => 0,
        ]);

        LogAktivitas::create([
            'id_user'   => Auth::id(),
            'aktivitas' => 'Menambah area parkir baru: ' . $request->nama_area . ' (Kapasitas: ' . $request->kapasitas . ')',
            'waktu_aktivitas' => now()
        ]);

        return back();
    }

    public function update(Request $request, $id)
    {
        $area = AreaParkir::where('id_area', $id)->first();

        $area->update([
            'nama_area' => $request->nama_area,
            'kapasitas' => $request->kapasitas,
        ]);

        LogAktivitas::create([
            'id_user'   => Auth::id(),
            'aktivitas' => 'Mengubah kapasitas/nama area: ' . $request->nama_area,
            'waktu_aktivitas' => now()
        ]);

        return back();
    }

    public function destroy($id)
    {
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

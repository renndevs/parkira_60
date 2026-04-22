<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarif;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;

class TarifController extends Controller
{
    public function index()
    {
        $tarifs = Tarif::all();
        return view('admin.tarifParkir', compact('tarifs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_kendaraan' => 'required',
            'tarif_per_jam'   => 'required|numeric',
        ]);

        Tarif::create([
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'tarif_per_jam'   => $request->tarif_per_jam,
        ]);

        LogAktivitas::create([
            'id_user'   => Auth::id(),
            'aktivitas' => 'Menambahkan tarif baru untuk kendaraan ' . ucfirst($request->jenis_kendaraan),
            'waktu_aktivitas' => now()
        ]);

        return back();
    }

    public function update(Request $request, $id)
    {
        $tarif = Tarif::where('id_tarif', $id)->first();

        $tarif->update([
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'tarif_per_jam'   => $request->tarif_per_jam,
        ]);

        LogAktivitas::create([
            'id_user'   => Auth::id(),
            'aktivitas' => 'Mengubah data tarif untuk kendaraan ' . ucfirst($request->jenis_kendaraan),
            'waktu_aktivitas' => now()
        ]);

        return back();
    }

    public function destroy($id)
    {
        $tarif = Tarif::where('id_tarif', $id)->first();
        LogAktivitas::create([
            'id_user'   => Auth::id(),
            'aktivitas' => 'Menghapus data tarif untuk kendaraan ' . ucfirst($tarif->jenis_kendaraan),
            'waktu_aktivitas' => now()
        ]);

        $tarif->delete();
        return back();
    }
}

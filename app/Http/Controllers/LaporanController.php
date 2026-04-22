<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tgl_awal = $request->tgl_awal;
        $tgl_akhir = $request->tgl_akhir;

        $query = Transaksi::with(['kendaraan', 'areaParkir', 'tarif'])
            ->where('status', 'keluar');

        if ($tgl_awal && $tgl_akhir) {
            $query->whereBetween('waktu_keluar', [$tgl_awal . ' 00:00:00', $tgl_akhir . ' 23:59:59']);
        }

        $laporans = $query->orderBy('waktu_keluar', 'desc')->get();

        $totalPendapatan = $laporans->sum('biaya_total');
        $totalKendaraan = $laporans->count();

        return view('owner.laporan', compact('laporans', 'tgl_awal', 'tgl_akhir', 'totalPendapatan', 'totalKendaraan'));
    }
    
    public function cetak(Request $request)
    {
        $tgl_awal = $request->tgl_awal;
        $tgl_akhir = $request->tgl_akhir;

        $query = Transaksi::with(['kendaraan', 'areaParkir', 'tarif'])->where('status', 'keluar');

        if ($tgl_awal && $tgl_akhir) {
            $query->whereBetween('waktu_keluar', [$tgl_awal . ' 00:00:00', $tgl_akhir . ' 23:59:59']);
        }

        $laporans = $query->get();
        $totalPendapatan = $laporans->sum('biaya_total');

        return view('owner.cetakLaporan', compact('laporans', 'tgl_awal', 'tgl_akhir', 'totalPendapatan'));
    }
}

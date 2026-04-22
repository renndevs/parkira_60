<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AreaParkir;
use App\Models\LogAktivitas;
use App\Models\Transaksi;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUser = User::count();

        $kapasitasTotal = AreaParkir::sum('kapasitas');
        $slotTerisi = AreaParkir::sum('terisi');

        $pendapatanHariIni = Transaksi::whereDate('waktu_keluar', today())
        ->sum('biaya_total');

        $logs = LogAktivitas::with('user')
        ->orderBy('waktu_aktivitas', 'desc')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUser',
            'kapasitasTotal',
            'slotTerisi',
            'pendapatanHariIni',
            'logs'
        ));
    }
}

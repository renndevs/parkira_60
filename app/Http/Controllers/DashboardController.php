<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AreaParkir;
use App\Models\LogAktivitas;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Total Pengguna (Menghitung semua role: Admin & Petugas)
        $totalUser = User::count();

        // 2. Info Slot (Mengambil data kapasitas dan yang terisi)
        $kapasitasTotal = AreaParkir::sum('kapasitas');
        $slotTerisi = AreaParkir::sum('terisi');

        // 3. Pendapatan Hari Ini
        // Menghitung total_bayar dari transaksi yang selesai hari ini saja
        $pendapatanHariIni = Transaksi::whereDate('waktu_keluar', today())
                                    ->sum('biaya_total');

        // 4. Log Aktivitas Terbaru (Ambil 5 saja agar ringan)
        $logs = LogAktivitas::with('user')
                            ->orderBy('waktu_aktivitas', 'desc')
                            ->take(5)
                            ->get();

        return view('admin.dashboard', compact(
            'totalUser', 
            'kapasitasTotal', 
            'slotTerisi', 
            'pendapatanHariIni', 
            'logs'
        ));
    }
}
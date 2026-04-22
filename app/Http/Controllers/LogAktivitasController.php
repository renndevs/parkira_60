<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogAktivitas;
use App\Models\User; // Panggil model User untuk dropdown filter

class LogAktivitasController extends Controller
{
    public function index(Request $request)
    {
        // 1. Mulai query dengan memanggil relasi 'user' dan urutkan dari yang terbaru
        $query = LogAktivitas::with('user')->orderBy('waktu_aktivitas', 'desc');

        // 2. Jika ada filter dari tanggal & sampai tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('waktu_aktivitas', [
                $request->start_date . ' 00:00:00', 
                $request->end_date . ' 23:59:59'
            ]);
        }

        // 3. Jika ada filter berdasarkan User/Petugas
        if ($request->filled('id_user')) {
            $query->where('id_user', $request->id_user);
        }

        // Eksekusi query
        $logs = $query->get();
        
        // Ambil semua data user untuk ditampilkan di Dropdown Modal Filter
        $users = User::all();

        // Ingat format camelCase kamu: logAktivitas
        return view('admin.logAktivitas', compact('logs', 'users'));
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogAktivitas;
use App\Models\User;

class LogAktivitasController extends Controller
{
    public function index(Request $request)
    {
        $query = LogAktivitas::with('user')->orderBy('waktu_aktivitas', 'desc');

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('waktu_aktivitas', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        if ($request->filled('id_user')) {
            $query->where('id_user', $request->id_user);
        }

        $logs = $query->get();

        // $users = User::all();
        $users = User::paginate(10);
        return view('admin.logAktivitas', compact('logs', 'users'));


        // return view('admin.logAktivitas', compact('logs', 'users'));
    }
}

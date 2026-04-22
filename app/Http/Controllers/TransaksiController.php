<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Kendaraan;
use App\Models\AreaParkir;
use App\Models\Tarif;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    public function index()
    {
        // 1. Ambil kendaraan yang sedang parkir
        $transaksis = Transaksi::with(['kendaraan', 'areaParkir', 'tarif'])
            ->where('status', 'masuk')
            ->get();

        // 2. Ambil kendaraan yang TIDAK sedang parkir
        $kendaraans = Kendaraan::whereDoesntHave('transaksi', function ($q) {
            $q->where('status', 'masuk');
        })->get();

        $areas = AreaParkir::all();
        $tarifs = Tarif::all();

        return view('petugas.transaksiParkir', compact('transaksis', 'kendaraans', 'areas', 'tarifs'));
    }

    public function store(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'id_kendaraan' => 'required',
            'id_area'      => 'required',
        ]);

        // 2. Cek ketersediaan area (Validasi Sisi Server)
        $area = AreaParkir::findOrFail($request->id_area);

        if ($area->terisi >= $area->kapasitas) {
            return back()->with('error', "Gagal! Area " . $area->nama_area . " sudah penuh.");
        }

        // 3. Cari data kendaraan
        $kendaraan = Kendaraan::findOrFail($request->id_kendaraan);

        // 4. Cari tarif otomatis
        $tarif = Tarif::whereRaw('LOWER(jenis_kendaraan) = ?', [strtolower($kendaraan->jenis_kendaraan)])->first();

        if (!$tarif) {
            return back()->with('error', "Gagal! Tarif untuk jenis " . $kendaraan->jenis_kendaraan . " belum dibuat.");
        }

        // 5. Simpan Data Transaksi
        $transaksi = Transaksi::create([
            'id_kendaraan' => $request->id_kendaraan,
            'id_area'      => $request->id_area,
            'id_tarif'     => $tarif->id_tarif,
            'id_user'      => Auth::id(),
            'waktu_masuk'  => now(),
            'status'       => 'masuk',
        ]);

        // 6. Update slot area
        $area->increment('terisi');

        // 7. Catat Log
        LogAktivitas::create([
            'id_user'   => Auth::id(),
            'aktivitas' => "Input Parkir Masuk: $kendaraan->plat_nomor",
            'waktu_aktivitas' => now()
        ]);

        $transaksi->load(['kendaraan', 'areaParkir']);
        return view('petugas.cetakMasuk', compact('transaksi'));
    }

    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $waktuMasuk = Carbon::parse($transaksi->waktu_masuk);
        $waktuKeluar = now();

        $durasiMenit = $waktuMasuk->diffInMinutes($waktuKeluar);
        $durasiJam = max(1, ceil($durasiMenit / 60));

        // --- PERBAIKAN FATAL DI SINI ---
        $tarif = Tarif::find($transaksi->id_tarif);

        // Sesuaikan dengan nama kolom database kamu: tarif_per_jam
        $totalBiaya = $durasiJam * $tarif->tarif_per_jam;

        $uang_bayar = $request->uang_bayar;
        $kembalian = $uang_bayar - $totalBiaya;

        $transaksi->update([
            'waktu_keluar' => $waktuKeluar,
            'durasi_jam'   => $durasiJam,
            'biaya_total'  => $totalBiaya,
            'status'       => 'keluar'
        ]);

        AreaParkir::find($transaksi->id_area)->decrement('terisi');

        LogAktivitas::create([
            'id_user'   => Auth::id(),
            'aktivitas' => "Proses Parkir Keluar: " . $transaksi->kendaraan->plat_nomor,
            'waktu_aktivitas' => now()
        ]);

        $transaksi->load(['kendaraan', 'areaParkir', 'tarif']);
        return view('petugas.cetakKeluar', compact('transaksi', 'uang_bayar', 'kembalian'));
    }
}

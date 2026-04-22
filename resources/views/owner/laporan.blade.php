@extends('layouts.owner')

@section('title', 'Laporan Pendapatan - Parkira')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-950 mb-1">Laporan Pendapatan</h1>
            <p class="text-slate-500 font-medium">Pantau rekapitulasi transaksi parkir dan cetak laporan.</p>
        </div>

        <div class="flex items-center gap-3">

            @if ($laporans->count() > 0)
                <a href="/owner/laporan/cetak?tgl_awal={{ $tgl_awal }}&tgl_akhir={{ $tgl_akhir }}" target="_blank"
                    class="px-6 py-3 bg-slate-800 text-white rounded-xl font-semibold text-sm hover:bg-slate-900 transition shadow-sm flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                        </path>
                    </svg>
                    Cetak PDF
                </a>
            @endif

            <button onclick="openFilterModal()"
                class="bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 px-6 py-3 rounded-xl font-semibold text-sm transition-all shadow-sm flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                    </path>
                </svg>
                Filter Tanggal
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-blue-600 rounded-2xl p-6 text-white shadow-sm flex flex-col justify-center">
            <span class="text-blue-100 font-medium text-sm mb-1 uppercase tracking-wider">Total Pendapatan</span>
            <span class="text-3xl font-bold">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span>
        </div>
        <div class="bg-white border border-slate-200 rounded-2xl p-6 text-slate-800 shadow-sm flex flex-col justify-center">
            <span class="text-slate-500 font-medium text-sm mb-1 uppercase tracking-wider">Total Kendaraan</span>
            <span class="text-3xl font-bold">{{ $totalKendaraan }} <span class="text-lg text-slate-400">Unit</span></span>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-[#F8FAFC] text-slate-600 font-semibold border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-5 uppercase tracking-wider text-xs">Waktu Keluar</th>
                        <th class="px-6 py-5 uppercase tracking-wider text-xs">Plat Nomor</th>
                        <th class="px-6 py-5 uppercase tracking-wider text-xs">Durasi</th>
                        <th class="px-6 py-5 uppercase tracking-wider text-xs text-right">Biaya Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-800">
                    @forelse($laporans as $l)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-5 whitespace-nowrap text-slate-600 font-medium">
                                {{ date('d M Y - H:i', strtotime($l->waktu_keluar)) }}
                            </td>
                            <td class="px-6 py-5">
                                <div class="font-bold text-slate-900 uppercase">{{ $l->kendaraan->plat_nomor }}</div>
                                <div class="text-xs text-slate-500 mt-0.5">{{ $l->kendaraan->jenis_kendaraan }}</div>
                            </td>
                            <td class="px-6 py-5 font-medium text-slate-800">
                                {{ $l->durasi_jam }} Jam
                            </td>
                            <td class="px-6 py-5 font-bold text-blue-600 text-right">
                                Rp {{ number_format($l->biaya_total, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-slate-500">
                                Tidak ada data laporan pada periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="modalFilter"
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 hidden flex items-center justify-center transition-opacity">
        <div class="bg-white w-full max-w-lg rounded-2xl shadow-2xl p-8 mx-4 transform transition-all">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-slate-900">Filter Laporan</h2>
                <button type="button" onclick="closeFilterModal()" class="text-slate-400 hover:text-slate-700 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <form action="/owner/laporan" method="GET" class="space-y-4">
                <div class="flex gap-4">
                    <div class="flex-1">
                        <label class="block text-sm font-bold text-slate-700 mb-1">Dari Tanggal</label>
                        <input type="date" name="tgl_awal" value="{{ $tgl_awal }}" required
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg outline-none focus:ring-2 focus:ring-blue-500 transition text-sm">
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-bold text-slate-700 mb-1">Sampai Tanggal</label>
                        <input type="date" name="tgl_akhir" value="{{ $tgl_akhir }}" required
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg outline-none focus:ring-2 focus:ring-blue-500 transition text-sm">
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-8 pt-5 border-t border-slate-100">
                    <a href="/owner/laporan"
                        class="px-6 py-2.5 bg-slate-100 text-slate-600 rounded-lg font-semibold text-sm transition hover:bg-slate-200 text-center">
                        Reset
                    </a>
                    <button type="submit"
                        class="px-6 py-2.5 bg-blue-600 text-white rounded-lg font-semibold text-sm transition hover:bg-blue-700 shadow-sm">
                        Terapkan Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openFilterModal() {
            document.getElementById('modalFilter').classList.remove('hidden');
        }

        function closeFilterModal() {
            document.getElementById('modalFilter').classList.add('hidden');
        }
    </script>
@endsection

@extends('layouts.admin')

@section('title', 'Dashboard Overview - Parkira')

@section('content')

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-950 mb-1">Dashboard Overview</h1>
        <p class="text-slate-500 font-medium">Ringkasan aktivitas dan operasional hari ini.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">

        <div class="bg-white p-7 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-6">
            <div class="w-16 h-16 rounded-full bg-blue-100/50 flex items-center justify-center text-blue-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 01-9-3.812"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-slate-500 text-sm font-semibold mb-1">Total Pengguna</h3>
                <p class="text-3xl font-bold text-slate-900 tracking-tight">{{ $totalUser }} User</p>
            </div>
        </div>

        <div class="bg-white p-7 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-6">
            <div class="w-16 h-16 rounded-full bg-green-100/50 flex items-center justify-center text-green-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m14 0l-7 7-7-7"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-slate-500 text-sm font-semibold mb-1">Slot Terpakai</h3>
                <p class="text-3xl font-bold tracking-tight {{ $slotTerisi >= $kapasitasTotal ? 'text-red-600' : 'text-slate-900' }}">
                    {{ $slotTerisi }} / {{ $kapasitasTotal }}
                </p>
            </div>
        </div>

        <div class="bg-white p-7 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-6">
            <div class="w-16 h-16 rounded-full bg-amber-100/50 flex items-center justify-center text-amber-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 16V7"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-slate-500 text-sm font-semibold mb-1">Pendapatan Hari Ini</h3>
                <p class="text-3xl font-bold text-slate-900 tracking-tight">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm">
        <h2 class="text-2xl font-semibold mb-6 text-slate-950">Log Aktivitas Terbaru</h2>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-[#F8FAFC] text-slate-900 font-semibold border-b border-slate-100">
                    <tr>
                        <th class="px-5 py-4">WAKTU</th>
                        <th class="px-5 py-4">USER</th>
                        <th class="px-5 py-4">AKTIVITAS</th>
                    </tr>
                </thead>
                <tbody class="text-slate-800 divide-y divide-slate-100">
                    @forelse($logs as $log)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-5 py-5 whitespace-nowrap text-slate-500 font-medium">
                                {{ date('H:i', strtotime($log->waktu_aktivitas)) }}
                            </td>
                            <td class="px-5 py-5 whitespace-nowrap">
                                <span class="font-bold text-slate-900">{{ $log->user->nama_lengkap ?? 'System' }}</span>
                                <span class="text-xs text-slate-400 ml-1 uppercase">({{ $log->user->role ?? '-' }})</span>
                            </td>
                            <td class="px-5 py-5 font-medium text-slate-700">{{ $log->aktivitas }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-5 py-10 text-center text-slate-400 italic">
                                Belum ada aktivitas yang tercatat hari ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
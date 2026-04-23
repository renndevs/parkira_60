@extends('layouts.admin')

@section('title', 'Log Aktivitas - Parkira')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-950 mb-1">Log Aktivitas</h1>
            <p class="text-slate-500 font-medium">Pantau rekam jejak aktivitas pengguna di dalam sistem.</p>
        </div>

        <button onclick="openFilterModal()"
            class="bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 px-6 py-3 rounded-xl font-semibold text-sm transition-all shadow-sm flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
            </svg>
            Filter Data
        </button>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-[#F8FAFC] text-slate-600 font-semibold border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-5 uppercase tracking-wider text-xs">Waktu Aktivitas</th>
                        <th class="px-6 py-5 uppercase tracking-wider text-xs">Pengguna (Role)</th>
                        <th class="px-6 py-5 uppercase tracking-wider text-xs">Keterangan Aktivitas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-800">

                    @forelse ($logs as $log)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-5 whitespace-nowrap text-slate-600 font-medium">
                                {{ date('d M Y - H:i', strtotime($log->waktu_aktivitas)) }}
                            </td>
                            <td class="px-6 py-5">
                                <div class="font-bold text-slate-900">{{ $log->user->nama_lengkap ?? 'Unknown' }}</div>
                                <div class="text-xs text-slate-500 uppercase mt-0.5">{{ $log->user->role ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-5 font-medium text-slate-800">
                                {{ $log->aktivitas }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-10 text-center text-slate-500">
                                Tidak ada log aktivitas yang ditemukan.
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>

    <div id="modalFilter" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center transition-opacity">
        <div class="bg-white w-full max-w-lg rounded-2xl shadow-2xl p-8 mx-4 transform transition-all">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-slate-900">Filter Log Aktivitas</h2>
                <button onclick="closeFilterModal()" class="text-slate-400 hover:text-slate-700 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form action="/log-aktivitas" method="GET" class="space-y-4">

                <div class="flex gap-4">
                    <div class="flex-1">
                        <label class="block text-sm font-bold text-slate-700 mb-1">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg outline-none focus:ring-2 focus:ring-blue-500 transition text-sm">
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-bold text-slate-700 mb-1">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                            class="w-full px-4 py-2.5 border border-slate-300 rounded-lg outline-none focus:ring-2 focus:ring-blue-500 transition text-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Pengguna / Petugas</label>
                    <select name="id_user" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg outline-none focus:ring-2 focus:ring-blue-500 bg-white transition text-sm appearance-none cursor-pointer">
                        <option value="">Semua Pengguna</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id_user }}" {{ request('id_user') == $user->id_user ? 'selected' : '' }}>
                                {{ $user->nama_lengkap }} ({{ ucfirst($user->role) }})
                            </option>
                        @endforeach

                        {{-- <div class="mt-4">
                            {{ $users->links() }}
                        </div> --}}
                    </select>
                </div>

                <div class="flex justify-end gap-3 mt-8 pt-5 border-t border-slate-100">
                    <a href="/log-aktivitas" class="px-6 py-2.5 bg-slate-100 text-slate-600 rounded-lg font-semibold text-sm transition hover:bg-slate-200 text-center">
                        Reset
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-lg font-semibold text-sm transition hover:bg-blue-700 shadow-sm">
                        Terapkan Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openFilterModal() { document.getElementById('modalFilter').classList.remove('hidden'); }
        function closeFilterModal() { document.getElementById('modalFilter').classList.add('hidden'); }
    </script>
@endsection

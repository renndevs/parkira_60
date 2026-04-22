<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Parkira')</title>

    @vite('resources/css/app.css')

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-[#F1F5F9] text-slate-800 flex">

    <aside class="w-64 bg-[#1E293B] min-h-screen fixed flex flex-col p-4 text-white">

        <div class="h-28 flex items-center justify-center border-b border-slate-700/50 mb-6 px-6">
            <img src="{{ asset('logo-parkira.png') }}" alt="Logo Parkira"
                class="max-h-20 w-auto object-contain transition-all hover:scale-105 duration-300">
        </div>

        <nav class="flex-1 space-y-2">

            <a href="/dashboard"
                class="block flex items-center gap-3 px-4 py-3 rounded-lg font-medium text-sm transition {{ request()->is('dashboard') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m0 0l-7 7-7-7M19 10v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                    </path>
                </svg>
                Dashboard
            </a>

            <a href="/kelola-akun"
                class="block flex items-center gap-3 px-4 py-3 rounded-lg font-medium text-sm transition {{ request()->is('kelola-akun') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 01-9-3.812"></path>
                </svg>
                Kelola Akun
            </a>

            @php
                // Cek apakah halaman saat ini ada di dalam grup Master Data
                $isMasterDataActive =
                    request()->is('data-kendaraan') || request()->is('area-parkir') || request()->is('tarif-parkir');
            @endphp
            <div>
                <button onclick="toggleMenu('masterDataMenu', 'masterDataArrow')"
                    class="w-full flex items-center justify-between px-4 py-3 rounded-lg font-medium text-sm transition {{ $isMasterDataActive ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                        Master Data
                    </div>
                    <svg id="masterDataArrow"
                        class="w-4 h-4 transition-transform duration-200 {{ $isMasterDataActive ? 'rotate-180' : '' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="masterDataMenu"
                    class="mt-1 space-y-1 pl-11 pr-4 {{ $isMasterDataActive ? 'block' : 'hidden' }}">
                    <a href="/data-kendaraan"
                        class="block py-2 text-sm font-medium transition {{ request()->is('data-kendaraan') ? 'text-white' : 'text-slate-400 hover:text-white' }}">
                        Data Kendaraan
                    </a>
                    <a href="/area-parkir"
                        class="block py-2 text-sm font-medium transition {{ request()->is('area-parkir') ? 'text-white' : 'text-slate-400 hover:text-white' }}">
                        Area Parkir
                    </a>
                    <a href="/tarif-parkir"
                        class="block py-2 text-sm font-medium transition {{ request()->is('tarif-parkir') ? 'text-white' : 'text-slate-400 hover:text-white' }}">
                        Tarif Parkir
                    </a>
                </div>
            </div>

            @php
                // Cek apakah halaman saat ini ada di dalam grup Laporan
                $isLaporanActive = request()->is('log-aktivitas');
            @endphp
            <div>
                <button onclick="toggleMenu('laporanMenu', 'laporanArrow')"
                    class="w-full flex items-center justify-between px-4 py-3 rounded-lg font-medium text-sm transition {{ $isLaporanActive ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        Laporan
                    </div>
                    <svg id="laporanArrow"
                        class="w-4 h-4 transition-transform duration-200 {{ $isLaporanActive ? 'rotate-180' : '' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="laporanMenu" class="mt-1 space-y-1 pl-11 pr-4 {{ $isLaporanActive ? 'block' : 'hidden' }}">
                    <a href="/log-aktivitas"
                        class="block py-2 text-sm font-medium transition {{ request()->is('log-aktivitas') ? 'text-white' : 'text-slate-400 hover:text-white' }}">
                        Log Aktivitas
                    </a>
                </div>
            </div>

        </nav>
    </aside>

    <main class="flex-1 ml-64 flex flex-col min-h-screen">
        <header
            class="h-20 bg-white/95 backdrop-blur-sm flex items-center justify-between px-10 sticky top-0 z-10 border-b border-slate-100">
            <div class="flex items-center gap-2 text-slate-900">
                <span class="text-lg">Hai,</span>
                <span class="text-lg font-semibold">{{ Auth::user()->nama_lengkap ?? 'Administrator' }}</span>
                <span class="text-lg text-slate-500">({{ Auth::user()->role ?? 'Admin' }})</span>
            </div>

            <form action="/logout" method="POST">
                @csrf
                <button type="submit"
                    class="px-5 py-2.5 bg-[#EF4444] text-white rounded-lg font-semibold text-sm hover:bg-[#DC2626] transition shadow-sm">
                    Logout
                </button>
            </form>
        </header>

        <div class="p-10 flex-1">
            @yield('content')
        </div>
    </main>

    <script>
        function toggleMenu(menuId, arrowId) {
            const menu = document.getElementById(menuId);
            const arrow = document.getElementById(arrowId);

            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                arrow.classList.add('rotate-180');
            } else {
                menu.classList.add('hidden');
                arrow.classList.remove('rotate-180');
            }
        }
    </script>
</body>

</html>
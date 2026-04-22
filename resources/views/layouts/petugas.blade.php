<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Petugas Parkira')</title>

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

            <a href="/transaksi"
                class="block flex items-center gap-3 px-4 py-3 rounded-lg font-medium text-sm transition {{ request()->is('transaksi') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0">
                    </path>
                </svg>
                Monitor Transaksi
            </a>

        </nav>
    </aside>

    <main class="flex-1 ml-64 flex flex-col min-h-screen">
        <header
            class="h-20 bg-white/95 backdrop-blur-sm flex items-center justify-between px-10 sticky top-0 z-10 border-b border-slate-100">
            <div class="flex items-center gap-2 text-slate-900">
                <span class="text-lg">Hai,</span>
                <span class="text-lg font-semibold">{{ Auth::user()->nama_lengkap ?? 'Petugas' }}</span>
                <span class="text-lg text-slate-500 text-capitalize">({{ Auth::user()->role ?? 'Petugas' }})</span>
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

</body>

</html>

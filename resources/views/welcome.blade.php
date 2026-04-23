<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parkira - Sistem Manajemen Parkir Modern</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-white text-slate-900 overflow-x-hidden">

    <nav class="fixed w-full z-50 bg-white/80 backdrop-blur-md border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center">
                    <img src="{{ asset('logo-parkira-blue.png') }}" alt="Logo Parkira"
                        class="h-20 w-auto drop-shadow-md hover:scale-105 transition-transform duration-300">
                </div>
                <div class="hidden md:flex items-center gap-8">
                    <a href="#fitur"
                        class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition">Fitur</a>
                    <a href="#tentang"
                        class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition">Tentang</a>
                    <a href="/login"
                        class="px-6 py-3 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                        Masuk Sistem
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <section class="pt-32 pb-20 lg:pt-48 lg:pb-32 px-6">
        <div class="max-w-7xl mx-auto text-center">
            <span
                class="inline-block px-4 py-2 rounded-full bg-blue-50 text-blue-600 text-xs font-bold uppercase tracking-widest mb-6">
                Solusi Parkir Cerdas v1.0
            </span>
            <h1 class="text-5xl lg:text-7xl font-black text-slate-950 leading-tight mb-8">
                Kelola Parkir Jadi <br> <span class="text-blue-600">Lebih Efisien & Aman.</span>
            </h1>
            <p class="text-lg text-slate-500 max-w-2xl mx-auto mb-10 font-medium">
                Sistem manajemen parkir modern yang dirancang khusus untuk kemudahan operasional, pemantauan real-time,
                dan pelaporan pendapatan yang akurat.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/login"
                    class="px-8 py-4 bg-slate-900 text-white rounded-2xl font-bold text-lg hover:bg-slate-800 transition shadow-xl">
                    Mulai Sekarang
                </a>
                <a href="#fitur"
                    class="px-8 py-4 bg-white border border-slate-200 text-slate-600 rounded-2xl font-bold text-lg hover:bg-slate-50 transition">
                    Pelajari Fitur
                </a>
            </div>
        </div>
    </section>

    <section id="fitur" class="py-24 bg-slate-50 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-slate-900 mb-4">Kenapa Memilih Parkira?</h2>
                <p class="text-slate-500 font-medium">Fitur unggulan yang memudahkan Admin, Petugas, dan Pimpinan.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-600 mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 00-2 2h-2a2 2 0 00-2-2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Monitoring Real-time</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Pantau kapasitas area parkir yang tersedia secara
                        instan tanpa perlu pengecekan manual.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition">
                    <div
                        class="w-12 h-12 bg-green-100 rounded-2xl flex items-center justify-center text-green-600 mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Laporan Pendapatan</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Rekapitulasi otomatis pendapatan harian hingga
                        bulanan yang siap dicetak untuk Pimpinan.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition">
                    <div
                        class="w-12 h-12 bg-purple-100 rounded-2xl flex items-center justify-center text-purple-600 mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Keamanan Data</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Sistem login berlapis dengan role-based access
                        control untuk menjamin integritas data Anda.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-12 border-t border-slate-100 px-6">
        <div class="max-w-7xl mx-auto flex flex-col md:row justify-between items-center gap-6">
            <div class="flex items-center gap-3">
                <span class="text-lg font-bold text-slate-900 tracking-tight">PARKIRA.</span>
            </div>
            <p class="text-slate-400 text-sm font-medium text-center">
                &copy; 2026 Proyek UKK RPL - SMKN 4 Tangerang. Dibuat dengan penuh semangat.
            </p>
        </div>
    </footer>

</body>

</html>

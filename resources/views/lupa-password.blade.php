<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Parkira</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#F8FAFC] flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 md:p-10 rounded-3xl shadow-xl max-w-md w-full mx-4 flex flex-col items-center text-center border border-slate-100">

        <div class="mb-6 flex items-center justify-center">
            <img src="{{ asset('logo-parkira-blue.png') }}" alt="Logo Parkira" class="h-24 w-auto drop-shadow-sm">
        </div>

        <h2 class="text-2xl font-bold text-slate-900 mb-4">Lupa Password?</h2>
        <p class="text-sm text-slate-600 font-medium leading-relaxed mb-8 px-2">
            Sistem ini bersifat internal. Jika Anda lupa kata sandi, silakan hubungi Administrator sistem untuk melakukan reset password secara manual.
        </p>

        <a href="/login" class="w-full py-3.5 px-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-blue-200">
            Kembali ke Halaman Login
        </a>

    </div>

</body>
</html>
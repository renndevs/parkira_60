<!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Masuk - Parkira</title>

        @vite('resources/css/app.css')

        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <style>
            body {
                font-family: 'Inter', sans-serif;
            }
        </style>
    </head>

    <body class="bg-slate-50 min-h-screen flex items-center justify-center">

        <div
            class="bg-white p-8 rounded-2xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] w-full max-w-[400px] mx-4 border border-slate-100">

            <div class="flex justify-center mb-6">
                <img src="{{ asset('logo-parkira-blue.png') }}" alt="Logo Parkira" class="h-30 object-contain">
            </div>

            <h2 class="text-[22px] font-bold text-center text-slate-800 mb-8">Masuk ke Sistem</h2>

            <form action="{{ url('/login') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="username" class="block text-sm font-medium text-slate-700 mb-1.5">Username</label>
                    <input type="text" id="username" name="username" required
                        class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">Password</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 rounded-lg text-sm transition-colors">
                        Login
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <a href="/lupa-password" class="text-sm text-slate-500 hover:text-slate-800 transition-colors">
                    Lupa Password?
                </a>
            </div>

        </div>

    </body>

    </html>

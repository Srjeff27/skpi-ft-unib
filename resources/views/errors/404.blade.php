<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Tidak Ditemukan | SKPI FT UNIB</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-ft.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 text-slate-900 antialiased">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute -left-16 -top-20 h-64 w-64 rounded-full bg-[#fa7516]/10 blur-3xl"></div>
        <div class="absolute -right-10 top-10 h-72 w-72 rounded-full bg-[#1b3985]/10 blur-3xl"></div>
    </div>

    <main class="relative z-10 flex flex-col items-center justify-center px-6 py-12 sm:py-16">
        <div class="flex items-center gap-3">
            <div class="h-14 w-14 rounded-full bg-white shadow-lg ring-1 ring-slate-200 flex items-center justify-center">
                <img src="{{ asset('images/logo-ft.png') }}" alt="FT UNIB" class="h-10 w-10">
            </div>
            <div>
                <p class="text-xs font-semibold tracking-widest text-slate-500 uppercase">Portal Akademik</p>
                <h1 class="text-lg font-bold text-[#1b3985]">Fakultas Teknik — Universitas Bengkulu</h1>
            </div>
        </div>

        <div class="mt-10 w-full max-w-3xl overflow-hidden rounded-2xl bg-white shadow-2xl ring-1 ring-slate-200">
            <div class="grid grid-cols-1 md:grid-cols-2">
                <div class="relative hidden md:block bg-gradient-to-br from-[#1b3985] to-[#203f9b] text-white p-8">
                    <div class="space-y-4">
                        <div class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs font-semibold uppercase tracking-widest">
                            <span class="flex h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            SKPI — Academic Integrity
                        </div>
                        <h2 class="text-3xl font-extrabold leading-tight">Halaman tidak ditemukan.</h2>
                        <p class="text-sm text-blue-100 leading-relaxed">Tautan yang Anda buka tidak tersedia. Gunakan navigasi berikut untuk kembali ke jalur akademik yang tepat.</p>
                    </div>
                    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 20% 20%, #fff 0, transparent 35%), radial-gradient(circle at 80% 0%, #fff 0, transparent 25%);"></div>
                </div>

                <div class="p-8 space-y-6 flex flex-col">
                    <div class="flex items-center gap-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-orange-50 text-orange-500 shadow-inner">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L2.34 18c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-500">Kode: 404</p>
                            <h3 class="text-xl font-bold text-slate-900">Oops, halaman tidak ditemukan</h3>
                        </div>
                    </div>

                    <p class="text-sm leading-relaxed text-slate-600">
                        Kami tidak dapat menemukan halaman yang Anda tuju. Silakan kembali ke dashboard atau buka halaman lain yang tersedia.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <a href="{{ route('dashboard') }}"
                           class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[#fa7516] to-[#e5670c] px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-orange-200 hover:shadow-orange-300 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7m-9 8h4m-7 0h3m4 0h3" />
                            </svg>
                            Kembali ke Dashboard
                        </a>
                        <a href="{{ url('/') }}"
                           class="inline-flex items-center justify-center gap-2 rounded-xl bg-white px-4 py-3 text-sm font-semibold text-[#1b3985] ring-1 ring-slate-200 hover:ring-[#1b3985] hover:bg-slate-50 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 10l-7 7-7-7" />
                            </svg>
                            Halaman Utama
                        </a>
                    </div>

                    <div class="flex flex-wrap items-center gap-3 pt-2">
                        <div class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                            Portal SKPI Terintegrasi
                        </div>
                        <div class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                            <span class="h-2 w-2 rounded-full bg-[#1b3985]"></span>
                            Fakultas Teknik UNIB
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>

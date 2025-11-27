<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Tidak Ditemukan | SKPI FT UNIB</title>
    
    <link rel="icon" type="image/png" href="{{ asset('images/logo-ft.png') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .pattern-grid {
            background-image: linear-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
            background-size: 20px 20px;
        }
    </style>
</head>
<body class="min-h-screen bg-slate-50 flex items-center justify-center p-4 selection:bg-orange-500 selection:text-white">

    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-[10%] -left-[10%] w-96 h-96 bg-blue-200/40 rounded-full blur-3xl mix-blend-multiply animate-pulse"></div>
        <div class="absolute top-[20%] -right-[10%] w-96 h-96 bg-orange-100/60 rounded-full blur-3xl mix-blend-multiply"></div>
    </div>

    <main class="relative z-10 w-full max-w-5xl bg-white rounded-3xl shadow-2xl shadow-slate-200/50 overflow-hidden border border-slate-100">
        <div class="grid grid-cols-1 lg:grid-cols-2 min-h-[500px]">
            
            <div class="relative bg-[#1b3985] p-10 flex flex-col justify-between overflow-hidden">
                <div class="absolute inset-0 pattern-grid"></div>
                <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-blue-500/20 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-64 h-64 bg-indigo-600/30 rounded-full blur-3xl"></div>

                <div class="relative z-10 flex items-center gap-3">
                    <img src="{{ asset('images/logo-ft.png') }}" alt="Logo FT" class="h-10 w-10">
                    <div class="text-white/90">
                        <p class="text-xs font-bold uppercase tracking-widest opacity-70">Sistem Akademik</p>
                        <p class="font-bold leading-none">Fakultas Teknik</p>
                    </div>
                </div>

                <div class="relative z-10 my-12 text-center lg:text-left">
                    <h1 class="text-[150px] font-black text-white/10 leading-none select-none absolute -top-20 -left-6 lg:-left-10">404</h1>
                    <h2 class="text-4xl lg:text-5xl font-bold text-white mb-4 relative">Halaman<br>Hilang.</h2>
                    <p class="text-blue-100 text-sm lg:text-base leading-relaxed max-w-md">
                        Jalur yang Anda tempuh tidak ditemukan dalam peta situs kami. Mungkin halaman telah dipindahkan, dihapus, atau tautan yang Anda tuju salah.
                    </p>
                </div>

                <div class="relative z-10 flex items-center gap-2 text-white/60 text-xs font-medium uppercase tracking-wider">
                    <span class="w-8 h-[1px] bg-white/40"></span>
                    Universitas Bengkulu
                </div>
            </div>

            <div class="flex flex-col justify-center p-8 lg:p-16 bg-white">
                <div class="mb-8">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-orange-50 text-orange-500 mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L2.34 18c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-2">Terjadi Kesalahan Navigasi</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">
                        Jangan khawatir, data akademik Anda aman. Silakan gunakan tombol di bawah ini untuk kembali ke jalur yang benar.
                    </p>
                </div>

                <div class="space-y-3">
                    <a href="{{ route('dashboard') }}" 
                       class="flex items-center justify-center w-full gap-2 px-6 py-3.5 text-sm font-bold text-white transition-all bg-[#fa7516] rounded-xl hover:bg-[#e0630e] hover:shadow-lg hover:shadow-orange-500/20 focus:ring-4 focus:ring-orange-500/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-9 8h4m-7 0h3m4 0h3" />
                        </svg>
                        Kembali ke Dashboard
                    </a>
                    
                    <a href="{{ url('/') }}" 
                       class="flex items-center justify-center w-full gap-2 px-6 py-3.5 text-sm font-bold text-slate-600 transition-all bg-white border border-slate-200 rounded-xl hover:bg-slate-50 hover:text-[#1b3985] hover:border-blue-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Halaman Utama
                    </a>
                </div>

                <div class="mt-10 pt-6 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                </div>
            </div>
        </div>
    </main>

</body>
</html>
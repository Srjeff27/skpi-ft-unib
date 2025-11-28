<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi SKPI - Fakultas Teknik UNIB</title>
    
    <link rel="icon" type="image/png" href="{{ asset('images/logo-ft.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    animation: { 'fade-in-up': 'fadeInUp 0.6s ease-out forwards' },
                    keyframes: { fadeInUp: { '0%': { opacity: '0', transform: 'translateY(10px)' }, '100%': { opacity: '1', transform: 'translateY(0)' } } }
                }
            }
        }
        // Frame buster protection
        if (window.top !== window.self) window.top.location = window.location;
    </script>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex items-center justify-center p-4 selection:bg-blue-100 selection:text-blue-900">

    <div class="fixed inset-0 z-0 opacity-[0.03]" 
         style="background-image: radial-gradient(#1b3985 1px, transparent 1px); background-size: 24px 24px;">
    </div>

    <div class="relative w-full max-w-md bg-white rounded-2xl shadow-[0_20px_50px_rgba(8,_112,_184,_0.07)] border border-slate-100 overflow-hidden animate-fade-in-up z-10">
        
        <div class="h-2 w-full bg-gradient-to-r from-[#1b3985] to-[#2b50a8]"></div>

        <div class="p-8">
            <div class="text-center mb-8">
                <img src="{{ asset('images/logo-ft.png') }}" alt="Logo FT UNIB" class="h-16 w-auto mx-auto mb-4 drop-shadow-sm">
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">Verifikasi Dokumen Digital</h1>
                <p class="text-sm text-slate-500 font-medium">Fakultas Teknik Universitas Bengkulu</p>
            </div>

            <div class="flex flex-col items-center justify-center p-4 mb-8 bg-emerald-50 rounded-xl border border-emerald-100 text-center">
                <div class="bg-white p-2 rounded-full shadow-sm mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <h2 class="text-lg font-bold text-emerald-800">Dokumen Valid</h2>
                <p class="text-xs text-emerald-600 mt-0.5">Data tercatat dalam sistem database SKPI</p>
            </div>

            <div class="space-y-4">
                <div class="flex items-start gap-4 p-3 rounded-lg hover:bg-slate-50 transition-colors">
                    <div class="flex-shrink-0 mt-0.5 text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Nama Mahasiswa</p>
                        <p class="text-sm font-bold text-slate-800">{{ $user->name }}</p>
                    </div>
                </div>

                <div class="flex items-start gap-4 p-3 rounded-lg hover:bg-slate-50 transition-colors">
                    <div class="flex-shrink-0 mt-0.5 text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 2a1 1 0 00-1 1v1a1 1 0 002 0V3a1 1 0 00-1-1zM4 4h3a3 3 0 006 0h3a2 2 0 012 2v9a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2zm2.5 7a1.5 1.5 0 100-3 1.5 1.5 0 000 3zm2.45 4a2.5 2.5 0 10-4.9 0h4.9zM12 9a1 1 0 100 2h3a1 1 0 100-2h-3zm-1 4a1 1 0 011-1h2a1 1 0 110 2h-2a1 1 0 01-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">NPM (Nomor Pokok Mahasiswa)</p>
                        <p class="text-sm font-bold text-slate-800 tracking-wide">{{ $user->nim ?? '-' }}</p>
                    </div>
                </div>

                <div class="flex items-start gap-4 p-3 rounded-lg hover:bg-slate-50 transition-colors">
                    <div class="flex-shrink-0 mt-0.5 text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM12 18a1 1 0 100-2 1 1 0 000 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Program Studi</p>
                        <p class="text-sm font-bold text-slate-800">{{ optional($user->prodi)->nama_prodi ?? '-' }}</p>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-6 pt-6 border-t border-slate-100">
                    <span class="text-sm text-slate-500">Total Portofolio Terverifikasi</span>
                    <span class="inline-flex items-center justify-center h-8 px-4 rounded-full bg-blue-50 text-blue-700 font-bold text-sm border border-blue-100">
                        {{ $verifiedCount }} Item
                    </span>
                </div>
            </div>
        </div>

        <div class="bg-slate-50 px-8 py-4 border-t border-slate-100 text-center">
            <p class="text-[10px] text-slate-400 leading-relaxed">
                Halaman ini adalah bukti verifikasi digital resmi yang dikeluarkan oleh Sistem SKPI Fakultas Teknik Universitas Bengkulu.
            </p>
        </div>
    </div>

</body>
</html>
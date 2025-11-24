<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SKPI - Fakultas Teknik UNIB</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo-ft.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Custom Animations */
        .animate-enter-up { animation: enterUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; transform: translateY(20px); }
        .animate-enter-right { animation: enterRight 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.2s forwards; opacity: 0; transform: translateX(-20px); }
        .animate-float { animation: float 6s ease-in-out infinite; }
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        
        @keyframes enterUp { to { opacity: 1; transform: translateY(0); } }
        @keyframes enterRight { to { opacity: 1; transform: translateX(0); } }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }

        /* Glassmorphism */
        .glass-panel {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>

<body class="text-slate-900 antialiased bg-slate-50">

    <div class="min-h-screen flex flex-col lg:flex-row">
        
        <div class="hidden lg:flex lg:w-1/2 xl:w-2/3 relative bg-[#0A2E73] overflow-hidden justify-center items-center">
            <div class="absolute inset-0 bg-cover bg-center opacity-80 scale-105 transition-transform duration-[20s] hover:scale-110" 
                 style="background-image: url('{{ asset('images/background-ft.jpg') }}'); filter: saturate(1.1);">
            </div>
            
            <div class="absolute inset-0 bg-gradient-to-tr from-[#0A2E73]/55 via-[#0A2E73]/45 to-[#1E3A8A]/35"></div>
            
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-blue-400 rounded-full blur-3xl opacity-20 animate-pulse"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 bg-orange-500 rounded-full blur-3xl opacity-10"></div>

            <div class="relative z-10 w-full max-w-2xl px-12 flex flex-col justify-between h-full py-12">
                
                <div class="flex items-center gap-4 animate-enter-right">
                    <img src="{{ asset('images/logo-ft.png') }}" alt="Logo FT" class="h-12 w-auto drop-shadow-md">
                    <div class="text-white">
                        <h2 class="font-bold text-lg leading-tight">Fakultas Teknik</h2>
                        <p class="text-xs text-blue-200 font-medium tracking-wide">UNIVERSITAS BENGKULU</p>
                    </div>
                </div>

                <div class="space-y-6 animate-enter-up delay-100">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 backdrop-blur-md text-orange-300 text-xs font-bold uppercase tracking-wider">
                        <span class="relative flex h-2 w-2">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2 w-2 bg-orange-500"></span>
                        </span>
                        Portal Resmi SKPI
                    </div>
                    <h1 class="text-4xl xl:text-5xl font-extrabold text-white leading-tight">
                        Wujudkan Karir Gemilang dengan <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-orange-200">Portofolio Terverifikasi.</span>
                    </h1>
                    <p class="text-lg text-blue-100/90 leading-relaxed max-w-lg">
                        Sistem terintegrasi untuk merekam jejak prestasi, organisasi, dan sertifikasi mahasiswa Fakultas Teknik UNIB secara digital dan profesional.
                    </p>
                </div>

                <div class="self-start animate-enter-up delay-200">
                    <div class="glass-panel p-4 rounded-2xl flex items-center gap-4 shadow-2xl animate-float">
                        <div class="bg-white p-3 rounded-xl text-[#0A2E73] shadow-sm">
                            <x-heroicon-o-check-badge class="w-6 h-6" />
                        </div>
                        <div>
                            <p class="text-[10px] text-blue-200 uppercase font-bold tracking-wider">Keamanan Data</p>
                            <p class="text-sm font-bold text-white">Terenkripsi & Valid</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full lg:w-1/2 xl:w-1/3 flex flex-col justify-center items-center p-6 sm:p-12 bg-white relative">
            <div class="lg:hidden absolute top-8 left-0 w-full flex justify-center mb-8">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo-ft.png') }}" alt="Logo" class="h-10 w-auto">
                    <div class="text-[#0A2E73]">
                        <h2 class="font-bold text-lg leading-none">SKPI</h2>
                        <p class="text-[10px] font-bold tracking-widest uppercase text-orange-600">Fakultas Teknik</p>
                    </div>
                </div>
            </div>

            <div class="absolute inset-0 opacity-[0.03] pointer-events-none" 
                 style="background-image: radial-gradient(#0A2E73 1px, transparent 1px); background-size: 24px 24px;">
            </div>

            <div class="w-full max-w-md bg-white z-10 animate-enter-up">
                {{ $slot }}
            </div>
            
            <div class="mt-8 text-center text-xs text-slate-400">
                &copy; {{ date('Y') }} Fakultas Teknik, Universitas Bengkulu.
            </div>
        </div>
    </div>

    <button id="chatbot-toggle" aria-label="Bantuan"
        class="fixed bottom-6 right-6 z-50 group flex items-center justify-center transition-transform hover:scale-110 active:scale-95">
        <div class="absolute inset-0 bg-orange-400 rounded-full blur opacity-40 group-hover:opacity-60 transition duration-300"></div>
        <div class="relative flex h-14 w-14 items-center justify-center rounded-full bg-[#F97316] shadow-xl ring-4 ring-white/50 group-hover:bg-[#e8630b] transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-7 h-7 text-white">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </div>
    </button>

    <div id="chatbot-panel"
        class="fixed bottom-24 right-6 z-50 hidden w-80 max-w-[90vw] rounded-2xl border border-gray-100 bg-white shadow-2xl overflow-hidden transform transition-all duration-300 scale-95 opacity-0 origin-bottom-right">
        
        <div class="bg-[#0A2E73] p-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></div>
                <span class="font-bold text-white text-sm">Bantuan SKPI</span>
            </div>
            <button id="chatbot-close" class="text-white/70 hover:text-white transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <div class="p-5 bg-slate-50 space-y-4">
            <p class="text-sm text-slate-600 bg-white p-3 rounded-tr-xl rounded-b-xl shadow-sm border border-slate-100">
                Halo! 👋 Ada kendala saat login atau registrasi? Hubungi kami di:
            </p>
            
            <div class="space-y-3">
                <div class="flex items-center justify-between bg-white p-3 rounded-lg border border-slate-100 shadow-sm hover:border-orange-200 transition">
                    <div>
                        <p class="text-[10px] text-slate-400 uppercase tracking-wider font-bold">WhatsApp Admin</p>
                        <a href="tel:081234567890" class="font-bold text-[#0A2E73] text-sm hover:text-[#F97316]">0812-3456-7890</a>
                    </div>
                    <button data-copy="081234567890" class="copy-btn text-xs bg-slate-100 text-slate-600 px-2 py-1 rounded hover:bg-slate-200 transition">Salin</button>
                </div>

                <a href="mailto:helpdesk.ft@unib.ac.id" class="flex items-center justify-center w-full gap-2 bg-[#F97316] text-white py-2.5 rounded-lg text-sm font-bold hover:bg-[#e8630b] transition shadow-md hover:shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    Kirim Email
                </a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggle = document.getElementById('chatbot-toggle');
            const panel = document.getElementById('chatbot-panel');
            const closeBtn = document.getElementById('chatbot-close');

            if (toggle && panel && closeBtn) {
                const toggleChat = () => {
                    if(panel.classList.contains('hidden')) {
                        panel.classList.remove('hidden');
                        setTimeout(() => panel.classList.remove('scale-95', 'opacity-0'), 10);
                    } else {
                        panel.classList.add('scale-95', 'opacity-0');
                        setTimeout(() => panel.classList.add('hidden'), 300);
                    }
                };
                toggle.addEventListener('click', toggleChat);
                closeBtn.addEventListener('click', toggleChat);
            }

            // Copy to clipboard functionality
            document.querySelectorAll('.copy-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const originalText = this.textContent;
                    const textToCopy = this.getAttribute('data-copy');
                    
                    navigator.clipboard.writeText(textToCopy).then(() => {
                        this.textContent = 'Disalin!';
                        this.classList.add('bg-green-100', 'text-green-700');
                        setTimeout(() => {
                            this.textContent = originalText;
                            this.classList.remove('bg-green-100', 'text-green-700');
                        }, 2000);
                    });
                });
            });
        });
    </script>
</body>
</html>

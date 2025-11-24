<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('SKPI - Fakultas Teknik UNIB') }}</title>
    
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logo-ft.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo-ft.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-ft.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    @vite('resources/css/app.css')

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        details > summary { list-style: none; }
        details > summary::-webkit-details-marker { display: none; }
        details[open] summary ~ * { animation: sweep .3s ease-in-out; }
        @keyframes sweep {
            0%    {opacity: 0; transform: translateY(-10px)}
            100%  {opacity: 1; transform: translateY(0)}
        }
        details[open] summary svg.chevron { transform: rotate(180deg); }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        .animate-float { animation: float 6s ease-in-out infinite; }

        .text-gradient {
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-image: linear-gradient(to right, #F97316, #fb923c);
        }

        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased overflow-x-hidden selection:bg-orange-500 selection:text-white">

    <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
        <div class="absolute top-[-10%] right-[-5%] w-[500px] h-[500px] bg-blue-100/50 rounded-full blur-3xl opacity-60 mix-blend-multiply filter"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-[600px] h-[600px] bg-orange-100/40 rounded-full blur-3xl opacity-60 mix-blend-multiply filter"></div>
    </div>

    <header id="navbar" class="fixed w-full top-0 z-50 transition-all duration-300 border-b border-transparent">
        <div class="absolute inset-0 bg-white/80 backdrop-blur-md shadow-sm -z-10"></div>
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
            <a href="#beranda" class="flex items-center gap-3 group">
                <div class="relative">
                    <div class="absolute inset-0 bg-orange-500 blur rounded-full opacity-20 group-hover:opacity-40 transition"></div>
                    <img src="{{ asset('images/logo-ft.png') }}" alt="Logo FT UNIB" class="relative h-10 w-10 transform transition group-hover:scale-110">
                </div>
                <div class="flex flex-col">
                    <span class="font-bold text-[#0A2E73] leading-none tracking-tight">Fakultas Teknik</span>
                    <span class="text-xs font-medium text-slate-500 tracking-wide">Universitas Bengkulu</span>
                </div>
            </a>

            <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-slate-600">
                <a href="#tentang" class="hover:text-[#0A2E73] transition-colors relative after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-0 after:bg-[#F97316] after:transition-all hover:after:w-full">Tentang</a>
                <a href="#fitur" class="hover:text-[#0A2E73] transition-colors relative after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-0 after:bg-[#F97316] after:transition-all hover:after:w-full">Fitur</a>
                <a href="#panduan" class="hover:text-[#0A2E73] transition-colors relative after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-0 after:bg-[#F97316] after:transition-all hover:after:w-full">Panduan</a>
                <div class="pl-4 border-l border-slate-200">
                    @guest
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-bold text-white transition-all duration-200 bg-[#0A2E73] border border-transparent rounded-full shadow-lg hover:bg-[#072257] hover:shadow-[#0A2E73]/30 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0A2E73]">
                            Login 
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-bold text-white transition-all duration-200 bg-[#F97316] border border-transparent rounded-full shadow-lg hover:bg-[#e8630b] hover:shadow-orange-500/30 hover:-translate-y-0.5">
                            Dashboard
                        </a>
                    @endguest
                </div>
            </nav>

            <div class="md:hidden">
                <button id="mobile-menu-btn" class="p-2 text-slate-600 rounded-lg hover:bg-slate-100 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="hidden absolute top-full left-0 w-full bg-white border-b border-slate-100 shadow-xl md:hidden">
            <div class="flex flex-col p-4 space-y-4">
                <a href="#tentang" class="px-4 py-2 font-medium text-slate-700 hover:bg-slate-50 rounded-lg">Tentang</a>
                <a href="#fitur" class="px-4 py-2 font-medium text-slate-700 hover:bg-slate-50 rounded-lg">Fitur</a>
                <a href="#panduan" class="px-4 py-2 font-medium text-slate-700 hover:bg-slate-50 rounded-lg">Panduan</a>
                <hr>
                @guest
                    <a href="{{ route('login') }}" class="w-full text-center px-4 py-3 bg-[#0A2E73] text-white rounded-lg font-bold">Login</a>
                @else
                    <a href="{{ route('dashboard') }}" class="w-full text-center px-4 py-3 bg-[#F97316] text-white rounded-lg font-bold">Dashboard</a>
                @endguest
            </div>
        </div>
    </header>

    <main>
        <section id="beranda" class="relative pt-32 pb-20 lg:pt-40 lg:pb-28 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-slate-50 via-blue-50/50 to-white -z-20"></div>
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-gradient-to-br from-blue-600/10 to-transparent blur-3xl"></div>
            
            <div class="mx-auto max-w-7xl px-6">
                <div class="grid lg:grid-cols-2 gap-12 lg:gap-8 items-center">
                    <div data-aos="fade-right" data-aos-duration="1000">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-100/50 border border-blue-200 text-[#0A2E73] text-xs font-bold uppercase tracking-wider mb-6">
                            <span class="w-2 h-2 rounded-full bg-[#F97316] animate-pulse"></span>
                            Official System FT UNIB
                        </div>
                        <h1 class="text-4xl lg:text-6xl font-extrabold text-[#0A2E73] leading-tight mb-6">
                            Rekam Jejakmu,<br>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#F97316] to-orange-400">Masa Depanmu.</span>
                        </h1>
                        <p class="text-lg text-slate-600 mb-8 leading-relaxed max-w-lg">
                            Sistem Informasi Surat Keterangan Pendamping Ijazah (SKPI). Catat prestasi akademik dan non-akademik Anda secara digital, terverifikasi, dan profesional.
                        </p>
                        
                        <div class="flex flex-col sm:flex-row gap-4">
                            @guest
                                <a href="{{ route('login') }}" class="group relative inline-flex items-center justify-center px-8 py-3.5 text-base font-bold text-white transition-all duration-200 bg-[#0A2E73] rounded-full shadow-lg hover:bg-[#072257] hover:shadow-xl hover:-translate-y-1 overflow-hidden">
                                    <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:animate-[shimmer_1.5s_infinite]"></span>
                                    Mulai Sekarang
                                    <svg class="w-5 h-5 ml-2 -mr-1 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-8 py-3.5 text-base font-bold text-white transition-all duration-200 bg-[#F97316] rounded-full shadow-lg hover:bg-[#e8630b] hover:shadow-orange-500/30 hover:-translate-y-1">
                                    Buka Dashboard
                                </a>
                            @endguest
                            <a href="#tentang" class="inline-flex items-center justify-center px-8 py-3.5 text-base font-bold text-slate-600 transition-all duration-200 bg-white border border-slate-200 rounded-full hover:bg-slate-50 hover:text-[#0A2E73] hover:border-blue-200 hover:shadow-md">
                                Pelajari Dulu
                            </a>
                        </div>
                    </div>

                    <div class="relative hidden lg:block" data-aos="fade-left" data-aos-duration="1200">
                        <div class="relative z-10 animate-float">
                            <img src="{{ asset('images/background-ft.jpg') }}" alt="Gedung FT UNIB" class="rounded-3xl shadow-2xl border-4 border-white/50 w-full object-cover h-[500px] mask-image-b">
                            
                            <div class="absolute -left-8 bottom-12 bg-white/90 backdrop-blur-md p-4 rounded-2xl shadow-xl border border-white/50 flex items-center gap-4 animate-[bounce_3s_infinite]">
                                <div class="bg-blue-100 p-3 rounded-xl">
                                    <svg class="w-6 h-6 text-[#0A2E73]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500 font-semibold uppercase">Status Data</p>
                                    <p class="text-sm font-bold text-[#0A2E73]">Terverifikasi Valid</p>
                                </div>
                            </div>

                            <div class="absolute -right-8 top-12 bg-white/90 backdrop-blur-md p-4 rounded-2xl shadow-xl border border-white/50 flex items-center gap-4 animate-[bounce_4s_infinite]">
                                <div class="bg-orange-100 p-3 rounded-xl">
                                    <svg class="w-6 h-6 text-[#F97316]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500 font-semibold uppercase">Portfolio</p>
                                    <p class="text-sm font-bold text-[#0A2E73]">Mudah Diupload</p>
                                </div>
                            </div>
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-tr from-[#0A2E73] to-[#1E3A8A] rounded-3xl transform rotate-3 scale-95 opacity-20 -z-10 blur-sm"></div>
                    </div>
                </div>
            </div>
        </section>

        <section id="tentang" class="py-20 bg-white relative">
            <div class="mx-auto max-w-7xl px-6">
                <div class="text-center max-w-3xl mx-auto mb-16" data-aos="fade-up">
                    <h2 class="text-3xl lg:text-4xl font-bold text-[#0A2E73] mb-4">Apa Itu <span class="text-gradient">SKPI?</span></h2>
                    <p class="text-slate-600 text-lg">Dokumen resmi pendamping ijazah yang merekam jejak kemampuan, pengetahuan, dan sikap mahasiswa selama menempuh pendidikan di Universitas Bengkulu.</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <div class="group p-8 rounded-3xl bg-slate-50 border border-slate-100 hover:bg-white hover:shadow-2xl hover:shadow-blue-900/10 transition-all duration-300 relative overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                        <div class="absolute top-0 right-0 -mr-8 -mt-8 w-24 h-24 bg-blue-100 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
                        <div class="w-14 h-14 bg-white rounded-2xl shadow-sm flex items-center justify-center text-blue-600 mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-[#0A2E73] mb-3">Sertifikasi & Pelatihan</h3>
                        <p class="text-slate-600 leading-relaxed">Mencatat segala bentuk pelatihan profesi, workshop, dan sertifikasi kompetensi yang diikuti.</p>
                    </div>

                    <div class="group p-8 rounded-3xl bg-slate-50 border border-slate-100 hover:bg-white hover:shadow-2xl hover:shadow-orange-500/10 transition-all duration-300 relative overflow-hidden" data-aos="fade-up" data-aos-delay="200">
                        <div class="absolute top-0 right-0 -mr-8 -mt-8 w-24 h-24 bg-orange-100 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
                        <div class="w-14 h-14 bg-white rounded-2xl shadow-sm flex items-center justify-center text-orange-500 mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-[#0A2E73] mb-3">Prestasi & Penghargaan</h3>
                        <p class="text-slate-600 leading-relaxed">Rekam jejak kemenangan lomba, hibah penelitian, dan penghargaan akademik maupun non-akademik.</p>
                    </div>

                    <div class="group p-8 rounded-3xl bg-slate-50 border border-slate-100 hover:bg-white hover:shadow-2xl hover:shadow-blue-900/10 transition-all duration-300 relative overflow-hidden" data-aos="fade-up" data-aos-delay="300">
                        <div class="absolute top-0 right-0 -mr-8 -mt-8 w-24 h-24 bg-blue-100 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
                        <div class="w-14 h-14 bg-white rounded-2xl shadow-sm flex items-center justify-center text-blue-600 mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-[#0A2E73] mb-3">Keaktifan Organisasi</h3>
                        <p class="text-slate-600 leading-relaxed">Pengalaman kepemimpinan dan kepanitiaan dalam organisasi kemahasiswaan atau masyarakat.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="fitur" class="py-20 bg-slate-50">
            <div class="mx-auto max-w-7xl px-6">
                <div class="text-center mb-16" data-aos="fade-up">
                    <h2 class="text-3xl lg:text-4xl font-bold text-[#0A2E73]">Fitur <span class="text-gradient">Unggulan</span></h2>
                    <p class="mt-4 text-slate-600">Dirancang untuk kemudahan mahasiswa dan akurasi data fakultas.</p>
                </div>

                <div class="grid lg:grid-cols-3 gap-8">
                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 hover:-translate-y-2 hover:shadow-xl transition-all duration-300" data-aos="fade-up" data-aos-delay="100">
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center text-[#F97316] mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-[#0A2E73] mb-3">Multi-Upload Support</h3>
                        <p class="text-slate-600 text-sm">Unggah bukti pendukung dalam format PDF atau JPG dengan mudah. Sistem akan memvalidasi format secara otomatis.</p>
                    </div>

                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 hover:-translate-y-2 hover:shadow-xl transition-all duration-300" data-aos="fade-up" data-aos-delay="200">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center text-[#0A2E73] mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-[#0A2E73] mb-3">Real-time Validation</h3>
                        <p class="text-slate-600 text-sm">Pantau status validasi dokumen Anda (Diterima, Ditolak, atau Revisi) secara langsung melalui dashboard.</p>
                    </div>

                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 hover:-translate-y-2 hover:shadow-xl transition-all duration-300" data-aos="fade-up" data-aos-delay="300">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center text-green-600 mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-[#0A2E73] mb-3">Auto-Generate PDF</h3>
                        <p class="text-slate-600 text-sm">Dokumen SKPI final akan digenerate otomatis sesuai format standar Dikti, siap dicetak saat wisuda.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="panduan" class="py-20 bg-white">
            <div class="mx-auto max-w-5xl px-6">
                <div class="mb-20">
                    <h2 class="text-3xl font-bold text-center text-[#0A2E73] mb-12" data-aos="fade-up">Alur Pengajuan</h2>
                    <div class="relative">
                        <div class="absolute left-4 md:left-1/2 transform md:-translate-x-1/2 top-0 h-full w-0.5 bg-slate-200"></div>
                        
                        <div class="relative flex items-start md:items-center justify-between mb-12" data-aos="fade-up">
                            <div class="absolute left-0 top-0 md:static md:relative z-10 flex items-center justify-center w-8 h-8 bg-[#F97316] rounded-full shadow ring-4 ring-white md:order-2 flex-shrink-0">
                                <span class="text-white text-xs font-bold">1</span>
                            </div>
                            <div class="w-full pl-12 md:pl-0 md:w-5/12 md:text-right md:pr-8 md:order-1">
                                <h3 class="text-lg font-bold text-[#0A2E73]">1. Registrasi Akun</h3>
                                <p class="text-sm text-slate-600 mt-1">Mahasiswa mendaftar menggunakan NIM dan email institusi.</p>
                            </div>
                            <div class="hidden md:block md:w-5/12 md:order-3"></div>
                        </div>

                        <div class="relative flex items-start md:items-center justify-between mb-12" data-aos="fade-up">
                            <div class="absolute left-0 top-0 md:static md:relative z-10 flex items-center justify-center w-8 h-8 bg-[#0A2E73] rounded-full shadow ring-4 ring-white md:order-2 flex-shrink-0">
                                <span class="text-white text-xs font-bold">2</span>
                            </div>
                            <div class="hidden md:block md:w-5/12 md:order-1"></div>
                            <div class="w-full pl-12 md:pl-0 md:w-5/12 md:text-left md:pl-8 md:order-3">
                                <h3 class="text-lg font-bold text-[#0A2E73]">2. Input Portofolio</h3>
                                <p class="text-sm text-slate-600 mt-1">Mengisi data kegiatan dan mengunggah bukti pendukung secara berkala.</p>
                            </div>
                        </div>

                        <div class="relative flex items-start md:items-center justify-between mb-12" data-aos="fade-up">
                            <div class="absolute left-0 top-0 md:static md:relative z-10 flex items-center justify-center w-8 h-8 bg-[#0A2E73] rounded-full shadow ring-4 ring-white md:order-2 flex-shrink-0">
                                <span class="text-white text-xs font-bold">3</span>
                            </div>
                            <div class="w-full pl-12 md:pl-0 md:w-5/12 md:text-right md:pr-8 md:order-1">
                                <h3 class="text-lg font-bold text-[#0A2E73]">3. Validasi Admin</h3>
                                <p class="text-sm text-slate-600 mt-1">Admin prodi memverifikasi keabsahan dokumen yang diunggah.</p>
                            </div>
                            <div class="hidden md:block md:w-5/12 md:order-3"></div>
                        </div>

                        <div class="relative flex items-start md:items-center justify-between mb-4" data-aos="fade-up">
                            <div class="absolute left-0 top-0 md:static md:relative z-10 flex items-center justify-center w-8 h-8 bg-green-500 rounded-full shadow ring-4 ring-white md:order-2 flex-shrink-0">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div class="hidden md:block md:w-5/12 md:order-1"></div>
                            <div class="w-full pl-12 md:pl-0 md:w-5/12 md:text-left md:pl-8 md:order-3">
                                <h3 class="text-lg font-bold text-[#0A2E73]">4. Penerbitan SKPI</h3>
                                <p class="text-sm text-slate-600 mt-1">SKPI diterbitkan, ditandatangani Dekan, dan diserahkan saat wisuda.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="max-w-3xl mx-auto">
                    <h3 class="text-2xl font-bold text-center text-[#0A2E73] mb-8" data-aos="fade-up">Pertanyaan Umum</h3>
                    <div class="space-y-4" data-aos="fade-up" data-aos-delay="100">
                        <details class="group bg-slate-50 border border-slate-200 p-4 rounded-xl [&_summary::-webkit-details-marker]:hidden cursor-pointer transition duration-300 hover:shadow-md">
                            <summary class="flex items-center justify-between font-bold text-[#0A2E73]">
                                Apakah wajib mengisi SKPI?
                                <svg class="chevron ml-2 h-5 w-5 text-slate-400 transition-transform duration-300 group-open:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </summary>
                            <p class="mt-4 text-slate-600 text-sm leading-relaxed">
                                Ya, berdasarkan peraturan akademik terbaru, SKPI menjadi dokumen wajib pendamping ijazah yang menunjukkan kompetensi tambahan lulusan selain nilai akademik.
                            </p>
                        </details>
                        <details class="group bg-slate-50 border border-slate-200 p-4 rounded-xl [&_summary::-webkit-details-marker]:hidden cursor-pointer transition duration-300 hover:shadow-md">
                            <summary class="flex items-center justify-between font-bold text-[#0A2E73]">
                                Kapan sebaiknya mulai mengisi?
                                <svg class="chevron ml-2 h-5 w-5 text-slate-400 transition-transform duration-300 group-open:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </summary>
                            <p class="mt-4 text-slate-600 text-sm leading-relaxed">
                                Sangat disarankan untuk mulai mengisi sejak Semester 1. Cicil penginputan data setiap kali Anda mendapatkan sertifikat baru agar tidak menumpuk di akhir masa studi.
                            </p>
                        </details>
                        <details class="group bg-slate-50 border border-slate-200 p-4 rounded-xl [&_summary::-webkit-details-marker]:hidden cursor-pointer transition duration-300 hover:shadow-md">
                            <summary class="flex items-center justify-between font-bold text-[#0A2E73]">
                                Apa saja yang bisa diklaim?
                                <svg class="chevron ml-2 h-5 w-5 text-slate-400 transition-transform duration-300 group-open:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </summary>
                            <p class="mt-4 text-slate-600 text-sm leading-relaxed">
                                Prestasi lomba (Juara/Finalis), keikutsertaan organisasi (Pengurus/Panitia), pelatihan/seminar, sertifikasi keahlian, dan kegiatan pengabdian masyarakat.
                            </p>
                        </details>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-[#0A2E73] text-white pt-16 pb-8 border-t-[6px] border-[#F97316]">
        <div class="mx-auto max-w-7xl px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
                <div class="space-y-4">
                    <img src="{{ asset('images/logo-ft.png') }}" alt="Logo FT" class="h-12 w-auto">
                    <h3 class="text-xl font-bold">Fakultas Teknik<br><span class="text-sm font-normal opacity-80">Universitas Bengkulu</span></h3>
                    <p class="text-sm text-blue-200/80 leading-relaxed">
                        Membangun peradaban melalui rekayasa teknologi yang unggul dan berdaya saing global.
                    </p>
                </div>

                <div>
                    <h4 class="font-bold text-lg mb-4 text-[#F97316]">Tautan Cepat</h4>
                    <ul class="space-y-2 text-sm text-blue-100/80">
                        <li><a href="https://unib.ac.id" target="_blank" class="hover:text-white hover:underline">Web Universitas</a></li>
                        <li><a href="#" class="hover:text-white hover:underline">SIAKAD UNIB</a></li>
                        <li><a href="#" class="hover:text-white hover:underline">Perpustakaan</a></li>
                        <li><a href="#" class="hover:text-white hover:underline">E-Learning</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-lg mb-4 text-[#F97316]">Kontak Kami</h4>
                    <ul class="space-y-3 text-sm text-blue-100/80">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>Jl. W.R. Supratman, Kandang Limun, Muara Bangkahulu, Bengkulu 38371</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span>ft@unib.ac.id</span>
                        </li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-lg mb-4 text-[#F97316]">Media Sosial</h4>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-[#F97316] transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-[#F97316] transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-blue-900/50 pt-8 text-center text-sm text-blue-200/60">
                <p>&copy; {{ date('Y') }} Fakultas Teknik, Universitas Bengkulu. All rights reserved.</p>
                <p class="mt-2 text-xs">Developed by Team PPSI - Sistem Informasi</p>
            </div>
        </div>
    </footer>

    <button id="chatbot-toggle" aria-label="Kontak admin" class="fixed bottom-6 right-6 z-50 flex h-14 w-14 items-center justify-center rounded-full bg-[#F97316] text-white shadow-xl transition-transform hover:scale-110 hover:bg-[#E8630B] hover:shadow-orange-500/50 animate-bounce-slow">
        <span class="absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75 animate-ping"></span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
        </svg>
    </button>

    <div id="chatbot-panel" class="fixed bottom-24 right-6 z-50 hidden w-80 max-w-[92vw] rounded-2xl border border-gray-100 bg-white text-gray-800 shadow-2xl overflow-hidden transform transition-all duration-300 scale-95 opacity-0">
        <div class="bg-[#0A2E73] p-4 flex items-center justify-between">
            <span class="font-bold text-white flex items-center gap-2">
                <span class="w-2 h-2 bg-green-400 rounded-full"></span>
                Admin SKPI
            </span>
            <button id="chatbot-close" class="text-white/80 hover:text-white transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        <div class="p-5 bg-slate-50">
            <p class="text-sm text-slate-600 mb-4 bg-white p-3 rounded-tr-xl rounded-b-xl shadow-sm border border-slate-100">Halo! Ada kendala saat pengajuan SKPI? Hubungi kami di:</p>
            
            <div class="space-y-3">
                <div class="flex items-center justify-between bg-white p-3 rounded-lg border border-slate-100 shadow-sm">
                    <div>
                        <p class="text-xs text-slate-500">WhatsApp Admin</p>
                        <p class="font-semibold text-[#0A2E73] text-sm">0812-3456-7890</p>
                    </div>
                    <button data-copy="081234567890" class="copy-btn text-xs bg-slate-100 hover:bg-slate-200 text-slate-600 px-2 py-1 rounded transition">Salin</button>
                </div>
                
                <a href="mailto:helpdesk.ft@unib.ac.id" class="flex items-center justify-center w-full gap-2 bg-[#F97316] text-white py-2 rounded-lg text-sm font-bold hover:bg-[#e8630b] transition shadow-md hover:shadow-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    Kirim Email
                </a>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            offset: 50,
            duration: 800,
            easing: 'ease-out-cubic',
        });

        document.addEventListener('DOMContentLoaded', () => {
            const toggle = document.getElementById('chatbot-toggle');
            const panel = document.getElementById('chatbot-panel');
            const closeBtn = document.getElementById('chatbot-close');
            
            function toggleChat() {
                if(panel.classList.contains('hidden')) {
                    panel.classList.remove('hidden');
                    setTimeout(() => {
                        panel.classList.remove('scale-95', 'opacity-0');
                    }, 10);
                } else {
                    panel.classList.add('scale-95', 'opacity-0');
                    setTimeout(() => {
                        panel.classList.add('hidden');
                    }, 300);
                }
            }

            if(toggle && panel && closeBtn) {
                toggle.addEventListener('click', toggleChat);
                closeBtn.addEventListener('click', toggleChat);
            }

            document.querySelectorAll('.copy-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const originalText = this.textContent;
                    navigator.clipboard.writeText(this.getAttribute('data-copy'));
                    this.textContent = 'Copied!';
                    this.classList.add('bg-green-100', 'text-green-700');
                    setTimeout(() => {
                        this.textContent = originalText;
                        this.classList.remove('bg-green-100', 'text-green-700');
                    }, 2000);
                });
            });

            const menuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if(menuBtn && mobileMenu) {
                menuBtn.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                });
            }

            const navbar = document.getElementById('navbar');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 20) {
                    navbar.classList.add('shadow-md');
                } else {
                    navbar.classList.remove('shadow-md');
                }
            });
        });
    </script>
</body>
</html>
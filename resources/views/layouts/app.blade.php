<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SKPI - FT UNIB') }}</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo-ft.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-ft.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @once
        <style>[x-cloak] { display: none !important; }</style>
    @endonce
</head>

<body class="font-sans text-slate-900 bg-slate-50 antialiased selection:bg-blue-600 selection:text-white">
    
    {{-- Logic Data Akademik --}}
    @php
        $user = auth()->user();
        $needsCompletion = $user && $user->role === 'mahasiswa' && !$user->isAcademicProfileComplete();
        $missingFields = [];
        
        if ($needsCompletion) {
            $labels = [
                'nim' => 'NPM',
                'tempat_lahir' => 'Tempat Lahir',
                'tanggal_lahir' => 'Tanggal Lahir',
                'nomor_hp' => 'Nomor WhatsApp',
                'angkatan' => 'Tahun Angkatan',
                'prodi_id' => 'Program Studi',
            ];
            foreach ($labels as $field => $label) {
                if (blank($user->$field)) $missingFields[] = $label;
            }
        }
    @endphp

    <div x-data="{ isSidebarOpen: false }" class="min-h-screen flex flex-col">
        
        {{-- Top Navigation (Desktop) --}}
        @include('layouts.navigation')

        {{-- Mobile Sidebar Wrapper --}}
        @if (auth()->check() && in_array($user->role, ['admin', 'verifikator']))
            @include('layouts.mobile-sidebar')
        @endif

        {{-- Page Header --}}
        @isset($header)
            <header class="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-30">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        {{-- Main Content Area --}}
        <main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 pb-32 md:pb-12">
            @auth
                <div class="md:grid md:grid-cols-[16rem_1fr] md:gap-8 items-start">
                    {{-- Desktop Sidebar --}}
                    <aside class="hidden md:block sticky top-24">
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 overflow-hidden">
                            @include('layouts.sidebar')
                        </div>
                    </aside>

                    {{-- Content Slot --}}
                    <div class="min-w-0">
                        {{ $slot }}
                    </div>
                </div>
            @else
                {{ $slot }}
            @endauth
        </main>
    </div>

    {{-- ====================================================================== --}}
    {{-- BOTTOM NAVIGATION (MAHASISWA ONLY) --}}
    {{-- ====================================================================== --}}
    @if (auth()->check() && $user->role === 'mahasiswa')
        <nav class="fixed bottom-0 left-0 right-0 z-40 md:hidden pb-safe bg-gradient-to-r from-[#1b3985] to-[#2b50a8] shadow-[0_-6px_24px_rgba(17,24,39,0.18)]">
            <div class="relative grid grid-cols-5 items-center max-w-xl mx-auto px-4 h-[72px] gap-2">
                @php
                    $navs = [
                        ['route' => 'dashboard', 'label' => 'Home', 'icon' => 'heroicon-o-home'],
                        ['route' => 'student.portfolios.index', 'label' => 'Portofolio', 'icon' => 'heroicon-o-briefcase'],
                        ['route' => null, 'label' => '', 'icon' => ''], // Spacer for FAB
                        ['route' => 'student.documents.index', 'label' => 'Dokumen', 'icon' => 'heroicon-o-document-text'],
                        ['route' => 'profile.edit', 'label' => 'Profil', 'icon' => 'heroicon-o-user'],
                    ];
                @endphp

                @foreach ($navs as $item)
                    @if (!$item['route'])
                        <div class="h-full w-full"></div>
                    @else
                        @php $isActive = request()->routeIs($item['route'].'*'); @endphp
                        <a href="{{ route($item['route']) }}" 
                           class="group flex flex-col items-center justify-center w-full h-full transition-colors duration-200">

                            <div class="relative p-1.5 rounded-xl transition-all duration-300 {{ $isActive ? 'text-white bg-white/10 ring-1 ring-white/30 shadow-inner shadow-blue-900/30' : 'text-blue-100/90 group-hover:text-white group-hover:bg-white/10' }}">
                                <x-dynamic-component :component="$item['icon']" 
                                    class="w-6 h-6 {{ $isActive ? 'stroke-2' : 'stroke-[1.5]' }}" />
                            </div>

                            <span class="text-[10px] font-medium mt-1 {{ $isActive ? 'text-white' : 'text-blue-100/90 group-hover:text-white' }}">
                                {{ $item['label'] }}
                            </span>
                        </a>
                    @endif
                @endforeach
            </div>

            {{-- Floating Action Button (FAB) --}}
            <div class="absolute left-1/2 -top-6 -translate-x-1/2">
                <a href="{{ route('student.portfolios.create') }}" 
                   class="flex h-14 w-14 items-center justify-center rounded-full bg-white text-[#1b3985] shadow-lg shadow-blue-900/30 ring-[6px] ring-blue-200 transition-transform hover:scale-105 active:scale-95">
                    <x-heroicon-o-plus class="w-7 h-7 stroke-2" />
                </a>
            </div>
        </nav>
    @endif

    {{-- ====================================================================== --}}
    {{-- MODAL LENGKAPI DATA (ACADEMIC LOCK) --}}
    {{-- ====================================================================== --}}
    @if ($needsCompletion && !request()->routeIs('profile.*'))
        <div class="fixed inset-0 z-[100] flex items-center justify-center px-4 sm:px-6">
            {{-- Backdrop --}}
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

            {{-- Modal Content --}}
            <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden ring-1 ring-black/5 animate-fade-in-up">
                {{-- Decorative Header Bar --}}
                <div class="h-2 w-full bg-gradient-to-r from-orange-500 to-red-500"></div>

                <div class="p-6 sm:p-8">
                    <div class="flex gap-5">
                        <div class="shrink-0">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-orange-100 text-orange-600 ring-4 ring-orange-50">
                                <x-heroicon-o-exclamation-triangle class="w-6 h-6" />
                            </div>
                        </div>
                        <div class="space-y-2">
                            <h3 class="text-xl font-bold text-slate-900">Lengkapi Profil Akademik</h3>
                            <p class="text-sm text-slate-600 leading-relaxed">
                                Untuk melanjutkan aktivitas di sistem SKPI, mohon lengkapi data akademik Anda yang masih kosong.
                            </p>
                        </div>
                    </div>

                    @if (!empty($missingFields))
                        <div class="mt-6 rounded-xl bg-orange-50/50 border border-orange-100 p-4">
                            <p class="text-xs font-bold text-orange-800 uppercase tracking-wide mb-2">Data yang wajib diisi:</p>
                            <ul class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                @foreach ($missingFields as $field)
                                    <li class="flex items-center gap-2 text-sm text-slate-700">
                                        <x-heroicon-s-x-circle class="w-4 h-4 text-orange-400" />
                                        {{ $field }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mt-8 flex flex-col sm:flex-row items-center gap-3 sm:justify-end">
                        <span class="text-xs text-slate-400 hidden sm:inline">Akses menu lain dikunci sementara</span>
                        <a href="{{ route('profile.edit') }}"
                           class="w-full sm:w-auto inline-flex justify-center items-center gap-2 rounded-lg bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white shadow-md hover:bg-slate-800 hover:shadow-lg transition-all focus:ring-2 focus:ring-slate-400 focus:ring-offset-2">
                            Lengkapi Sekarang
                            <x-heroicon-m-arrow-right class="w-4 h-4" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <style>body { overflow: hidden; }</style>
    @endif
    @stack('scripts')
</body>
</html>

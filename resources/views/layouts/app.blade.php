<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('SKPI - FT UNIB') }}</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo-ft.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-ft.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @once
        <style>[x-cloak]{ display:none !important; }</style>
    @endonce
</head>

<body class="font-sans bg-[#f6f9ff] antialiased">
    @php
        $authUser = auth()->user();
        $needsAcademicCompletion = $authUser && $authUser->role === 'mahasiswa' && !$authUser->isAcademicProfileComplete();
        $missingAcademicFields = [];
        if ($needsAcademicCompletion) {
            $fieldLabels = [
                'nim' => 'NPM',
                'tempat_lahir' => 'Tempat Lahir',
                'tanggal_lahir' => 'Tanggal Lahir',
                'nomor_hp' => 'Nomor WhatsApp',
                'angkatan' => 'Tahun Angkatan',
                'prodi_id' => 'Program Studi',
            ];
            foreach ($fieldLabels as $field => $label) {
                if (blank($authUser?->$field)) {
                    $missingAcademicFields[] = $label;
                }
            }
        }
    @endphp

    <div x-data="{ isSidebarOpen: false }" class="min-h-screen">
        @include('layouts.navigation')
        @if (auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'verifikator'))
            @include('layouts.mobile-sidebar')
        @endif

        @isset($header)
            <header class="bg-white shadow">
                <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8 py-6">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8 mt-6 pb-32 md:pb-6">
            @auth
                                                    <div class="md:grid md:grid-cols-[15rem_1fr] md:gap-6">
                                                        <div class="col-span-1">
                                                            @include('layouts.sidebar')
                                                        </div>
                                                        <div class="col-span-1">
                                                            {{ $slot }}
                                                        </div>
                                                    </div>
            @else
                {{ $slot }}
            @endauth
        </main>
    </div>

    {{-- ====================================================================== --}}
    {{-- BAGIAN UNTUK MAHASISWA --}}
    {{-- ====================================================================== --}}
    @if (auth()->check() && auth()->user()->role === 'mahasiswa')

        <nav class="fixed bottom-0 left-0 right-0 z-40 bg-white border-t border-slate-200 shadow-[0_-6px_20px_rgba(15,23,42,0.08)] md:hidden">
            <div class="relative flex items-center justify-around max-w-7xl mx-auto text-[11px] font-semibold text-slate-500">
                @php
                    $navItems = [
                        ['route' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'heroicon-o-home'],
                        ['route' => 'student.portfolios.index', 'label' => 'Portofolio', 'icon' => 'heroicon-o-briefcase'],
                        ['route' => 'placeholder', 'label' => '', 'icon' => ''],
                        ['route' => 'student.documents.index', 'label' => 'Dokumen', 'icon' => 'heroicon-o-document-text'],
                        ['route' => 'profile.edit', 'label' => 'Profil', 'icon' => 'heroicon-o-user-circle'],
                    ];
                @endphp

                @foreach ($navItems as $item)
                    @if ($item['route'] === 'placeholder')
                        <div class="w-16"></div>
                    @else
                        @php $active = request()->routeIs($item['route'].'*'); @endphp
                        <a href="{{ route($item['route']) }}"
                           class="group flex flex-col items-center justify-center w-full py-2 transition">
                            <div class="relative flex h-11 w-11 items-center justify-center rounded-2xl transition-all duration-200 {{ $active ? 'bg-blue-50 text-blue-700 shadow-inner shadow-blue-100' : 'text-slate-500 group-hover:text-blue-700 group-hover:bg-blue-50/70' }}">
                                <x-dynamic-component :component="$item['icon']" class="w-6 h-6" />
                                @if ($active)
                                    <span class="absolute -bottom-1 h-1 w-6 rounded-full bg-blue-600/90"></span>
                                @endif
                            </div>
                            <span class="mt-1">{{ $item['label'] }}</span>
                        </a>
                    @endif
                @endforeach
            </div>

            <a href="{{ route('student.portfolios.create') }}" aria-label="Tambah Portfolio"
               class="absolute left-1/2 top-0 flex h-16 w-16 -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full bg-gradient-to-br from-[#1b3985] to-[#2b50a8] text-white shadow-xl shadow-blue-300/50 ring-4 ring-white transition-all hover:scale-110">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
            </a>
        </nav>

    @endif
    {{-- ====================================================================== --}}
    {{-- END BAGIAN UNTUK MAHASISWA --}}
    {{-- ====================================================================== --}}

    @if ($needsAcademicCompletion && !request()->routeIs('profile.*'))
        <div class="fixed inset-0 z-[70] bg-slate-900/70 backdrop-blur-sm flex items-center justify-center px-4">
            <div class="bg-white w-full max-w-lg rounded-2xl shadow-2xl border border-slate-200 p-6 space-y-4">
                <div class="flex items-start gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-orange-100 text-orange-600">
                        <x-heroicon-o-exclamation-triangle class="w-6 h-6" />
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-[#0A2E73]">Lengkapi Data Akademik</h3>
                        <p class="text-sm text-slate-600">Beberapa data akademik wajib belum lengkap. Silakan lengkapi terlebih dahulu sebelum menambah portofolio atau aktivitas lainnya.</p>
                    </div>
                </div>
                @if (!empty($missingAcademicFields))
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm text-slate-700">
                        <p class="font-semibold mb-2">Data yang perlu dilengkapi:</p>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($missingAcademicFields as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end gap-3">
                    <a href="{{ route('profile.edit') }}"
                       class="inline-flex items-center justify-center gap-2 rounded-lg bg-gradient-to-r from-[#fa7516] to-[#e5670c] px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-orange-200 hover:shadow-orange-300 transition">
                        <x-heroicon-o-arrow-right-circle class="w-5 h-5" />
                        Buka Halaman Profil
                    </a>
                    <p class="text-xs text-slate-500 text-center sm:text-left">Akses lain dinonaktifkan sementara.</p>
                </div>
            </div>
        </div>
        <script>
            document.body.classList.add('overflow-hidden');
        </script>
    @endif


    {{-- Script untuk Toggle Password Visibility (jika dibutuhkan di halaman lain) --}}
    <script>
        function passwordToggle() {
            return {
                showPassword: false,
                togglePassword() {
                    this.showPassword = !this.showPassword;
                }
            }
        }
    </script>

    {{-- Script untuk Admin Mobile Sidebar --}}
    @if (auth()->check() && request()->routeIs('admin.*'))
        <script>
            (function() {
                const btn = document.getElementById('admin-menu-btn');
                const panel = document.getElementById('admin-sidebar');
                const backdrop = document.getElementById('admin-sidebar-backdrop');
                const closeBtn = document.getElementById('admin-sidebar-close');
                if (!btn || !panel || !backdrop) return;
                const open = () => {
                    panel.classList.remove('-translate-x-full');
                    backdrop.classList.remove('hidden');
                };
                const close = () => {
                    panel.classList.add('-translate-x-full');
                    backdrop.classList.add('hidden');
                };
                btn.addEventListener('click', open);
                backdrop.addEventListener('click', close);
                closeBtn?.addEventListener('click', close);
            })();
        </script>
    @endif
</body>

</html>

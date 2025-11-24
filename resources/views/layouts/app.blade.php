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
</head>

<body class="font-sans bg-[#f6f9ff] antialiased">
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

        <main class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8 mt-6 pb-24 md:pb-6">
            @auth
                                    <div class="md:grid md:grid-cols-[15rem_1fr] md:gap-6">                    @include('layouts.sidebar')
                    <div>
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

        {{-- Mobile Bottom Navigation --}}
        <nav class="fixed bottom-0 left-0 right-0 z-40 bg-white/75 backdrop-blur-sm border-t border-gray-200 shadow-[0_-1px_3px_rgba(0,0,0,0.05)] md:hidden">
            <div class="relative flex items-center justify-around max-w-7xl mx-auto text-xs">
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
                        <div class="w-full"></div>
                    @else
                        <a href="{{ route($item['route']) }}" 
                           class="flex flex-col items-center justify-center w-full pt-2 pb-1.5 transition-colors duration-200 {{ request()->routeIs($item['route'].'*') ? 'text-[#1b3985]' : 'text-gray-500 hover:text-[#1b3985]' }}">
                            <div class="relative">
                                <x-dynamic-component :component="$item['icon']" class="w-6 h-6" />
                                @if (request()->routeIs($item['route'].'*'))
                                    <span class="absolute -top-1 -right-1 block h-1.5 w-1.5 rounded-full bg-[#1b3985]"></span>
                                @endif
                            </div>
                            <span class="mt-1">{{ $item['label'] }}</span>
                        </a>
                    @endif
                @endforeach
            </div>

            <a href="{{ route('student.portfolios.create') }}" aria-label="Tambah Portfolio"
               class="absolute left-1/2 top-0 flex h-14 w-14 -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full bg-gradient-to-br from-[#fa7516] to-[#e5670c] text-white shadow-lg transition-transform hover:scale-110">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
            </a>
        </nav>

        {{-- Tombol Chatbot --}}
        <button id="chatbot-toggle" aria-label="Kontak admin"
            class="fixed bottom-20 right-6 z-50 flex h-14 w-14 items-center justify-center rounded-full bg-[#F97316] text-white shadow-lg transition-transform hover:scale-110 md:bottom-6">
            {{-- DIUBAH: Menggunakan ikon chat --}}
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
        </button>
        <div id="chatbot-panel" class="fixed bottom-[140px] right-6 z-50 hidden w-80 max-w-[92vw] rounded-xl border border-gray-200 bg-white text-gray-800 shadow-2xl md:bottom-24">
            <div class="relative p-4">
                <div class="font-semibold text-[#0A2E73]">Kontak Admin SKPI</div>
                <div class="mt-2 space-y-1 text-sm">
                    <div>Admin: <a href="tel:081234567890" class="text-[#F97316] hover:underline">0812-3456-7890</a></div>
                    <div>Helpdesk: <a href="mailto:helpdesk.ft@unib.ac.id" class="text-[#F97316] hover:underline">helpdesk.ft@unib.ac.id</a></div>
                </div>
                <div class="mt-3 flex gap-2">
                    <button data-copy="081234567890" class="copy-btn rounded-lg bg-gray-100 px-3 py-1.5 text-sm text-gray-800 hover:bg-gray-200">Salin No</button>
                    <a href="mailto:helpdesk.ft@unib.ac.id" class="rounded-lg bg-[#F97316] px-3 py-1.5 text-sm text-white hover:bg-[#FF7C1F]">Kirim Email</a>
                </div>
                <button id="chatbot-close" class="absolute right-2 top-2 text-gray-500 hover:text-gray-800" aria-label="Tutup">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        </div>

        {{-- Script untuk Chatbot Panel --}}
        <script>
            (function() {
                const toggle = document.getElementById('chatbot-toggle');
                const panel = document.getElementById('chatbot-panel');
                const closeBtn = document.getElementById('chatbot-close');
                if (!toggle || !panel || !closeBtn) return;
                const show = () => panel.classList.remove('hidden');
                const hide = () => panel.classList.add('hidden');
                toggle.addEventListener('click', () => panel.classList.contains('hidden') ? show() : hide());
                closeBtn.addEventListener('click', hide);
                panel.addEventListener('click', (e) => {
                    const btn = e.target.closest('.copy-btn');
                    if (btn && navigator.clipboard) {
                        navigator.clipboard.writeText(btn.getAttribute('data-copy'));
                        btn.textContent = 'Disalin!';
                        setTimeout(() => { btn.textContent = 'Salin No'; }, 1500);
                    }
                });
            })();
        </script>
    @endif
    {{-- ====================================================================== --}}
    {{-- END BAGIAN UNTUK MAHASISWA --}}
    {{-- ====================================================================== --}}


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

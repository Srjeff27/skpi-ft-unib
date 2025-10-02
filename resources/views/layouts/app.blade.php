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
    <div class="min-h-screen">
        @include('layouts.navigation')

        {{-- Admin mobile sidebar (offcanvas) --}}
        @if (auth()->check() && request()->routeIs('admin.*'))
            @include('layouts.admin-mobile-sidebar')
        @endif

        @isset($header)
            <header class="bg-white shadow">
                <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8 py-6">
                    {{ $header }}
                </div>
            </header>
        @endisset

        {{-- DIUBAH: Padding bawah ditambahkan untuk memberi ruang bagi navigasi mobile --}}
        <main class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8 mt-6 pb-24 md:pb-6">
            <div class="md:grid md:grid-cols-[14rem_1fr] md:gap-6">
                @include('layouts.sidebar')
                <div>
                    {{ $slot }}
                </div>
            </div>
        </main>
    </div>

    {{-- ====================================================================== --}}
    {{-- BAGIAN UNTUK MAHASISWA --}}
    {{-- ====================================================================== --}}
    @if (auth()->check() && auth()->user()->role === 'mahasiswa')

        {{-- Mobile Bottom Navigation --}}
        <nav class="fixed bottom-0 left-0 right-0 z-40 bg-white border-t border-gray-200 shadow-[0_-1px_3px_rgba(0,0,0,0.05)] md:hidden">
            <div class="relative flex items-center justify-around max-w-7xl mx-auto text-xs">

                {{-- Tombol 1: Dashboard --}}
                <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center w-full py-2 transition-colors duration-200 {{ request()->routeIs('dashboard') ? 'text-[#1b3985]' : 'text-gray-500 hover:text-[#1b3985]' }}">
                    @if (request()->routeIs('dashboard'))
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.061l8.69-8.69Z" /><path d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" /></svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h7.5" /></svg>
                    @endif
                    <span>Dashboard</span>
                </a>

                {{-- Tombol 2: Portfolio --}}
                <a href="{{ route('student.portfolios.index') }}" class="flex flex-col items-center justify-center w-full py-2 transition-colors duration-200 {{ request()->routeIs('student.portfolios.*') ? 'text-[#1b3985]' : 'text-gray-500 hover:text-[#1b3985]' }}">
                    @if (request()->routeIs('student.portfolios.*'))
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path fill-rule="evenodd" d="M3.75 4.5a.75.75 0 0 1 .75-.75h15a.75.75 0 0 1 .75.75v15a.75.75 0 0 1-.75.75h-15a.75.75 0 0 1-.75-.75V4.5Zm.75 3.75a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-.75.75h-4.5a.75.75 0 0 1-.75-.75v-4.5Zm5.25.75a.75.75 0 0 0 0-1.5h6a.75.75 0 0 0 0 1.5h-6Zm0 3a.75.75 0 0 0 0-1.5h6a.75.75 0 0 0 0 1.5h-6Zm0 3a.75.75 0 0 0 0-1.5h6a.75.75 0 0 0 0 1.5h-6Z" clip-rule="evenodd" /></svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
                    @endif
                    <span>Portfolio</span>
                </a>

                {{-- Placeholder untuk Tombol Tengah --}}
                <div class="w-full"></div>

                {{-- Tombol 4: Dokumen --}}
                <a href="{{ route('student.documents.index') }}" class="flex flex-col items-center justify-center w-full py-2 transition-colors duration-200 {{ request()->routeIs('student.documents.*') ? 'text-[#1b3985]' : 'text-gray-500 hover:text-[#1b3985]' }}">
                    @if (request()->routeIs('student.documents.*'))
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path fill-rule="evenodd" d="M5.625 1.5A3.375 3.375 0 0 0 2.25 4.875v14.25A3.375 3.375 0 0 0 5.625 22.5h12.75a3.375 3.375 0 0 0 3.375-3.375V4.875A3.375 3.375 0 0 0 18.375 1.5H5.625ZM7.5 10.5a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5a.75.75 0 0 1-.75-.75Zm.75 2.25a.75.75 0 0 0 0 1.5h4.5a.75.75 0 0 0 0-1.5h-4.5Z" clip-rule="evenodd" /></svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0-3h-1.5A2.25 2.25 0 0 0 4.5 5.25v13.5A2.25 2.25 0 0 0 6.75 21h10.5A2.25 2.25 0 0 0 19.5 18.75V10.5a2.25 2.25 0 0 0-2.25-2.25h-4.5M7.5 11.25h3v3h-3v-3Z" /></svg>
                    @endif
                    <span>Dokumen</span>
                </a>

                {{-- Tombol 5: Profil --}}
                <a href="{{ route('profile.edit') }}" class="flex flex-col items-center justify-center w-full py-2 transition-colors duration-200 {{ request()->routeIs('profile.*') ? 'text-[#1b3985]' : 'text-gray-500 hover:text-[#1b3985]' }}">
                    @if (request()->routeIs('profile.*'))
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" clip-rule="evenodd" /></svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                    @endif
                    <span>Profil</span>
                </a>
            </div>

            {{-- Tombol Aksi Utama (FAB) --}}
            <a href="{{ route('student.portfolios.create') }}" aria-label="Tambah Portfolio"
               class="absolute left-1/2 top-0 flex h-14 w-14 -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full bg-[#F97316] text-white shadow-lg transition-transform hover:scale-110">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-7 w-7"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
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

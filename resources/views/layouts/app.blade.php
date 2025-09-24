<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('SKPI - FT UNIB') }}</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo-ft.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-ft.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-[#f6f9ff]">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
            <div class="md:grid md:grid-cols-[14rem_1fr] md:gap-6">
                @include('layouts.sidebar')
                <div>
                    {{ $slot }}
                </div>
            </div>
        </main>
    </div>

    <nav
        class="md:hidden fixed bottom-0 left-0 right-0 z-40 bg-white border-t border-gray-200 shadow-[0_-1px_3px_rgba(0,0,0,0.05)]">
        {{-- DIUBAH: Menjadi 5 kolom untuk memberi ruang pada tombol tengah --}}
        <div class="max-w-7xl mx-auto grid grid-cols-5 text-xs">

            <a href="{{ route('dashboard') }}"
                class="flex flex-col items-center justify-center py-2 transition-colors duration-200 {{ request()->routeIs('dashboard') ? 'text-[#1b3985]' : 'text-gray-500 hover:text-[#1b3985]' }}">
                @if (request()->routeIs('dashboard'))
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path
                            d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.061l8.69-8.69Z" />
                        <path
                            d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h7.5" />
                    </svg>
                @endif
                <span>Dashboard</span>
            </a>

            <a href="{{ route('profile.edit') }}"
                class="flex flex-col items-center justify-center py-2 transition-colors duration-200 {{ request()->routeIs('profile.*') ? 'text-[#1b3985]' : 'text-gray-500 hover:text-[#1b3985]' }}">
                @if (request()->routeIs('profile.*'))
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd"
                            d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"
                            clip-rule="evenodd" />
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                @endif
                <span>Profil</span>
            </a>

            <span></span>

            <a href="{{ route('student.portfolios.index') }}"
                class="flex flex-col items-center justify-center py-2 transition-colors duration-200 {{ request()->routeIs('student.portfolios.*') ? 'text-[#1b3985]' : 'text-gray-500 hover:text-[#1b3985]' }}">
                @if (request()->routeIs('student.portfolios.*'))
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path d="M5.625 3.75a2.625 2.625 0 1 0 0 5.25h12.75a2.625 2.625 0 1 0 0-5.25H5.625Z" />
                        <path fill-rule="evenodd"
                            d="M3.75 9.75A.75.75 0 0 1 4.5 9h15a.75.75 0 0 1 .75.75v8.25a.75.75 0 0 1-.75.75h-15a.75.75 0 0 1-.75-.75V9.75Zm1.5.75a.75.75 0 0 1 .75-.75h1.5a.75.75 0 0 1 .75.75v1.5a.75.75 0 0 1-.75.75h-1.5a.75.75 0 0 1-.75-.75v-1.5Zm4.125-.75a.75.75 0 0 1 .75.75v5.25a.75.75 0 0 1-1.5 0v-5.25a.75.75 0 0 1 .75-.75Zm3.375 0a.75.75 0 0 1 .75.75v5.25a.75.75 0 0 1-1.5 0v-5.25a.75.75 0 0 1 .75-.75Z"
                            clip-rule="evenodd" />
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                    </svg>
                @endif
                <span>Portfolio</span>
            </a>

            <a href="{{ route('student.documents.index') }}"
                class="flex flex-col items-center justify-center py-2 transition-colors duration-200 {{ request()->routeIs('student.documents.*') ? 'text-[#1b3985]' : 'text-gray-500 hover:text-[#1b3985]' }}">
                @if (request()->routeIs('student.documents.*'))
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd"
                            d="M5.625 1.5A3.375 3.375 0 0 0 2.25 4.875v14.25A3.375 3.375 0 0 0 5.625 22.5h12.75a3.375 3.375 0 0 0 3.375-3.375V4.875A3.375 3.375 0 0 0 18.375 1.5H5.625ZM7.5 10.5a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5a.75.75 0 0 1-.75-.75Zm.75 2.25a.75.75 0 0 0 0 1.5h4.5a.75.75 0 0 0 0-1.5h-4.5Z"
                            clip-rule="evenodd" />
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                @endif
                <span>Dokumen</span>
            </a>

        </div>
    </nav>


    <button id="chatbot-toggle" aria-label="Kontak admin"
        class="fixed bottom-6 right-6 z-50 rounded-full bg-[#F97316] hover:bg-[#FF7C1F] text-white shadow-lg w-14 h-14 flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor">
            <path
                d="M2.25 6.75A2.25 2.25 0 0 1 4.5 4.5h3A2.25 2.25 0 0 1 9.75 6.75v1.5a2.25 2.25 0 0 1-2.25 2.25h-.257a12.04 12.04 0 0 0 5.257 5.257V15a2.25 2.25 0 0 1 2.25-2.25h1.5A2.25 2.25 0 0 1 20.25 15v3a2.25 2.25 0 0 1-2.25 2.25h-.75C9.708 20.25 3.75 14.292 3.75 6.75Z" />
        </svg>
    </button>

    <div id="chatbot-panel"
        class="fixed bottom-24 right-6 z-50 w-80 max-w-[92vw] bg-white text-gray-800 rounded-xl shadow-2xl border border-gray-200 hidden">
        <div class="px-4 py-4">
            <div class="font-semibold text-[#0A2E73]">Kontak Admin SKPI</div>
            <div class="mt-2 text-sm space-y-1">
                <div>Admin: <a href="tel:081234567890" class="text-[#F97316]">0812-3456-7890</a></div>
                <div>Helpdesk: <a href="mailto:helpdesk.ft@unib.ac.id"
                        class="text-[#F97316]">helpdesk.ft@unib.ac.id</a>
                </div>
            </div>
            <div class="mt-3 flex gap-2">
                <button data-copy="081234567890"
                    class="copy-btn bg-gray-100 hover:bg-gray-200 text-gray-800 px-3 py-1.5 rounded-lg text-sm">Salin
                    No</button>
                <a href="mailto:helpdesk.ft@unib.ac.id"
                    class="bg-[#F97316] hover:bg-[#FF7C1F] text-white px-3 py-1.5 rounded-lg text-sm">Kirim Email</a>
            </div>

            <button id="chatbot-close" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700"
                aria-label="Tutup">×</button>
        </div>
    </div>

    <script>
        (function() {


            const toggle = document.getElementById('chatbot-toggle');
            const panel = document.getElementById('chatbot-panel');
            const closeBtn = document.getElementById('chatbot-close');

            function show() {
                panel.classList.remove('hidden');
            }

            function hide() {
                panel.classList.add('hidden');
            }
            toggle.addEventListener('click', () => panel.classList.contains('hidden') ? show() : hide());
            closeBtn?.addEventListener('click', hide);
            panel.addEventListener('click', (e) => {
                const btn = e.target.closest('.copy-btn');
                if (btn) {
                    navigator.clipboard?.writeText(btn.getAttribute('data-copy'));
                    btn.textContent = 'Disalin';
                    setTimeout(() => btn.textContent = 'Salin No', 1200);
                }
            });
        })();
    </script>
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
</body>

</html>

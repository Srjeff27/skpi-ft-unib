<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SKPI - FT UNIB</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo-ft.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-ft.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased min-h-screen"
    style="background-image: linear-gradient(rgba(4, 26, 82, 0.7), rgba(5, 17, 47, 0.7)), url('{{ asset('images/background-ft.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full sm:max-w-md px-6 py-6 bg-white shadow-xl border border-gray-200 rounded-2xl">
            {{ $slot }}
        </div>
    </div>
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
                <div>Helpdesk: <a href="mailto:helpdesk.ft@unib.ac.id" class="text-[#F97316]">helpdesk.ft@unib.ac.id</a>
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
</body>

</html>

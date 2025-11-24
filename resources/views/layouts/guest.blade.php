<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SKPI - FT UNIB</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo-ft.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-ft.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">

    <div class="min-h-screen flex">
        <!-- Image Column -->
        <div class="hidden lg:block relative lg:w-1/2 xl:w-2/3 min-h-screen bg-cover bg-center"
            style="background-image: url('{{ asset('images/background-ft.jpg') }}')">
            <div class="absolute inset-0 w-full h-full bg-blue-900 bg-opacity-60"></div>
            <div class="absolute top-0 left-0 w-full p-8">
                <a href="/" class="inline-flex items-center gap-3 text-white">
                    <img src="{{ asset('images/logo-ft.png') }}" alt="Logo FT UNIB" class="h-10 w-10">
                    <span class="font-semibold text-xl">Fakultas Teknik UNIB</span>
                </a>
            </div>
        </div>

        <!-- Form Column -->
        <div class="w-full lg:w-1/2 xl:w-1/3 flex flex-col justify-center items-center p-6 sm:p-12 bg-white">
            <div class="w-full max-w-md">
                {{ $slot }}
            </div>
        </div>
    </div>

    <!-- Chatbot -->
    <button id="chatbot-toggle" aria-label="Kontak admin"
        class="fixed bottom-6 right-6 z-50 flex h-14 w-14 items-center justify-center rounded-full bg-[#F97B16] text-white shadow-lg transition-transform hover:scale-110 hover:bg-[#E8630B]">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="w-7 h-7">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
    </button>

    <div id="chatbot-panel"
        class="fixed bottom-24 right-6 z-50 hidden w-80 max-w-[92vw] rounded-xl border border-gray-200 bg-white text-gray-800 shadow-2xl">
        <div class="relative p-4">
            <div class="font-semibold text-[#0A2E73]">Kontak Admin SKPI</div>
            <div class="mt-2 space-y-1 text-sm">
                <div>Admin: <a href="tel:081234567890" class="text-[#F97316] hover:underline">0812-3456-7890</a></div>
                <div>Helpdesk: <a href="mailto:helpdesk.ft@unib.ac.id"
                        class="text-[#F97316] hover:underline">helpdesk.ft@unib.ac.id</a></div>
            </div>
            <div class="mt-3 flex gap-2">
                <button data-copy="081234567890"
                    class="copy-btn rounded-lg bg-gray-100 px-3 py-1.5 text-sm text-gray-800 hover:bg-gray-200">Salin
                    No</button>
                <a href="mailto:helpdesk.ft@unib.ac.id"
                    class="rounded-lg bg-[#F97316] px-3 py-1.5 text-sm text-white hover:bg-[#FF7C1F]">Kirim Email</a>
            </div>

            <button id="chatbot-close" class="absolute right-2 top-2 text-gray-500 hover:text-gray-800"
                aria-label="Tutup">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

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
                    const originalText = btn.textContent;
                    btn.textContent = 'Disalin!';
                    setTimeout(() => {
                        btn.textContent = originalText;
                    }, 1500);
                }
            });
        })();
    </script>
</body>

</html>

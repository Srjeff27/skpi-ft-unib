<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('SKPI - FT UNIB') }}</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logo-ft.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo-ft.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-ft.png') }}">
    @vite('resources/css/app.css')
    <style>
        /* Menambahkan animasi untuk panel chat */
        #chatbot-panel.active {
            opacity: 1;
            transform: translateY(0);
            visibility: visible;
        }

        #chatbot-panel {
            opacity: 0;
            transform: translateY(1rem);
            visibility: hidden;
            transition: opacity 0.3s ease, transform 0.3s ease, visibility 0.3s ease;
        }
    </style>
</head>

<body class="text-gray-900 bg-gray-50 font-sans">

    <header class="bg-white/90 backdrop-blur sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-3">
            <a href="#beranda" class="flex items-center gap-3">
                <img src="{{ asset('images/logo-ft.png') }}" alt="Logo FT UNIB" class="w-9 h-9">
                <span class="font-semibold text-[#0A2E73]">Fakultas Teknik UNIB</span>
            </a>
            <nav class="hidden md:flex items-center gap-6 text-sm font-medium">
                <a href="#tentang" class="text-gray-700 hover:text-[#F97316] transition">Tentang</a>
                <a href="#fitur" class="text-gray-700 hover:text-[#F97316] transition">Fitur</a>
                <a href="#panduan" class="text-gray-700 hover:text-[#F97316] transition">Panduan</a>
                @guest
                    <a href="{{ route('login') }}"
                        class="bg-[#F97316] text-white px-6 py-2 rounded-full hover:bg-[#FF7C1F] shadow transition">Login</a>
                @else
                    <a href="{{ route('dashboard') }}"
                        class="bg-[#F97316] text-white px-6 py-2 rounded-full hover:bg-[#FF7C1F] shadow transition">Dashboard</a>
                @endguest
            </nav>
            <details class="md:hidden relative">
                <summary
                    class="list-none cursor-pointer px-3 py-2 rounded-lg border text-sm font-medium text-[#0A2E73]">Menu
                </summary>
                <div
                    class="absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-lg p-3 flex flex-col gap-2 text-sm z-50">
                    <a href="#tentang" class="py-1 hover:text-[#F97316]">Tentang</a>
                    <a href="#fitur" class="py-1 hover:text-[#F97316]">Fitur</a>
                    <a href="#panduan" class="py-1 hover:text-[#F97316]">Panduan</a>
                    @guest
                        <a href="{{ route('login') }}"
                            class="mt-1 bg-[#F97316] text-white px-4 py-2 rounded-lg text-center hover:bg-[#FF7C1F]">Login</a>
                    @else
                        <a href="{{ route('dashboard') }}"
                            class="mt-1 bg-[#F97316] text-white px-4 py-2 rounded-lg text-center hover:bg-[#FF7C1F]">Dashboard</a>
                    @endguest
                </div>
            </details>
        </div>
    </header>

    <main>
        <section id="beranda"
            class="relative overflow-hidden scroll-mt-24 bg-gradient-to-br from-[#0A2E73] via-[#1E3A8A] to-[#0F172A]">
            <div class="max-w-7xl mx-auto px-6 py-20 md:py-28 grid md:grid-cols-2 gap-10 items-center">
                <div>
                    <h1 class="text-4xl md:text-6xl font-bold text-white leading-tight">
                        Sistem Informasi<br>Surat Keterangan Pendamping Ijazah
                        <span class="text-[#F97316]">(SKPI)</span>
                    </h1>
                    <p class="mt-6 text-white/90 text-lg">Mencatat, memverifikasi, dan menerbitkan SKPI secara digital
                        untuk mendukung mahasiswa unggul dan berdaya saing.</p>
                    <div class="mt-8 flex gap-4">
                        @guest
                            <a href="{{ route('login') }}"
                                class="px-8 py-3 bg-[#F97316] text-white rounded-lg font-semibold hover:bg-[#FF7C1F] shadow-lg transition">Mulai
                                Sekarang</a>
                        @else
                            <a href="{{ route('dashboard') }}"
                                class="px-8 py-3 bg-[#F97316] text-white rounded-lg font-semibold hover:bg-[#FF7C1F] shadow-lg transition">Buka
                                Dashboard</a>
                        @endguest
                        <a href="#tentang"
                            class="px-8 py-3 border border-white/30 text-white rounded-lg font-semibold hover:bg-white/10 transition">Pelajari</a>
                    </div>
                </div>
                <div class="relative hidden md:block">
                    <img src="{{ asset('images/background-ft.jpg') }}" alt="Gedung FT UNIB"
                        class="rounded-2xl shadow-2xl ring-1 ring-black/10 w-full max-w-md mx-auto">
                    <div class="absolute -bottom-6 -left-6 bg-white rounded-lg shadow p-4 max-w-[180px]">
                        <div class="font-semibold text-[#0A2E73] leading-snug">Upload Portofolio</div>
                        <p class="text-xs text-gray-600 leading-relaxed">Prestasi, Pelatihan, Organisasi</p>
                    </div>
                    <div class="absolute -top-6 -right-6 bg-white rounded-lg shadow p-4 w-40">
                        <div class="font-semibold text-[#0A2E73]">Verifikasi Data</div>
                        <p class="text-xs text-gray-600">Valid / Invalid</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="tentang" class="py-16 bg-white scroll-mt-24">
            <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-10 items-center">
                <div>
                    <h2 class="text-3xl font-bold text-[#1E3A8A] mb-4">Apa itu SKPI?</h2>
                    <p class="text-gray-600 leading-relaxed mb-3">SKPI adalah dokumen resmi yang memuat rekam jejak
                        kemampuan, pengetahuan, dan sikap mahasiswa selama perkuliahan, baik di bidang akademik maupun
                        non-akademik.</p>
                    <p class="text-gray-600 leading-relaxed">Sistem ini membantu mahasiswa Fakultas Teknik Universitas
                        Bengkulu untuk mengelola portofolio mereka secara digital hingga proses penerbitan SKPI resmi
                        saat wisuda.</p>
                </div>
                <div class="flex gap-3">
                    <div class="flex-1 bg-[#FF7C1F]/10 text-center p-4 rounded-lg">
                        <div class="text-[#F97316] font-semibold">Sertifikat</div>
                    </div>
                    <div class="flex-1 bg-[#FF7C1F]/10 text-center p-4 rounded-lg">
                        <div class="text-[#F97316] font-semibold">Prestasi</div>
                    </div>
                    <div class="flex-1 bg-[#FF7C1F]/10 text-center p-4 rounded-lg">
                        <div class="text-[#F97316] font-semibold">Organisasi</div>
                    </div>
                </div>
            </div>
        </section>

        <section id="fitur" class="py-16 bg-gray-50 scroll-mt-24">
            <div class="max-w-6xl mx-auto px-6">
                <h2 class="text-center text-3xl font-bold text-[#1E3A8A] mb-10">Fitur Utama</h2>
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition">
                        <h3 class="text-lg font-semibold text-[#1E3A8A] mb-2">Upload Portofolio</h3>
                        <p class="text-gray-600 text-sm">Mahasiswa dapat dengan mudah mengunggah bukti prestasi,
                            keikutsertaan organisasi, pelatihan, dan sertifikat.</p>
                    </div>
                    <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition">
                        <h3 class="text-lg font-semibold text-[#1E3A8A] mb-2">Verifikasi Online</h3>
                        <p class="text-gray-600 text-sm">Tim verifikator memeriksa setiap dokumen yang diunggah dan
                            memberikan status validasi secara transparan.</p>
                    </div>
                    <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition">
                        <h3 class="text-lg font-semibold text-[#1E3A8A] mb-2">Penerbitan Otomatis</h3>
                        <p class="text-gray-600 text-sm">Sistem secara otomatis merekap data terverifikasi dan
                            menghasilkan dokumen SKPI yang siap dicetak.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="panduan" class="py-16 bg-white scroll-mt-24">
            <div class="max-w-4xl mx-auto px-6">
                <h2 class="text-center text-3xl font-bold text-[#1E3A8A] mb-10">Panduan & Informasi</h2>

                <div class="mb-12">
                    <h3 class="text-xl font-bold mb-6 text-center text-gray-800">Alur Pengajuan SKPI</h3>
                    <div class="relative">
                        <div class="absolute left-4 top-0 h-full w-0.5 bg-gray-200" aria-hidden="true"></div>
                        <ol class="relative space-y-8">
                            <li class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div
                                        class="flex items-center justify-center h-8 w-8 rounded-full bg-blue-100 ring-8 ring-white">
                                        <span class="font-bold text-blue-600">1</span></div>
                                </div>
                                <div class="ml-6">
                                    <h4 class="font-semibold text-gray-800">Pengajuan Akun</h4>
                                    <p class="mt-1 text-sm text-gray-600">Mahasiswa mengajukan pembuatan akun SKPI
                                        kepada Admin Fakultas.</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div
                                        class="flex items-center justify-center h-8 w-8 rounded-full bg-blue-100 ring-8 ring-white">
                                        <span class="font-bold text-blue-600">2</span></div>
                                </div>
                                <div class="ml-6">
                                    <h4 class="font-semibold text-gray-800">Aktivasi Akun</h4>
                                    <p class="mt-1 text-sm text-gray-600">Admin memverifikasi dan mengaktivasi akun
                                        mahasiswa.</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div
                                        class="flex items-center justify-center h-8 w-8 rounded-full bg-blue-100 ring-8 ring-white">
                                        <span class="font-bold text-blue-600">3</span></div>
                                </div>
                                <div class="ml-6">
                                    <h4 class="font-semibold text-gray-800">Mengisi Portofolio</h4>
                                    <p class="mt-1 text-sm text-gray-600">Mahasiswa login dan mengisi data portofolio
                                        (prestasi, organisasi, dll).</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div
                                        class="flex items-center justify-center h-8 w-8 rounded-full bg-green-100 ring-8 ring-white">
                                        <svg class="h-5 w-5 text-green-600" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg></div>
                                </div>
                                <div class="ml-6">
                                    <h4 class="font-semibold text-gray-800">Penerbitan SKPI</h4>
                                    <p class="mt-1 text-sm text-gray-600">SKPI resmi diterbitkan dan dicetak bersama
                                        ijazah & transkrip nilai.</p>
                                </div>
                            </li>
                        </ol>
                    </div>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-6 text-center text-gray-800">Pertanyaan Umum (FAQ)</h3>
                    <div class="space-y-4 text-left">
                        <details class="group bg-gray-100 rounded-lg shadow-sm p-4 open:shadow-md transition">
                            <summary class="cursor-pointer font-semibold text-[#0A2E73]">Apa Itu SKPI?</summary>
                            <div class="mt-3 text-gray-600 text-sm space-y-2">
                                <p>Surat Keterangan Pendamping Ijazah (SKPI) adalah dokumen resmi yang memuat informasi
                                    tentang pencapaian akademik dan kualifikasi lulusan, termasuk prestasi,
                                    keterampilan, dan pengalaman selama menjadi mahasiswa.</p>
                            </div>
                        </details>
                        <details class="group bg-gray-100 rounded-lg shadow-sm p-4 open:shadow-md transition">
                            <summary class="cursor-pointer font-semibold text-[#0A2E73]">Apa Tujuan & Manfaat SKPI?
                            </summary>
                            <div class="mt-3 text-gray-600 text-sm space-y-2">
                                <p>Tujuan utamanya adalah memberikan penjelasan yang objektif mengenai kompetensi
                                    seorang lulusan. Manfaatnya antara lain:</p>
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Meningkatkan kelayakan kerja (*employability*) di mata perusahaan.</li>
                                    <li>Menjadi dokumen pendukung untuk melanjutkan studi ke jenjang yang lebih tinggi.
                                    </li>
                                    <li>Memberikan gambaran lengkap tentang profil alumni yang kompeten dan berdaya
                                        saing.</li>
                                </ul>
                            </div>
                        </details>
                        <details class="group bg-gray-100 rounded-lg shadow-sm p-4 open:shadow-md transition">
                            <summary class="cursor-pointer font-semibold text-[#0A2E73]">Bagaimana Cara Mengisinya?
                            </summary>
                            <p class="mt-3 text-gray-600 text-sm">Mahasiswa dapat login ke sistem melalui laman ini.
                                Pengisian data capaian dan kegiatan dilakukan sejak semester pertama dengan mengunggah
                                dokumen bukti yang sah.</p>
                        </details>
                    </div>
                </div>

            </div>
        </section>
    </main>

    <footer class="bg-[#0A2E73] text-white">
        <div class="max-w-6xl mx-auto px-6 py-8 grid md:grid-cols-2 gap-6">
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <img src="{{ asset('images/logo-ft.png') }}" class="w-8 h-8" alt="Logo FT">
                    <span class="font-semibold">Fakultas Teknik UNIB</span>
                </div>
                <p class="text-sm text-white/80">© {{ date('Y') }} Fakultas Teknik, Universitas Bengkulu</p>
            </div>
            <div class="text-sm">
                <div class="font-medium mb-1">Kontak</div>
                <p>Jl. W.R. Supratman, Kandang Limun, Kota Bengkulu</p>
                <p>Email: ft@unib.ac.id | Telp: (0736) 000000</p>
            </div>
        </div>
    </footer>

    <button id="chatbot-toggle" aria-label="Kontak admin"
        class="fixed bottom-6 right-6 z-50 rounded-full bg-[#F97316] hover:bg-[#FF7C1F] text-white shadow-lg w-14 h-14 flex items-center justify-center transition-transform hover:scale-110">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor">
            <path
                d="M2.25 6.75A2.25 2.25 0 0 1 4.5 4.5h3A2.25 2.25 0 0 1 9.75 6.75v1.5a2.25 2.25 0 0 1-2.25 2.25h-.257a12.04 12.04 0 0 0 5.257 5.257V15a2.25 2.25 0 0 1 2.25-2.25h1.5A2.25 2.25 0 0 1 20.25 15v3a2.25 2.25 0 0 1-2.25 2.25h-.75C9.708 20.25 3.75 14.292 3.75 6.75Z" />
        </svg>
    </button>

    <div id="chatbot-panel"
        class="fixed bottom-24 right-6 z-50 w-80 max-w-[92vw] bg-white text-gray-800 rounded-xl shadow-2xl border border-gray-200">
        <div class="px-4 py-4">
            <div class="font-semibold text-[#0A2E73]">Kontak Admin SKPI</div>
            <div class="mt-2 text-sm space-y-1">
                <div>Admin: <a href="tel:081234567890" class="text-[#F97316] hover:underline">0812-3456-7890</a></div>
                <div>Helpdesk: <a href="mailto:helpdesk.ft@unib.ac.id"
                        class="text-[#F97316] hover:underline">helpdesk.ft@unib.ac.id</a></div>
            </div>
            <div class="mt-3 flex gap-2">
                <button data-copy="081234567890"
                    class="copy-btn bg-gray-100 hover:bg-gray-200 text-gray-800 px-3 py-1.5 rounded-lg text-sm">Salin
                    No</button>
                <a href="mailto:helpdesk.ft@unib.ac.id"
                    class="bg-[#F97316] hover:bg-[#FF7C1F] text-white px-3 py-1.5 rounded-lg text-sm">Kirim Email</a>
            </div>
            <button id="chatbot-close" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700"
                aria-label="Tutup">&times;</button>
        </div>
    </div>

    <script>
        (function() {
            const toggle = document.getElementById('chatbot-toggle');
            const panel = document.getElementById('chatbot-panel');
            const closeBtn = document.getElementById('chatbot-close');

            function show() {
                panel.classList.add('active');
            }

            function hide() {
                panel.classList.remove('active');
            }

            toggle.addEventListener('click', (e) => {
                e.stopPropagation();
                panel.classList.contains('active') ? hide() : show();
            });

            closeBtn?.addEventListener('click', hide);

            // BARU: Logika untuk menutup panel saat klik di luar
            document.addEventListener('click', (e) => {
                if (!panel.contains(e.target) && !toggle.contains(e.target)) {
                    hide();
                }
            });

            // Logika tombol salin
            panel.addEventListener('click', (e) => {
                const btn = e.target.closest('.copy-btn');
                if (btn) {
                    navigator.clipboard?.writeText(btn.getAttribute('data-copy'));
                    btn.textContent = 'Disalin!';
                    setTimeout(() => btn.textContent = 'Salin No', 1500);
                }
            });
        })();
    </script>
</body>

</html>

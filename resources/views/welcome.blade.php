<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SKPI Fakultas Teknik UNIB</title>
    @vite('resources/css/app.css')
</head>
<body class="text-gray-900 bg-gradient-to-br from-[#0A2E73] via-[#1E3A8A] to-[#0F172A] font-sans">

    <!-- Navbar -->
    <header class="bg-white/90 backdrop-blur sticky top-0 z-50 shadow">
        <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-3">
            <a href="#beranda" class="flex items-center gap-3">
                <img src="{{ asset('images/logo-ft.png') }}" alt="Logo FT UNIB" class="w-9 h-9">
                <span class="font-semibold text-[#0A2E73]">Fakultas Teknik UNIB</span>
            </a>
            <nav class="hidden md:flex items-center gap-6 text-sm font-medium">
                <a href="#tentang" class="hover:text-[#F97316] transition">Tentang</a>
                <a href="#fitur" class="hover:text-[#F97316] transition">Fitur</a>
                <a href="#panduan" class="hover:text-[#F97316] transition">Panduan</a>
                @guest
                    <a href="{{ route('login') }}" class="bg-[#F97316] text-white px-6 py-2 rounded-full hover:bg-[#FF7C1F] shadow transition">Login</a>
                @else
                    <a href="{{ route('dashboard') }}" class="bg-[#F97316] text-white px-6 py-2 rounded-full hover:bg-[#FF7C1F] shadow transition">Dashboard</a>
                @endguest
                
            </nav>
            <details class="md:hidden">
                <summary class="list-none cursor-pointer px-3 py-2 rounded-lg border text-sm font-medium text-[#0A2E73]">Menu</summary>
                <div class="mt-2 bg-white rounded-lg shadow p-3 flex flex-col gap-2 text-sm">
                    <a href="#tentang" class="py-1 hover:text-[#F97316]">Tentang</a>
                    <a href="#fitur" class="py-1 hover:text-[#F97316]">Fitur</a>
                    <a href="#panduan" class="py-1 hover:text-[#F97316]">Panduan</a>
                    @guest
                        <a href="{{ route('login') }}" class="mt-1 bg-[#F97316] text-white px-4 py-2 rounded-lg text-center hover:bg-[#FF7C1F]">Login</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="mt-1 bg-[#F97316] text-white px-4 py-2 rounded-lg text-center hover:bg-[#FF7C1F]">Dashboard</a>
                    @endguest
                    
                </div>
            </details>
        </div>
    </header>

<!-- Hero -->
<section id="beranda" class="relative overflow-hidden scroll-mt-24 md:scroll-mt-28">
    <div class="max-w-7xl mx-auto px-6 py-20 md:py-28 grid md:grid-cols-2 gap-10 items-center">
        <div>
            <h1 class="text-4xl md:text-6xl font-bold text-white leading-tight">
                Sistem Informasi<br>Surat Keterangan Pendamping Ijazah
                <span class="text-[#F97316]">(SKPI)</span>
            </h1>
            <p class="mt-6 text-white/90 text-lg">Mencatat, memverifikasi, dan menerbitkan Surat Keterangan Pendamping Ijazah secara digital untuk mendukung mahasiswa unggul dan berdaya saing.</p>
            <div class="mt-8 flex gap-4">
                @guest
                    <a href="{{ route('login') }}" class="px-8 py-3 bg-[#F97316] text-white rounded-lg font-semibold hover:bg-[#FF7C1F] shadow-lg transition">Login</a>
                @else
                    <a href="{{ route('dashboard') }}" class="px-8 py-3 bg-[#F97316] text-white rounded-lg font-semibold hover:bg-[#FF7C1F] shadow-lg transition">Dashboard</a>
                @endguest
                <a href="#tentang" class="px-8 py-3 border border-white/30 text-white rounded-lg hover:bg-white/10 transition">Pelajari</a>
            </div>
        </div>
        <div class="relative">
            <img src="{{ asset('images/background-ft.jpg') }}" alt="Gedung FT UNIB" class="rounded-2xl shadow-2xl ring-1 ring-black/10 w-full max-w-md mx-auto">
            <!-- Bubble Info -->
            <div class="hidden sm:block absolute -bottom-6 -left-6 bg-white rounded-lg shadow p-4 max-w-[180px]">
                <div class="font-semibold text-[#0A2E73] leading-snug">Upload Portofolio</div>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Prestasi, Pelatihan, Organisasi
                </p>
            </div>
            <div class="hidden sm:block absolute -top-6 -right-6 bg-white rounded-lg shadow p-4 w-40">
                <div class="font-semibold text-[#0A2E73]">Verifikasi</div>
                <p class="text-xs text-gray-600">Valid / Invalid / Reject</p>
            </div>
        </div>
    </div>
    <!-- Wave Ornament -->
    <svg class="absolute bottom-0 left-0 w-full h-16 text-white" viewBox="0 0 1440 320" fill="currentColor">
        <path fill-opacity="1" d="M0,256L1440,96L1440,320L0,320Z"></path>
    </svg>
</section>


    <!-- Tentang SKPI -->
    <section id="tentang" class="py-16 bg-white scroll-mt-24 md:scroll-mt-28">
        <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-10 items-center">
            <div>
                <h2 class="text-3xl font-bold text-[#1E3A8A] mb-4">Tentang SKPI</h2>
                <p class="text-gray-600 leading-relaxed mb-3">SKPI adalah dokumen resmi yang memuat rekam jejak akademik dan non-akademik mahasiswa.</p>
                <p class="text-gray-600 leading-relaxed">Sistem ini membantu mahasiswa Fakultas Teknik Universitas Bengkulu mengelola portofolio hingga proses penerbitan SKPI saat wisuda.</p>
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

    <!-- Fitur -->
    <section id="fitur" class="py-16 bg-gray-50 scroll-mt-24 md:scroll-mt-28">
        <div class="max-w-6xl mx-auto px-6">
            <h3 class="text-center text-3xl font-bold text-[#1E3A8A] mb-10">Fitur Utama</h3>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition">
                    <h4 class="text-lg font-semibold text-[#1E3A8A] mb-2">Upload Portofolio</h4>
                    <p class="text-gray-600 text-sm">Mahasiswa mengunggah prestasi, organisasi, pelatihan, dan sertifikat.</p>
                </div>
                <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition">
                    <h4 class="text-lg font-semibold text-[#1E3A8A] mb-2">Verifikasi Data</h4>
                    <p class="text-gray-600 text-sm">Verifikator memeriksa dokumen dan memberi status valid/invalid.</p>
                </div>
                <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition">
                    <h4 class="text-lg font-semibold text-[#1E3A8A] mb-2">Dashboard & Statistik</h4>
                    <p class="text-gray-600 text-sm">Admin memantau distribusi data per prodi & menyiapkan cetak SKPI.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Panduan -->
    <section id="panduan" class="py-16 bg-white scroll-mt-24 md:scroll-mt-28">
        <div class="max-w-4xl mx-auto px-6">
            <h3 class="text-center text-3xl font-bold text-[#1E3A8A] mb-8">Panduan</h3>
            <div class="space-y-4">
                <details class="group bg-gray-50 rounded-lg shadow-sm p-4 open:shadow-md">
                    <summary class="cursor-pointer font-semibold text-[#0A2E73]">Bagaimana cara login?</summary>
                    <p class="mt-2 text-gray-600 text-sm">Klik tombol Login di kanan atas, masukkan email & password.</p>
                </details>
                <details class="group bg-gray-50 rounded-lg shadow-sm p-4 open:shadow-md">
                    <summary class="cursor-pointer font-semibold text-[#0A2E73]">Dokumen apa yang bisa diunggah?</summary>
                    <p class="mt-2 text-gray-600 text-sm">Prestasi, organisasi, pelatihan, magang, dan sertifikat (PDF/JPG/PNG).</p>
                </details>
                <details class="group bg-gray-50 rounded-lg shadow-sm p-4 open:shadow-md">
                    <summary class="cursor-pointer font-semibold text-[#0A2E73]">Apa manfaat SKPI?</summary>
                    <p class="mt-2 text-gray-600 text-sm">Sebagai rekam jejak resmi untuk mendukung karir & studi lanjut.</p>
                </details>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-[#0A2E73] text-white">
        <div class="max-w-6xl mx-auto px-6 py-8 grid md:grid-cols-2 gap-6">
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <img src="{{ asset('images/logo-ft.png') }}" class="w-8 h-8" alt="Logo FT">
                    <span class="font-semibold">Fakultas Teknik UNIB</span>
                </div>
                <p class="text-sm text-white/80">© 2025 Fakultas Teknik, Universitas Bengkulu</p>
            </div>
            <div class="text-sm">
                <div class="font-medium mb-1">Kontak</div>
                <p>Jl. W.R. Supratman, Kandang Limun, Kota Bengkulu</p>
                <p>Email: ft@unib.ac.id | Telp: (0736) 000000</p>
            </div>
        </div>
    </footer>


        <!-- Floating Contact Button -->
    <button id="chatbot-toggle" aria-label="Kontak admin" class="fixed bottom-6 right-6 z-50 rounded-full bg-[#F97316] hover:bg-[#FF7C1F] text-white shadow-lg w-14 h-14 flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor"><path d="M2.25 6.75A2.25 2.25 0 0 1 4.5 4.5h3A2.25 2.25 0 0 1 9.75 6.75v1.5a2.25 2.25 0 0 1-2.25 2.25h-.257a12.04 12.04 0 0 0 5.257 5.257V15a2.25 2.25 0 0 1 2.25-2.25h1.5A2.25 2.25 0 0 1 20.25 15v3a2.25 2.25 0 0 1-2.25 2.25h-.75C9.708 20.25 3.75 14.292 3.75 6.75Z"/></svg>
    </button>

    <div id="chatbot-panel" class="fixed bottom-24 right-6 z-50 w-80 max-w-[92vw] bg-white text-gray-800 rounded-xl shadow-2xl border border-gray-200 hidden">
        <div class="px-4 py-4">
            <div class="font-semibold text-[#0A2E73]">Kontak Admin SKPI</div>
            <div class="mt-2 text-sm space-y-1">
                <div>Admin: <a href="tel:081234567890" class="text-[#F97316]">0812-3456-7890</a></div>
                <div>Helpdesk: <a href="mailto:helpdesk.ft@unib.ac.id" class="text-[#F97316]">helpdesk.ft@unib.ac.id</a></div>
            </div>
            <div class="mt-3 flex gap-2">
                <button data-copy="081234567890" class="copy-btn bg-gray-100 hover:bg-gray-200 text-gray-800 px-3 py-1.5 rounded-lg text-sm">Salin No</button>
                <a href="mailto:helpdesk.ft@unib.ac.id" class="bg-[#F97316] hover:bg-[#FF7C1F] text-white px-3 py-1.5 rounded-lg text-sm">Kirim Email</a>
            </div>
            <button id="chatbot-close" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700" aria-label="Tutup">×</button>
        </div>
    </div>

    <script>
      (function(){
        

        const toggle = document.getElementById('chatbot-toggle');
        const panel = document.getElementById('chatbot-panel');
        const closeBtn = document.getElementById('chatbot-close');
        function show(){ panel.classList.remove('hidden'); }
        function hide(){ panel.classList.add('hidden'); }
        toggle.addEventListener('click', () => panel.classList.contains('hidden') ? show() : hide());
        closeBtn?.addEventListener('click', hide);
        panel.addEventListener('click', (e)=>{
          const btn = e.target.closest('.copy-btn');
          if(btn){ navigator.clipboard?.writeText(btn.getAttribute('data-copy')); btn.textContent='Disalin'; setTimeout(()=>btn.textContent='Salin No', 1200); }
        });
      })();
    </script></body>
</html>






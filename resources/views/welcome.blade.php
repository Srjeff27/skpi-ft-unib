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
        /* Custom style for FAQ chevron rotation */
        details[open] summary svg.chevron {
            transform: rotate(180deg);
        }
    </style>
</head>

<body class="bg-gray-50 font-sans text-gray-800 antialiased">

    {{-- Header --}}
    <header class="sticky top-0 z-50 border-b border-gray-200/80 bg-white/90 backdrop-blur-lg">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-3">
            <a href="#beranda" class="flex items-center gap-3">
                <img src="{{ asset('images/logo-ft.png') }}" alt="Logo FT UNIB" class="h-9 w-9">
                <span class="font-semibold text-[#0A2E73]">Fakultas Teknik UNIB</span>
            </a>
            <nav class="hidden items-center gap-8 text-sm font-medium md:flex">
                <a href="#tentang" class="text-gray-600 transition hover:text-[#F97316]">Tentang</a>
                <a href="#fitur" class="text-gray-600 transition hover:text-[#F97316]">Fitur</a>
                <a href="#panduan" class="text-gray-600 transition hover:text-[#F97316]">Panduan</a>
                @guest
                    <a href="{{ route('login') }}"
                        class="rounded-full bg-[#F97316] px-6 py-2 text-white shadow-sm transition hover:bg-[#E8630B]">Login</a>
                @else
                    <a href="{{ route('dashboard') }}"
                        class="rounded-full bg-[#F97316] px-6 py-2 text-white shadow-sm transition hover:bg-[#E8630B]">Dashboard</a>
                @endguest
            </nav>
            <div class="md:hidden">
                <details class="relative">
                    <summary
                        class="list-none cursor-pointer rounded-lg border px-3 py-2 text-sm font-medium text-[#0A2E73] hover:bg-gray-100">
                        Menu</summary>
                    <div class="absolute right-0 z-50 mt-2 flex w-48 flex-col gap-2 rounded-lg bg-white p-3 shadow-xl">
                        <a href="#tentang"
                            class="rounded-md px-3 py-2 hover:bg-gray-100 hover:text-[#F97316]">Tentang</a>
                        <a href="#fitur" class="rounded-md px-3 py-2 hover:bg-gray-100 hover:text-[#F97316]">Fitur</a>
                        <a href="#panduan"
                            class="rounded-md px-3 py-2 hover:bg-gray-100 hover:text-[#F97316]">Panduan</a>
                        <hr class="my-1">
                        @guest
                            <a href="{{ route('login') }}"
                                class="mt-1 rounded-lg bg-[#F97316] px-4 py-2 text-center text-white hover:bg-[#E8630B]">Login</a>
                        @else
                            <a href="{{ route('dashboard') }}"
                                class="mt-1 rounded-lg bg-[#F97316] px-4 py-2 text-center text-white hover:bg-[#E8630B]">Dashboard</a>
                        @endguest
                    </div>
                </details>
            </div>
        </div>
    </header>

    <main>

        {{-- Section: Beranda (Hero) --}}
        <section id="beranda"
            class="relative overflow-hidden scroll-mt-24 bg-gradient-to-br from-[#0A2E73] via-[#1E3A8A] to-[#0F172A]">
            <div class="mx-auto grid max-w-7xl items-center gap-10 px-6 py-16 md:grid-cols-2 md:py-28">
                <div>
                    <h1 class="text-3xl font-bold leading-tight text-white sm:text-4xl lg:text-5xl">
                        Sistem Informasi<br>Surat Keterangan Pendamping Ijazah
                        <span class="text-[#F97316]">(SKPI)</span>
                    </h1>
                    <p class="mt-6 text-base text-white/90 md:text-lg">Mencatat, memverifikasi, dan menerbitkan SKPI
                        secara digital untuk mendukung mahasiswa unggul dan berdaya saing.</p>
                    <div class="mt-8 flex flex-col gap-4 sm:flex-row">
                        @guest
                            <a href="{{ route('login') }}"
                                class="transform rounded-lg bg-[#F97316] px-8 py-3 text-center text-sm font-semibold text-white shadow-lg transition hover:-translate-y-1 hover:bg-[#E8630B] sm:text-base">Mulai
                                Sekarang</a>
                        @else
                            <a href="{{ route('dashboard') }}"
                                class="transform rounded-lg bg-[#F97316] px-8 py-3 text-center text-sm font-semibold text-white shadow-lg transition hover:-translate-y-1 hover:bg-[#E8630B] sm:text-base">Buka
                                Dashboard</a>
                        @endguest
                        <a href="#tentang"
                            class="transform rounded-lg border border-white/30 px-8 py-3 text-center text-sm font-semibold text-white transition hover:-translate-y-1 hover:bg-white/10 sm:text-base">Pelajari
                            Lebih Lanjut</a>
                    </div>
                </div>
                <div class="relative hidden md:block">
                    <img src="{{ asset('images/background-ft.jpg') }}" alt="Gedung FT UNIB"
                        class="mx-auto w-full max-w-md rounded-2xl shadow-2xl ring-1 ring-black/10">
                    <div
                        class="absolute -bottom-6 -left-6 flex items-center gap-3 rounded-lg bg-white/90 p-4 shadow-lg backdrop-blur-sm max-w-[200px]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#1E3A8A]" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <div>
                            <div class="font-semibold leading-snug text-[#0A2E73]">Upload Portofolio</div>
                            <p class="text-xs leading-relaxed text-gray-600">Prestasi, Pelatihan, Organisasi</p>
                        </div>
                    </div>
                    <div
                        class="absolute -right-6 -top-6 flex items-center gap-3 rounded-lg bg-white/90 p-4 shadow-lg backdrop-blur-sm w-44">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <div class="font-semibold text-[#0A2E73]">Verifikasi Data</div>
                            <p class="text-xs text-gray-600">Valid / Invalid</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Section: Tentang --}}
        <section id="tentang" class="scroll-mt-24 bg-white py-16 sm:py-20">
            <div class="mx-auto grid max-w-6xl items-center gap-10 px-6 md:grid-cols-2 lg:gap-16">
                <div>
                    <h2 class="text-3xl font-bold text-[#1E3A8A]">Apa itu SKPI?</h2>
                    <p class="mt-4 leading-relaxed text-gray-600">SKPI (Surat Keterangan Pendamping Ijazah) adalah
                        dokumen resmi yang memuat rekam jejak kemampuan, pengetahuan, dan sikap mahasiswa selama
                        perkuliahan, baik di bidang akademik maupun non-akademik.</p>
                    <p class="mt-3 leading-relaxed text-gray-600">Sistem ini membantu mahasiswa Fakultas Teknik
                        Universitas Bengkulu untuk mengelola portofolio mereka secara digital hingga proses penerbitan
                        SKPI resmi saat wisuda.</p>
                </div>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div class="rounded-lg bg-orange-50 p-5 text-center ring-1 ring-orange-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-8 w-8 text-orange-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <div class="mt-2 font-semibold text-orange-600">Sertifikat</div>
                    </div>
                    <div class="rounded-lg bg-orange-50 p-5 text-center ring-1 ring-orange-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-8 w-8 text-orange-500"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                        <div class="mt-2 font-semibold text-orange-600">Prestasi</div>
                    </div>
                    <div class="rounded-lg bg-orange-50 p-5 text-center ring-1 ring-orange-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-8 w-8 text-orange-500"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <div class="mt-2 font-semibold text-orange-600">Organisasi</div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Section: Fitur --}}
        <section id="fitur" class="scroll-mt-24 bg-gray-50 py-16 sm:py-20">
            <div class="mx-auto max-w-6xl px-6">
                <div class="text-center">
                    <h2 class="text-3xl font-bold text-[#1E3A8A]">Fitur Utama Sistem</h2>
                    <p class="mx-auto mt-3 max-w-2xl text-gray-600">Dirancang untuk menyederhanakan proses, dari
                        pengumpulan data hingga penerbitan dokumen akhir.</p>
                </div>
                <div class="mt-12 grid gap-6 md:grid-cols-3 lg:gap-8">
                    <div
                        class="transform rounded-xl bg-white p-6 shadow-md transition duration-300 hover:-translate-y-2 hover:shadow-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[#F97316]" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        <h3 class="mt-4 text-lg font-semibold text-[#1E3A8A]">Upload Portofolio</h3>
                        <p class="mt-2 text-sm text-gray-600">Mahasiswa dapat dengan mudah mengunggah bukti prestasi,
                            keikutsertaan organisasi, pelatihan, dan sertifikat.</p>
                    </div>
                    <div
                        class="transform rounded-xl bg-white p-6 shadow-md transition duration-300 hover:-translate-y-2 hover:shadow-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[#F97316]" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-4 text-lg font-semibold text-[#1E3A8A]">Verifikasi Online</h3>
                        <p class="mt-2 text-sm text-gray-600">Tim verifikator memeriksa setiap dokumen yang diunggah
                            dan memberikan status validasi secara transparan.</p>
                    </div>
                    <div
                        class="transform rounded-xl bg-white p-6 shadow-md transition duration-300 hover:-translate-y-2 hover:shadow-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[#F97316]" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        <h3 class="mt-4 text-lg font-semibold text-[#1E3A8A]">Penerbitan Otomatis</h3>
                        <p class="mt-2 text-sm text-gray-600">Sistem secara otomatis merekap data terverifikasi dan
                            menghasilkan dokumen SKPI yang siap dicetak.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Section: Panduan & FAQ --}}
        <section id="panduan" class="scroll-mt-24 bg-white py-16 sm:py-20">
            <div class="mx-auto max-w-4xl px-6">
                <div class="text-center">
                    <h2 class="text-3xl font-bold text-[#1E3A8A]">Panduan & Informasi</h2>
                    <p class="mx-auto mt-3 max-w-2xl text-gray-600">Pahami alur pengajuan dan temukan jawaban dari
                        pertanyaan yang sering diajukan.</p>
                </div>
                <div class="mt-12">
                    <h3 class="mb-8 text-center text-xl font-bold text-gray-800">Alur Pengajuan SKPI</h3>
                    <div class="relative">
                        <div class="absolute left-4 top-0 h-full w-0.5 bg-gray-200" aria-hidden="true"></div>
                        <ol class="relative space-y-8">
                            <li class="flex items-start">
                                <div
                                    class="z-10 flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-blue-600 text-white ring-8 ring-white">
                                    <span class="font-bold">1</span>
                                </div>
                                <div class="ml-6">
                                    <h4 class="font-semibold text-gray-800">Pengajuan Akun</h4>
                                    <p class="mt-1 text-sm text-gray-600">Mahasiswa mengajukan pembuatan akun SKPI
                                        kepada Admin Fakultas.</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <div
                                    class="z-10 flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-blue-600 text-white ring-8 ring-white">
                                    <span class="font-bold">2</span>
                                </div>
                                <div class="ml-6">
                                    <h4 class="font-semibold text-gray-800">Aktivasi Akun & Login</h4>
                                    <p class="mt-1 text-sm text-gray-600">Admin memverifikasi dan mengaktivasi akun,
                                        kemudian mahasiswa dapat login.</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <div
                                    class="z-10 flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-blue-600 text-white ring-8 ring-white">
                                    <span class="font-bold">3</span>
                                </div>
                                <div class="ml-6">
                                    <h4 class="font-semibold text-gray-800">Mengisi Portofolio</h4>
                                    <p class="mt-1 text-sm text-gray-600">Mahasiswa mengisi data portofolio secara
                                        berkala (prestasi, organisasi, dll).</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <div
                                    class="z-10 flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-green-500 text-white ring-8 ring-white">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
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
                <div class="mt-16">
                    <h3 class="mb-8 text-center text-xl font-bold text-gray-800">Pertanyaan Umum (FAQ)</h3>
                    <div class="space-y-4 text-left">
                        <details
                            class="group rounded-lg bg-gray-100 p-4 transition-all duration-300 open:bg-white open:shadow-lg">
                            <summary
                                class="flex cursor-pointer items-center justify-between font-semibold text-[#0A2E73]">
                                Apa Itu SKPI?
                                <svg class="chevron h-5 w-5 text-gray-500 transition-transform duration-300"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                </svg>
                            </summary>
                            <div class="mt-3 space-y-2 text-sm text-gray-600">
                                <p>Surat Keterangan Pendamping Ijazah (SKPI) adalah dokumen resmi yang memuat informasi
                                    tentang pencapaian akademik dan kualifikasi lulusan, termasuk prestasi,
                                    keterampilan, dan pengalaman selama menjadi mahasiswa.</p>
                            </div>
                        </details>
                        <details
                            class="group rounded-lg bg-gray-100 p-4 transition-all duration-300 open:bg-white open:shadow-lg">
                            <summary
                                class="flex cursor-pointer items-center justify-between font-semibold text-[#0A2E73]">
                                Apa Tujuan & Manfaat SKPI?
                                <svg class="chevron h-5 w-5 text-gray-500 transition-transform duration-300"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                </svg>
                            </summary>
                            <div class="mt-3 space-y-2 text-sm text-gray-600">
                                <p>Tujuan utamanya adalah memberikan penjelasan yang objektif mengenai kompetensi
                                    seorang lulusan. Manfaatnya antara lain:</p>
                                <ul class="list-inside list-disc space-y-1">
                                    <li>Meningkatkan kelayakan kerja (*employability*) di mata perusahaan.</li>
                                    <li>Menjadi dokumen pendukung untuk melanjutkan studi ke jenjang yang lebih tinggi.
                                    </li>
                                    <li>Memberikan gambaran lengkap tentang profil alumni yang kompeten dan berdaya
                                        saing.</li>
                                </ul>
                            </div>
                        </details>
                        <details
                            class="group rounded-lg bg-gray-100 p-4 transition-all duration-300 open:bg-white open:shadow-lg">
                            <summary
                                class="flex cursor-pointer items-center justify-between font-semibold text-[#0A2E73]">
                                Bagaimana Cara Mengisinya?
                                <svg class="chevron h-5 w-5 text-gray-500 transition-transform duration-300"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                </svg>
                            </summary>
                            <p class="mt-3 text-sm text-gray-600">Mahasiswa dapat login ke sistem melalui laman ini.
                                Pengisian data capaian dan kegiatan dilakukan sejak semester pertama dengan mengunggah
                                dokumen bukti yang sah.</p>
                        </details>
                    </div>
                </div>
            </div>
        </section>

    </main>

    {{-- Footer --}}
    <footer class="bg-[#0A2E73] pt-12 text-white sm:pt-16">
        <div class="mx-auto max-w-7xl px-6">
            <div class="grid grid-cols-1 gap-8 border-t border-white/20 pt-10 md:grid-cols-2 lg:grid-cols-4">

                {{-- Kolom 1: Tentang Fakultas --}}
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo-ft.png') }}" class="h-10 w-10" alt="Logo FT">
                        <div>
                            <p class="font-bold leading-tight text-lg">Fakultas Teknik</p>
                            <p class="text-sm text-white/80">Universitas Bengkulu</p>
                        </div>
                    </div>
                    <p class="text-sm text-white/80">
                        © {{ date('Y') }} Fakultas Teknik, Universitas Bengkulu. All rights reserved.
                    </p>
                </div>

                {{-- Kolom 2: Alamat --}}
                <div class="text-sm">
                    <h3 class="mb-3 font-semibold text-white">Alamat</h3>
                    <address class="not-italic space-y-2 text-white/80">
                        <p>
                            DEKANAT FAKULTAS TEKNIK<br>
                            Jalan WR. Supratman, Kandang Limun<br>
                            Kec. Muara Bangkahulu, Kota Bengkulu<br>
                            Bengkulu, 38371A, INDONESIA
                        </p>
                        <p>
                            Email: <a href="mailto:ft@unib.ac.id"
                                class="underline hover:text-orange-400">ft@unib.ac.id</a>
                        </p>
                    </address>
                </div>

                {{-- Kolom 3: Program Studi --}}
                <div class="text-sm">
                    <h3 class="mb-3 font-semibold text-white">Program Studi</h3>
                    <ul class="space-y-2 text-white/80">
                        <li><a href="#" class="transition-colors hover:text-orange-400">Informatika</a></li>
                        <li><a href="#" class="transition-colors hover:text-orange-400">Teknik Sipil</a></li>
                        <li><a href="#" class="transition-colors hover:text-orange-400">Teknik Elektro</a></li>
                        <li><a href="#" class="transition-colors hover:text-orange-400">Teknik Mesin</a></li>
                        <li><a href="#" class="transition-colors hover:text-orange-400">Arsitektur</a></li>
                        <li><a href="#" class="transition-colors hover:text-orange-400">Sistem Informasi</a>
                        </li>
                    </ul>
                </div>

                {{-- Kolom 4: Media Sosial --}}
                <div class="text-sm">
                    <h3 class="mb-3 font-semibold text-white">Media Sosial</h3>
                    <div class="flex items-center gap-4">
                        <a href="#" aria-label="Facebook"
                            class="text-white/80 transition-colors hover:text-orange-400">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" aria-label="Instagram"
                            class="text-white/80 transition-colors hover:text-orange-400">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.024.06 1.378.06 3.808s-.012 2.784-.06 3.808c-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.024.048-1.378.06-3.808.06s-2.784-.013-3.808-.06c-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.048-1.024-.06-1.378-.06-3.808s.012-2.784.06-3.808c.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 016.08 2.525c.636-.247 1.363-.416 2.427-.465C9.53 2.013 9.884 2 12.315 2zm0 1.62c-2.403 0-2.73.01-3.69.058-1.01.048-1.597.2-1.995.368a3.262 3.262 0 00-1.18 1.18c-.168.398-.32.985-.368 1.995-.048.96-.058 1.287-.058 3.69s.01 2.73.058 3.69c.048 1.01.2 1.597.368 1.995a3.262 3.262 0 001.18 1.18c.398.168.985.32 1.995.368.96.048 1.287.058 3.69.058s2.73-.01 3.69-.058c1.01-.048 1.597-.2 1.995-.368a3.262 3.262 0 001.18-1.18c.168-.398.32-.985.368-1.995.048-.96.058-1.287.058-3.69s-.01-2.73-.058-3.69c-.048-1.01-.2-1.597-.368-1.995a3.262 3.262 0 00-1.18-1.18c-.398-.168-.985-.32-1.995-.368C15.045 3.63 14.715 3.62 12.315 3.62zM12 7.188a4.813 4.813 0 100 9.625 4.813 4.813 0 000-9.625zM12 15a3 3 0 110-6 3 3 0 010 6zm6.406-11.845a1.25 1.25 0 100 2.5 1.25 1.25 0 000-2.5z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" aria-label="Twitter"
                            class="text-white/80 transition-colors hover:text-orange-400">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                            </svg>
                        </a>
                        <a href="#" aria-label="YouTube"
                            class="text-white/80 transition-colors hover:text-orange-400">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M19.812 5.418c.861.23 1.538.907 1.768 1.768C21.998 8.78 22 12 22 12s0 3.22-.42 4.814a2.506 2.506 0 0 1-1.768 1.768c-1.593.42-7.81.42-7.81.42s-6.217 0-7.81-.42a2.506 2.506 0 0 1-1.768-1.768C2 15.22 2 12 2 12s0-3.22.42-4.814a2.506 2.506 0 0 1 1.768-1.768C5.783 5 12 5 12 5s6.217 0 7.812.418ZM15.196 12 10 14.734V9.266z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="mt-8 py-6 text-center text-xs text-white/60">
                <p>Dikembangkan oleh Tim PPSI Program Studi Sistem Informasi Fakultas Teknik Universitas Bengkulu</p>
            </div>
        </div>
    </footer>


    {{-- Chatbot --}}
    <button id="chatbot-toggle" aria-label="Kontak admin"
        class="fixed bottom-6 right-6 z-50 flex h-14 w-14 items-center justify-center rounded-full bg-[#F97316] text-white shadow-lg transition-transform hover:scale-110 hover:bg-[#E8630B]">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
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
                    class="rounded-lg bg-[#F97316] px-3 py-1.5 text-sm text-white hover:bg-[#E8630B]">Kirim Email</a>
            </div>
            <button id="chatbot-close" class="absolute right-2 top-2 text-gray-500 hover:text-gray-800"
                aria-label="Tutup">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
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

<x-app-layout>
    <div class="space-y-6">
        <div class="relative rounded-xl bg-gradient-to-r from-[#1b3985] to-[#2b50a8] p-6 overflow-hidden">
            <div class="relative z-10 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-white">Unggah Portofolio Baru</h1>
                    <p class="text-blue-200 mt-1 max-w-md">Isi detail kegiatan, prestasi, atau pengalaman yang ingin Anda ajukan.</p>
                </div>
                <button type="button" id="tutorial-open" class="inline-flex items-center gap-2 rounded-lg bg-white/15 px-4 py-2 text-sm font-semibold text-white backdrop-blur hover:bg-white/25 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16h6m2 4H7a2 2 0 01-2-2V6a2 2 0 012-2h3.586a1 1 0 01.707.293l1.414 1.414A1 1 0 0013.414 6H17a2 2 0 012 2v10a2 2 0 01-2 2z" /></svg>
                    Lihat Tutorial
                </button>
            </div>
            <div class="absolute -bottom-12 -right-12 w-40 h-40 rounded-full bg-blue-800 opacity-50"></div>
        </div>

        @if ($errors->any())
            <div class="p-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
                <span class="font-medium">Terjadi kesalahan!</span> {{ $errors->first('general') ?? 'Gagal mengunggah portofolio. Periksa kembali isian Anda.' }}
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
            <form method="POST" action="{{ route('student.portfolios.store') }}" enctype="multipart/form-data">
                @csrf
                
                @include('student.portfolios._form', ['portfolio' => null])

                <div class="bg-gray-50 px-6 py-4 flex items-center justify-end gap-4 rounded-b-xl">
                    <a href="{{ route('student.portfolios.index') }}"
                        class="inline-flex justify-center rounded-md text-sm font-semibold text-gray-700 hover:bg-gray-200 px-4 py-2 transition-colors border border-gray-300 bg-white shadow-sm">
                        Batal
                    </a>
                    <x-primary-button>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 13H11V9.414l-1.293 1.293a1 1 0 01-1.414-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L13 9.414V13h-2.5z" />
                            <path d="M9 13h2v5a1 1 0 11-2 0v-5z" />
                        </svg>
                        Upload Portofolio
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tutorial Pop-up: ditampilkan saat pertama kali membuka halaman upload portofolio --}}
    <div id="portfolio-tutorial" class="fixed inset-0 z-50 hidden items-center justify-center px-4">
        <div class="absolute inset-0 bg-slate-900/70 backdrop-blur-sm"></div>
        <div class="relative w-full max-w-3xl bg-white rounded-2xl shadow-2xl border border-slate-200 overflow-hidden animate-enter-up">
            <div class="bg-gradient-to-r from-[#1b3985] to-[#2b50a8] px-6 py-4 text-white flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-widest text-blue-100">Panduan Singkat</p>
                    <h3 class="text-xl font-bold">Cara Mengisi Formulir Portofolio</h3>
                </div>
                <button type="button" id="tutorial-close" class="p-2 rounded-full bg-white/10 hover:bg-white/20 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="rounded-xl border border-slate-100 bg-slate-50/60 p-4">
                        <div class="flex items-start gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#e9efff] text-[#1b3985]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l3 3M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <div class="space-y-1">
                                <p class="font-semibold text-slate-800">Judul & Kategori</p>
                                <p class="text-sm text-slate-600">Isi Judul Kegiatan secara ringkas. Pilih/isi <strong>kategori portofolio</strong> yang paling sesuai (misal: Lomba, Organisasi, Magang).</p>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-xl border border-slate-100 bg-slate-50/60 p-4">
                        <div class="flex items-start gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#fff4e6] text-[#e5670c]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 9.4L7.55 5.26a.55.55 0 00-.78.5v12.48c0 .4.41.67.78.5L16.5 14.5a.56.56 0 000-1l-4.74-2.25" /></svg>
                            </div>
                            <div class="space-y-1">
                                <p class="font-semibold text-slate-800">Penyelenggara & Nama Dokumen</p>
                                <p class="text-sm text-slate-600">Cantumkan <strong>penyelenggara</strong> kegiatan. Isi <strong>Nama Dokumen (ID/EN)</strong> sesuai sertifikat atau piagam (contoh: Juara 1 Lomba Cipta Puisi).</p>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-xl border border-slate-100 bg-slate-50/60 p-4">
                        <div class="flex items-start gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#e6fbf3] text-[#0ea371]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5.25C3 4.56 3.56 4 4.25 4h15.5c.69 0 1.25.56 1.25 1.25v13.5c0 .69-.56 1.25-1.25 1.25H4.25A1.25 1.25 0 013 18.75V5.25z" /><path stroke-linecap="round" stroke-linejoin="round" d="M7 9h10M7 13h10M7 17h6" /></svg>
                            </div>
                            <div class="space-y-1">
                                <p class="font-semibold text-slate-800">Deskripsi & Tanggal</p>
                                <p class="text-sm text-slate-600">Tuliskan <strong>deskripsi singkat</strong> berisi peran, capaian, dan hasil. Isi <strong>tanggal dokumen</strong> mengikuti tanggal sertifikat/pengumuman.</p>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-xl border border-slate-100 bg-slate-50/60 p-4">
                        <div class="flex items-start gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#fbe8ef] text-[#d02973]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L2.34 18c-.77 1.333.192 3 1.732 3z" /></svg>
                            </div>
                            <div class="space-y-1">
                                <p class="font-semibold text-slate-800">Nomor & Link Bukti</p>
                                <p class="text-sm text-slate-600">Isi <strong>nomor dokumen</strong> jika ada (opsional). Tempel <strong>link bukti/sertifikat</strong> (Google Drive publik “Siapa saja yang memiliki link”). Pastikan file dapat dibuka.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pt-2">
                    <div class="text-sm text-slate-500 flex items-center gap-2">
                        <span class="inline-flex h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                        Simpan data sebelum menutup halaman untuk menghindari isian hilang.
                    </div>
                    <div class="flex gap-3">
                        <button type="button" id="tutorial-hide" class="text-sm font-semibold text-slate-500 hover:text-slate-700">Jangan tampilkan lagi</button>
                        <button type="button" id="tutorial-start" class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-[#fa7516] to-[#e5670c] px-4 py-2 text-sm font-semibold text-white shadow-lg hover:shadow-orange-300 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3l14 9-14 9V3z" /></svg>
                            Mulai Isi Form
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const overlay = document.getElementById('portfolio-tutorial');
            if (!overlay) return;
            const closeBtn = document.getElementById('tutorial-close');
            const startBtn = document.getElementById('tutorial-start');
            const hideBtn = document.getElementById('tutorial-hide');
            const openBtn = document.getElementById('tutorial-open');
            const STORAGE_KEY = 'skpi_portfolio_tutorial_seen';

            const show = () => {
                overlay.classList.remove('hidden');
                overlay.classList.add('flex');
                document.body.classList.add('overflow-hidden');
            };
            const hide = (remember = false) => {
                overlay.classList.add('hidden');
                overlay.classList.remove('flex');
                document.body.classList.remove('overflow-hidden');
                if (remember) localStorage.setItem(STORAGE_KEY, '1');
            };

            if (!localStorage.getItem(STORAGE_KEY)) {
                show();
            }

            [closeBtn, startBtn].forEach(btn => btn?.addEventListener('click', () => hide(true)));
            hideBtn?.addEventListener('click', () => hide(true));
            openBtn?.addEventListener('click', () => show());
        });
    </script>
</x-app-layout>

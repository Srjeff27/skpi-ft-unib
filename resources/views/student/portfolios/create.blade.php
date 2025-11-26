<x-app-layout>
    @php
        $successToast = session('status');
        $errorToast = session('error') ?? ($errors->any() ? ($errors->first('general') ?? 'Gagal menyimpan portofolio. Periksa kembali isian Anda.') : null);
    @endphp

    <div x-data="tutorialHandler()" x-init="init()" class="max-w-4xl mx-auto space-y-8 pb-20">
        
        {{-- 1. Hero / Header Section --}}
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900 via-[#1b3985] to-[#2b50a8] shadow-xl group">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 h-64 w-64 rounded-full bg-white/5 blur-3xl pointer-events-none group-hover:bg-white/10 transition-colors duration-700"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 h-40 w-40 rounded-full bg-blue-400/10 blur-2xl pointer-events-none"></div>
            
            <div class="relative z-10 p-6 sm:p-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="space-y-2">
                    <h1 class="text-3xl font-bold text-white tracking-tight">Upload Portofolio</h1>
                    <p class="text-blue-100/90 text-sm md:text-base max-w-xl leading-relaxed">
                        Dokumentasikan prestasi dan kegiatan Anda untuk validasi SKPI. Pastikan data akurat dan bukti dapat diakses.
                    </p>
                </div>
                <button @click="openTutorial()" type="button" 
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 text-white font-medium text-sm hover:bg-white/20 hover:scale-105 transition-all duration-300 shadow-lg shadow-blue-900/20">
                    <x-heroicon-o-information-circle class="w-5 h-5" />
                    <span>Panduan Pengisian</span>
                </button>
            </div>
        </div>

        {{-- 2. Error Alert --}}
        @if ($errors->any())
            <div class="rounded-xl bg-rose-50 border-l-4 border-rose-500 p-4 shadow-sm animate-pulse-once">
                <div class="flex items-start gap-3">
                    <x-heroicon-s-x-circle class="w-6 h-6 text-rose-500 shrink-0" />
                    <div>
                        <h3 class="text-sm font-bold text-rose-800">Gagal Mengunggah</h3>
                        <p class="text-sm text-rose-700 mt-1">
                            {{ $errors->first('general') ?? 'Mohon periksa kembali isian formulir di bawah ini.' }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        {{-- 3. Main Form Card --}}
        <form method="POST" action="{{ route('student.portfolios.store') }}" enctype="multipart/form-data" class="block">
            @csrf
            
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-6 sm:p-10">
                    @include('student.portfolios._form', ['portfolio' => null])
                </div>

                <div class="bg-slate-50 px-6 py-5 sm:px-10 border-t border-slate-200 flex flex-col-reverse sm:flex-row sm:items-center justify-end gap-3">
                    <a href="{{ route('student.portfolios.index') }}" 
                       class="w-full sm:w-auto inline-flex justify-center items-center px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 hover:bg-white hover:text-slate-900 font-semibold text-sm transition-all shadow-sm">
                        Batal
                    </a>
                    <button type="submit" 
                            class="w-full sm:w-auto inline-flex justify-center items-center gap-2 px-6 py-2.5 rounded-lg bg-[#1b3985] text-white hover:bg-[#152e6b] font-semibold text-sm shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all focus:ring-4 focus:ring-blue-500/30">
                        <x-heroicon-m-cloud-arrow-up class="w-5 h-5" />
                        Simpan & Upload
                    </button>
                </div>
            </div>
        </form>

        {{-- 4. Modern Tutorial Modal (Alpine.js) --}}
        <div x-show="show" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center px-3 sm:px-6"
             style="display: none;" x-cloak
             @click.self="closeTutorial()">
            
            <div x-show="show"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 class="relative w-full max-w-xl sm:max-w-3xl bg-white rounded-2xl shadow-2xl overflow-hidden flex flex-col max-h-[82vh] sm:max-h-[90vh]">
            
                {{-- Modal Header --}}
                <div class="bg-gradient-to-r from-[#1b3985] to-[#2b50a8] px-4 py-4 sm:px-6 sm:py-5 flex items-center justify-between shrink-0">
                    <div class="text-white">
                        <p class="text-[11px] sm:text-xs font-bold uppercase tracking-wider text-blue-200/80 mb-0.5 sm:mb-1">Panduan Singkat</p>
                        <h3 class="text-lg sm:text-xl font-bold leading-tight">Cara Pengisian Portofolio</h3>
                    </div>
                    <button @click="closeTutorial()" class="p-1.5 sm:p-2 rounded-full bg-white/10 text-white hover:bg-white/20 transition-colors">
                        <x-heroicon-m-x-mark class="w-5 h-5 sm:w-6 sm:h-6" />
                    </button>
                </div>

                {{-- Modal Content (Scrollable) --}}
                <div class="p-4 sm:p-6 overflow-y-auto custom-scrollbar">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4">
                        {{-- Step 1 --}}
                        <div class="flex gap-3 sm:gap-4 p-3 sm:p-4 rounded-xl bg-blue-50/50 border border-blue-100 hover:bg-blue-50 transition-colors">
                            <div class="shrink-0 flex h-9 w-9 sm:h-10 sm:w-10 items-center justify-center rounded-full bg-blue-100 text-blue-600">
                                <x-heroicon-o-tag class="w-4 h-4 sm:w-5 sm:h-5" />
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm mb-0.5 sm:mb-1">Judul & Kategori</h4>
                                <p class="text-[11px] sm:text-xs text-slate-600 leading-relaxed">Pilih kategori yang relevan (Lomba, Organisasi, dll). Judul harus ringkas namun jelas menggambarkan kegiatan.</p>
                            </div>
                        </div>

                        {{-- Step 2 --}}
                        <div class="flex gap-3 sm:gap-4 p-3 sm:p-4 rounded-xl bg-orange-50/50 border border-orange-100 hover:bg-orange-50 transition-colors">
                            <div class="shrink-0 flex h-9 w-9 sm:h-10 sm:w-10 items-center justify-center rounded-full bg-orange-100 text-orange-600">
                                <x-heroicon-o-building-library class="w-4 h-4 sm:w-5 sm:h-5" />
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm mb-0.5 sm:mb-1">Penyelenggara & Nama Dokumen</h4>
                                <p class="text-[11px] sm:text-xs text-slate-600 leading-relaxed">Isi nama penyelenggara resmi. Nama Dokumen (ID/EN) disesuaikan dengan teks pada sertifikat.</p>
                            </div>
                        </div>

                        {{-- Step 3 --}}
                        <div class="flex gap-3 sm:gap-4 p-3 sm:p-4 rounded-xl bg-emerald-50/50 border border-emerald-100 hover:bg-emerald-50 transition-colors">
                            <div class="shrink-0 flex h-9 w-9 sm:h-10 sm:w-10 items-center justify-center rounded-full bg-emerald-100 text-emerald-600">
                                <x-heroicon-o-calendar-days class="w-4 h-4 sm:w-5 sm:h-5" />
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm mb-0.5 sm:mb-1">Deskripsi & Tanggal</h4>
                                <p class="text-[11px] sm:text-xs text-slate-600 leading-relaxed">Jelaskan peran/capaian Anda secara singkat. Tanggal harus sesuai dengan tanggal terbit sertifikat.</p>
                            </div>
                        </div>

                        {{-- Step 4 --}}
                        <div class="flex gap-3 sm:gap-4 p-3 sm:p-4 rounded-xl bg-pink-50/50 border border-pink-100 hover:bg-pink-50 transition-colors">
                            <div class="shrink-0 flex h-9 w-9 sm:h-10 sm:w-10 items-center justify-center rounded-full bg-pink-100 text-pink-600">
                                <x-heroicon-o-link class="w-4 h-4 sm:w-5 sm:h-5" />
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm mb-0.5 sm:mb-1">Link Bukti Valid</h4>
                                <p class="text-[11px] sm:text-xs text-slate-600 leading-relaxed">Gunakan link Google Drive (Setting: "Anyone with the link"). Pastikan file dapat dibuka oleh verifikator.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Modal Footer --}}
                <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:py-4 border-t border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4 shrink-0">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input type="checkbox" x-model="dontShowAgain" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500 cursor-pointer h-4 w-4">
                        <span class="text-[11px] sm:text-xs font-medium text-slate-500 group-hover:text-slate-700 select-none">Jangan tampilkan lagi</span>
                    </label>
                    <button @click="closeTutorial()" class="w-full sm:w-auto inline-flex justify-center items-center gap-2 rounded-lg bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white px-5 py-2.5 text-sm font-bold shadow-lg shadow-orange-200 transition-all">
                        Mulai Isi Formulir
                        <x-heroicon-m-arrow-right class="w-4 h-4" />
                    </button>
            </div>
        </div>

        {{-- Toast Overlay --}}
        <div x-show="toast.show"
             x-transition.opacity
             class="fixed inset-0 z-50 flex items-center justify-center px-4 sm:px-6"
             style="display: none;">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="toast.show = false"></div>
            <div x-transition
                 class="relative w-full max-w-sm rounded-2xl bg-white shadow-2xl ring-1 ring-slate-200 p-5 sm:p-6">
                <div class="flex items-start gap-3">
                    <div :class="toast.type === 'success' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700'"
                         class="flex h-10 w-10 items-center justify-center rounded-full">
                        <template x-if="toast.type === 'success'">
                            <x-heroicon-s-check-circle class="w-6 h-6" />
                        </template>
                        <template x-if="toast.type === 'error'">
                            <x-heroicon-s-exclamation-triangle class="w-6 h-6" />
                        </template>
                    </div>
                    <div class="flex-1 space-y-1">
                        <p class="text-sm font-semibold text-slate-900" x-text="toast.title"></p>
                        <p class="text-sm text-slate-600 leading-relaxed" x-text="toast.message"></p>
                    </div>
                    <button @click="toast.show = false" class="text-slate-400 hover:text-slate-600">
                        <x-heroicon-m-x-mark class="w-5 h-5" />
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function tutorialHandler() {
            return {
                show: false,
                dontShowAgain: false,
                storageKey: 'skpi_tutorial_dismissed',
                toast: { show: false, type: 'success', title: '', message: '' },
                openToast(type, title, message) {
                    this.toast = { show: true, type, title, message };
                    setTimeout(() => { this.toast.show = false; }, 4000);
                },
                init() {
                    if (!localStorage.getItem(this.storageKey)) {
                        setTimeout(() => this.show = true, 300); // Slight delay for smooth entrance
                    }
                    const successMsg = @js($successToast);
                    const errorMsg = @js($errorToast);
                    if (successMsg) this.openToast('success', 'Berhasil', successMsg);
                    else if (errorMsg) this.openToast('error', 'Gagal', errorMsg);
                },
                openTutorial() {
                    this.show = true;
                },
                closeTutorial() {
                    this.show = false;
                    if (this.dontShowAgain) {
                        localStorage.setItem(this.storageKey, 'true');
                    }
                }
            }
        }
    </script>
</x-app-layout>

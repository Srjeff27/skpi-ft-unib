<x-app-layout>
    <div class="space-y-8 pb-12">
        
        {{-- 1. Header Section --}}
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900 via-[#1b3985] to-[#2b50a8] shadow-xl">
            {{-- Decorative Background --}}
            <div class="absolute top-0 right-0 -mt-10 -mr-10 h-64 w-64 rounded-full bg-white/5 blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 h-40 w-40 rounded-full bg-blue-400/10 blur-2xl pointer-events-none"></div>

            <div class="relative z-10 p-6 sm:p-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="space-y-2">
                    <h1 class="text-3xl font-bold text-white tracking-tight">Dokumen SKPI</h1>
                    <p class="text-blue-100/90 text-sm md:text-base max-w-2xl leading-relaxed">
                        Pratinjau Surat Keterangan Pendamping Ijazah Anda. Pastikan seluruh data portofolio dan profil telah valid sebelum melakukan pengajuan final.
                    </p>
                </div>
                <div class="hidden md:block">
                    <div class="h-12 w-12 rounded-xl bg-white/10 backdrop-blur-md flex items-center justify-center text-white border border-white/20 shadow-lg">
                        <x-heroicon-o-document-text class="w-6 h-6" />
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            {{-- 2. Left Column: Document Preview (Wider) --}}
            <div class="lg:col-span-8 space-y-4">
                {{-- Preview Toolbar --}}
                <div class="flex items-center justify-between px-1">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <span class="flex h-2 w-2 rounded-full bg-red-500 animate-pulse"></span>
                        Live Preview
                    </h3>
                    <div class="text-xs text-slate-500 font-medium bg-slate-100 px-2 py-1 rounded-md">
                        Format A4
                    </div>
                </div>

                {{-- PDF Container --}}
                <div class="bg-slate-200/50 rounded-2xl border border-slate-300 p-4 sm:p-8 shadow-inner overflow-hidden">
                    <div x-data="{ loading: true }" class="relative w-full max-w-[210mm] mx-auto bg-white shadow-2xl rounded-sm ring-1 ring-slate-900/5 aspect-[1/1.414]">
                        
                        {{-- Loading Overlay --}}
                        <div x-show="loading" 
                             x-transition:leave="transition ease-in duration-300"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0"
                             class="absolute inset-0 z-10 flex flex-col items-center justify-center bg-white">
                            <svg class="animate-spin h-10 w-10 text-[#1b3985] mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text-sm font-medium text-slate-500">Merender Dokumen...</span>
                        </div>

                        {{-- Iframe --}}
                        <iframe @load="loading = false" 
                                src="{{ route('student.skpi.download') }}#toolbar=0&view=FitH" 
                                class="w-full h-full border-0" 
                                title="Pratinjau SKPI">
                        </iframe>
                    </div>
                </div>
            </div>

            {{-- 3. Right Column: Status & Actions (Narrower) --}}
            <div class="lg:col-span-4 space-y-6 sticky top-24">
                
                {{-- Status Card --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-4">Status Dokumen</h3>
                    <div class="flex items-center gap-4 p-4 rounded-xl bg-blue-50 border border-blue-100">
                        <div class="shrink-0">
                            <div class="h-10 w-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                                <x-heroicon-s-clock class="w-6 h-6" />
                            </div>
                        </div>
                        <div>
                            <p class="text-blue-900 font-bold text-lg">Draft</p>
                            <p class="text-blue-700/80 text-xs">Belum diajukan ke admin</p>
                        </div>
                    </div>
                </div>

                {{-- Action Card --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-6 border-b border-slate-100">
                        <h3 class="text-sm font-bold text-slate-800 mb-1">Aksi Dokumen</h3>
                        <p class="text-xs text-slate-500">Langkah sebelum mengajukan SKPI.</p>
                    </div>
                    
                    {{-- Steps Timeline --}}
                    <div class="px-6 py-6">
                        <ol class="relative border-l border-slate-200 space-y-6 ml-2">                  
                            <li class="ml-6">
                                <span class="absolute flex items-center justify-center w-6 h-6 bg-emerald-100 rounded-full -left-3 ring-4 ring-white">
                                    <x-heroicon-s-check class="w-3.5 h-3.5 text-emerald-600" />
                                </span>
                                <h3 class="flex items-center mb-1 text-sm font-semibold text-slate-900">Cek Data Profil</h3>
                                <p class="mb-2 text-xs font-normal text-slate-500">Pastikan Nama, NIM, dan TTL sesuai.</p>
                                <a href="{{ route('profile.edit') }}" class="inline-flex items-center text-xs font-medium text-blue-600 hover:underline">
                                    Edit Profil <x-heroicon-m-arrow-right class="w-3 h-3 ml-1" />
                                </a>
                            </li>
                            <li class="ml-6">
                                <span class="absolute flex items-center justify-center w-6 h-6 bg-emerald-100 rounded-full -left-3 ring-4 ring-white">
                                    <x-heroicon-s-check class="w-3.5 h-3.5 text-emerald-600" />
                                </span>
                                <h3 class="mb-1 text-sm font-semibold text-slate-900">Kelengkapan Portofolio</h3>
                                <p class="mb-2 text-xs font-normal text-slate-500">Hanya portofolio "Disetujui" yang akan tercetak.</p>
                                <a href="{{ route('student.portfolios.index') }}" class="inline-flex items-center text-xs font-medium text-blue-600 hover:underline">
                                    Lihat Portofolio <x-heroicon-m-arrow-right class="w-3 h-3 ml-1" />
                                </a>
                            </li>
                            <li class="ml-6">
                                <span class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -left-3 ring-4 ring-white">
                                    <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                                </span>
                                <h3 class="mb-1 text-sm font-semibold text-blue-700">Finalisasi & Ajukan</h3>
                                <p class="text-xs font-normal text-slate-500">Klik tombol di bawah jika data sudah benar.</p>
                            </li>
                        </ol>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="bg-slate-50 p-6 space-y-3 border-t border-slate-100">
                        <form method="POST" action="{{ route('student.skpi.apply') }}" 
                              onsubmit="return confirm('Apakah Anda yakin data sudah benar? Pengajuan tidak dapat dibatalkan.');">
                            @csrf
                            <button type="submit" 
                                    class="group w-full flex items-center justify-center gap-2 rounded-xl bg-[#1b3985] px-4 py-3 text-sm font-bold text-white shadow-lg shadow-blue-900/20 hover:bg-[#152e6b] hover:shadow-blue-900/30 hover:-translate-y-0.5 transition-all">
                                <x-heroicon-m-paper-airplane class="w-5 h-5 -rotate-45 group-hover:rotate-0 transition-transform duration-300" />
                                Ajukan SKPI Sekarang
                            </button>
                        </form>

                        <a href="{{ route('student.skpi.download') }}" target="_blank" 
                           class="w-full flex items-center justify-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm font-bold text-slate-700 shadow-sm hover:bg-slate-50 hover:text-slate-900 transition-all">
                            <x-heroicon-m-arrow-down-tray class="w-5 h-5" />
                            Unduh PDF (Draft)
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
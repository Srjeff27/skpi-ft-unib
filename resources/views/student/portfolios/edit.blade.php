<x-app-layout>
    @php
        $isLocked = !in_array($portfolio->status, ['pending', 'requires_revision']);
        $isRevision = $portfolio->status === 'requires_revision' && $portfolio->rejection_reason;
    @endphp

    <div class="max-w-4xl mx-auto space-y-8 pb-20">
        
        {{-- 1. Header Section --}}
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900 via-[#1b3985] to-[#2b50a8] shadow-xl">
            {{-- Decorative Background --}}
            <div class="absolute top-0 right-0 -mt-10 -mr-10 h-64 w-64 rounded-full bg-white/5 blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 h-40 w-40 rounded-full bg-blue-400/10 blur-2xl pointer-events-none"></div>
            
            <div class="relative z-10 p-6 sm:p-10 flex flex-col md:flex-row md:items-start md:justify-between gap-6">
                <div class="space-y-3">
                    <div class="flex items-center gap-3 text-blue-200 mb-1">
                        <a href="{{ route('student.portfolios.index') }}" class="hover:text-white transition-colors flex items-center gap-1 text-sm font-medium">
                            <x-heroicon-s-arrow-left class="w-4 h-4" />
                            Kembali
                        </a>
                        <span class="text-blue-200/50">&bull;</span>
                        <span class="text-xs uppercase tracking-wider font-bold bg-blue-900/40 px-2 py-1 rounded">ID: #{{ $portfolio->id }}</span>
                    </div>
                    <h1 class="text-3xl font-bold text-white tracking-tight">Edit Portofolio</h1>
                    <p class="text-blue-100/90 text-sm md:text-base max-w-2xl leading-relaxed">
                        Perbarui detail kegiatan atau prestasi Anda. Pastikan bukti pendukung valid dan dapat diverifikasi oleh tim akademik.
                    </p>
                </div>
            </div>
        </div>

        {{-- 2. Status & Alerts --}}
        <div class="space-y-4">
            {{-- Error Validation --}}
            @if ($errors->any())
                <div class="rounded-xl bg-rose-50 border-l-4 border-rose-500 p-4 shadow-sm animate-pulse-once">
                    <div class="flex items-start gap-3">
                        <x-heroicon-s-x-circle class="w-6 h-6 text-rose-500 shrink-0" />
                        <div>
                            <h3 class="text-sm font-bold text-rose-800">Terdapat Kesalahan Input</h3>
                            <ul class="mt-1 list-disc list-inside text-sm text-rose-700">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Locked Status --}}
            @if ($isLocked)
                <div class="rounded-xl bg-blue-50 border border-blue-100 p-5 shadow-sm">
                    <div class="flex items-start gap-4">
                        <div class="p-2 bg-blue-100 rounded-lg text-blue-600">
                            <x-heroicon-s-lock-closed class="w-6 h-6" />
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-800">Dokumen Terkunci</h3>
                            <p class="text-sm text-slate-600 mt-1 leading-relaxed">
                                Portofolio ini berstatus <span class="font-bold uppercase px-1.5 py-0.5 bg-slate-200 rounded text-slate-700 text-xs">{{ $portfolio->status }}</span>. 
                                Anda tidak dapat mengedit atau menghapus data yang sedang diproses atau sudah disetujui.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Revision Status --}}
            @if ($isRevision)
                <div class="rounded-xl bg-amber-50 border-l-4 border-amber-500 p-5 shadow-sm">
                    <div class="flex flex-col md:flex-row gap-5">
                        <div class="flex items-start gap-3 md:w-1/3">
                            <x-heroicon-s-exclamation-triangle class="w-6 h-6 text-amber-500 shrink-0" />
                            <div>
                                <h3 class="font-bold text-amber-900">Perlu Revisi</h3>
                                <p class="text-xs text-amber-700 mt-1">Silakan perbaiki data sesuai catatan verifikator.</p>
                            </div>
                        </div>
                        <div class="md:w-2/3 bg-white/60 rounded-lg border border-amber-200/50 p-3">
                            <p class="text-xs font-semibold text-amber-800 uppercase mb-1">Catatan Verifikator:</p>
                            <p class="text-sm text-slate-700 italic">"{{ $portfolio->rejection_reason }}"</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- 3. Form Card --}}
        <form method="POST" action="{{ route('student.portfolios.update', $portfolio) }}" enctype="multipart/form-data" class="block">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                {{-- Form Content --}}
                <div class="p-6 sm:p-10">
                    <div class="{{ $isLocked ? 'opacity-60 pointer-events-none grayscale-[0.5]' : '' }}">
                        @include('student.portfolios._form', ['portfolio' => $portfolio, 'categories' => $categories])
                    </div>
                </div>

                {{-- Footer Actions --}}
                <div class="bg-slate-50 px-6 py-5 sm:px-10 border-t border-slate-200 flex flex-col-reverse sm:flex-row sm:items-center justify-between gap-4">
                    
                    {{-- Left Action (Delete) --}}
                    @if(!$isLocked)
                        <div x-data="{ open: false }">
                            <button type="button" @click="open = true" class="w-full sm:w-auto inline-flex justify-center items-center gap-2 px-4 py-2.5 rounded-lg text-rose-600 hover:bg-rose-50 hover:text-rose-700 border border-transparent hover:border-rose-200 transition-all font-medium text-sm">
                                <x-heroicon-o-trash class="w-5 h-5" />
                                Hapus Data
                            </button>

                            {{-- Custom Delete Modal (Inline for portability) --}}
                            <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak>
                                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="open = false"></div>
                                <div class="relative bg-white rounded-xl shadow-2xl max-w-sm w-full p-6 text-center animate-fade-in-up">
                                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-rose-100 mb-4">
                                        <x-heroicon-o-exclamation-triangle class="h-6 w-6 text-rose-600" />
                                    </div>
                                    <h3 class="text-lg font-bold text-slate-900">Hapus Portofolio?</h3>
                                    <p class="text-sm text-slate-500 mt-2">Data yang dihapus tidak dapat dikembalikan lagi.</p>
                                    <div class="mt-6 flex gap-3 justify-center">
                                        <button type="button" @click="open = false" class="px-4 py-2 bg-white border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 font-medium text-sm">Batal</button>
                                        <button type="submit" form="delete-form" class="px-4 py-2 bg-rose-600 rounded-lg text-white hover:bg-rose-700 font-medium text-sm shadow-md">Ya, Hapus</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div></div>
                    @endif

                    {{-- Right Actions (Cancel & Save) --}}
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('student.portfolios.index') }}" class="w-full sm:w-auto inline-flex justify-center items-center px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-50 hover:text-slate-900 font-semibold text-sm transition-all shadow-sm">
                            Batal
                        </a>
                        
                        @if(!$isLocked)
                            <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center gap-2 px-6 py-2.5 rounded-lg bg-[#1b3985] text-white hover:bg-[#152e6b] font-semibold text-sm shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all focus:ring-4 focus:ring-blue-500/30">
                                <x-heroicon-m-check-circle class="w-5 h-5" />
                                Simpan Perubahan
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </form>

        {{-- Hidden Delete Form --}}
        @if(!$isLocked)
            <form id="delete-form" action="{{ route('student.portfolios.destroy', $portfolio) }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        @endif

    </div>
</x-app-layout>
<x-app-layout>
    <div class="space-y-8" x-data="{ showCreateModal: false }">
        
        {{-- Header Section --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-slate-900">Kurikulum & CPL</h2>
                <p class="mt-1 text-sm text-slate-500">Atur kurikulum dan petakan capaian pembelajaran lulusan.</p>
            </div>
        </div>

        @if (session('status'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
                 class="flex items-center gap-3 rounded-xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-emerald-700 shadow-sm">
                <x-heroicon-s-check-circle class="h-5 w-5" />
                <span class="text-sm font-medium">{{ session('status') }}</span>
            </div>
        @endif

        {{-- Filter & Toolbar --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-2 shadow-sm">
            <form method="GET" action="{{ route('admin.cpl.index') }}" class="flex flex-col gap-2 lg:flex-row lg:items-center">
                <div class="relative flex-grow">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <x-heroicon-o-building-library class="h-5 w-5 text-slate-400" />
                    </div>
                    <select name="prodi_id" id="prodi_id" onchange="this.form.submit()"
                            class="block w-full rounded-xl border-0 py-3 pl-10 pr-10 text-sm text-slate-900 ring-1 ring-inset ring-slate-200 focus:ring-2 focus:ring-inset focus:ring-[#1b3985]">
                        <option value="">-- Pilih Program Studi --</option>
                        @foreach ($prodis as $p)
                            <option value="{{ $p->id }}" @selected($selectedProdiId == $p->id)>
                                {{ $p->nama_prodi }} ({{ $p->jenjang }})
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <button type="button" @click="showCreateModal = true"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#1b3985] px-6 py-3 text-sm font-bold text-white shadow-lg shadow-blue-900/20 transition-all hover:bg-[#152c66] hover:shadow-blue-900/30 hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:transform-none"
                        :disabled="!{{ $selectedProdiId ? 'true' : 'false' }}">
                    <x-heroicon-m-plus class="h-5 w-5" />
                    <span>Kurikulum Baru</span>
                </button>
            </form>
        </div>

        {{-- Main Content Area --}}
        <div class="min-h-[400px]">
            @if ($selectedProdiId)
                @if ($curricula->count() > 0)
                    <div class="space-y-4">
                        <div class="flex items-center justify-between px-1">
                            <h3 class="font-bold text-slate-800">
                                Daftar Kurikulum <span class="font-normal text-slate-500">di {{ $selectedProdi->nama_prodi }}</span>
                            </h3>
                            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600">
                                {{ $curricula->count() }} Data
                            </span>
                        </div>

                        <div class="grid gap-4">
                            @foreach ($curricula as $curriculum)
                                {{-- Card Kurikulum (Removed overflow-hidden to prevent popup clipping if needed, but using direct actions is safer) --}}
                                <div class="group relative rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition-all hover:border-blue-200 hover:shadow-md">
                                    
                                    {{-- Active Indicator Strip --}}
                                    @if ($curriculum->is_active)
                                        <div class="absolute left-0 top-4 bottom-4 w-1 rounded-r-full bg-emerald-500"></div>
                                    @endif

                                    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center pl-3">
                                        {{-- Info --}}
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3">
                                                <h4 class="text-lg font-bold text-slate-800 group-hover:text-[#1b3985] transition-colors">
                                                    {{ $curriculum->name }}
                                                </h4>
                                                @if ($curriculum->is_active)
                                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                                        Aktif
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="mt-1 flex items-center gap-4 text-sm text-slate-500">
                                                <span class="flex items-center gap-1.5">
                                                    <x-heroicon-o-calendar class="h-4 w-4" />
                                                    Berlaku: {{ $curriculum->year ?? '-' }}
                                                </span>
                                            </div>
                                        </div>

                                        {{-- Actions (Direct Buttons) --}}
                                        <div class="flex items-center gap-2 border-t border-slate-100 pt-4 sm:border-t-0 sm:pt-0">
                                            <a href="{{ route('admin.cpl.manage', $curriculum) }}" 
                                               class="inline-flex items-center gap-2 rounded-lg bg-slate-50 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-[#1b3985] hover:text-white transition-colors mr-2">
                                                <x-heroicon-m-list-bullet class="h-4 w-4" />
                                                Kelola CPL
                                            </a>
                                            
                                            {{-- Edit Button --}}
                                            <a href="{{ route('admin.cpl.curricula.edit', $curriculum) }}" 
                                               class="rounded-lg p-2 text-slate-400 hover:bg-amber-50 hover:text-amber-600 transition-all"
                                               title="Edit Data">
                                                <x-heroicon-s-pencil-square class="h-5 w-5" />
                                            </a>

                                            {{-- Delete Button --}}
                                            <form action="{{ route('admin.cpl.curricula.destroy', $curriculum) }}" method="POST" 
                                                  onsubmit="return confirm('Hapus kurikulum ini? Semua CPL di dalamnya akan hilang.')"
                                                  class="inline-flex">
                                                @csrf @method('DELETE')
                                                <button type="submit" 
                                                        class="rounded-lg p-2 text-slate-400 hover:bg-rose-50 hover:text-rose-600 transition-all"
                                                        title="Hapus Permanen">
                                                    <x-heroicon-s-trash class="h-5 w-5" />
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    {{-- Empty State: No Curriculum --}}
                    <div class="flex flex-col items-center justify-center py-16 text-center rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50/50">
                        <div class="rounded-full bg-white p-4 shadow-sm ring-1 ring-slate-100 mb-4">
                            <x-heroicon-o-document-plus class="h-10 w-10 text-slate-400" />
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">Belum Ada Kurikulum</h3>
                        <p class="text-sm text-slate-500 mt-1 max-w-xs mx-auto">Prodi {{ $selectedProdi->nama_prodi }} belum memiliki data kurikulum.</p>
                        <button @click="showCreateModal = true" class="mt-6 text-sm font-bold text-[#1b3985] hover:underline">
                            Tambah Kurikulum Sekarang
                        </button>
                    </div>
                @endif
            @else
                {{-- Empty State: No Prodi Selected --}}
                <div class="flex flex-col items-center justify-center py-20 text-center">
                    <div class="rounded-full bg-blue-50 p-6 mb-4 animate-pulse">
                        <x-heroicon-o-cursor-arrow-rays class="h-12 w-12 text-[#1b3985]" />
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">Pilih Program Studi</h3>
                    <p class="text-slate-500 mt-2 max-w-md mx-auto">Silakan pilih program studi pada menu di atas untuk menampilkan dan mengelola data kurikulum.</p>
                </div>
            @endif
        </div>

        {{-- Modal Create --}}
        <div x-show="showCreateModal" style="display: none;"
             class="fixed inset-0 z-50 flex items-center justify-center px-4 sm:px-6" x-cloak>
            
            {{-- Backdrop --}}
            <div x-show="showCreateModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" 
                 @click="showCreateModal = false">
            </div>

            {{-- Modal Panel --}}
            <div x-show="showCreateModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-2xl ring-1 ring-black/5">
                
                <div class="bg-[#1b3985] px-6 py-4 text-white flex justify-between items-center">
                    <h3 class="text-lg font-bold">Tambah Kurikulum</h3>
                    <button @click="showCreateModal = false" class="text-white/70 hover:text-white transition-colors">
                        <x-heroicon-m-x-mark class="h-6 w-6" />
                    </button>
                </div>

                <form method="POST" action="{{ route('admin.cpl.curricula.store') }}" class="p-6 space-y-5">
                    @csrf
                    <input type="hidden" name="prodi_id" value="{{ $selectedProdiId }}">
                    
                    @if($selectedProdi)
                    <div class="rounded-lg bg-blue-50 p-3 text-xs text-blue-800 border border-blue-100 flex gap-2">
                        <x-heroicon-s-information-circle class="w-4 h-4 flex-shrink-0" />
                        Menambahkan untuk prodi: <span class="font-bold">{{ $selectedProdi->nama_prodi }}</span>
                    </div>
                    @endif

                    <div>
                        <x-input-label for="name" value="Nama Kurikulum" />
                        <div class="relative mt-1">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <x-heroicon-o-book-open class="h-5 w-5 text-slate-400" />
                            </div>
                            <x-text-input id="name" name="name" class="pl-10 block w-full rounded-xl" required placeholder="Contoh: Kurikulum 2024 - MBKM" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <div>
                            <x-input-label for="year" value="Tahun Berlaku" />
                            <div class="relative mt-1">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <x-heroicon-o-calendar class="h-5 w-5 text-slate-400" />
                                </div>
                                <x-text-input id="year" name="year" type="number" min="2000" max="2100" class="pl-10 block w-full rounded-xl" placeholder="2024" />
                            </div>
                        </div>
                        
                        <div class="flex items-end pb-1">
                            <label class="flex cursor-pointer items-center gap-3 rounded-xl border border-slate-200 p-3 w-full hover:bg-slate-50 transition-colors">
                                <input type="checkbox" name="is_active" value="1" class="h-5 w-5 rounded border-slate-300 text-[#1b3985] focus:ring-[#1b3985]">
                                <span class="text-sm font-medium text-slate-700">Set Aktif</span>
                            </label>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end gap-3 pt-2">
                        <button type="button" @click="showCreateModal = false" class="rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-[#1b3985] px-6 py-2.5 text-sm font-bold text-white shadow-md hover:bg-[#152c66] hover:shadow-lg transition-all">
                            Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
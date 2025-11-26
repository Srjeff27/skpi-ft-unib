<x-app-layout>
    <div class="space-y-8">
        
        {{-- Header Section --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-slate-900">Data Pejabat</h2>
                <p class="mt-1 text-sm text-slate-500">Kelola data penandatangan dokumen SKPI (Dekan/Wakil Dekan).</p>
            </div>
            <div>
                <a href="{{ route('admin.pejabat.create') }}" 
                   class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#1b3985] px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-blue-900/20 transition-all hover:bg-[#152c66] hover:shadow-blue-900/30 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <x-heroicon-m-plus class="h-5 w-5" />
                    <span>Tambah Pejabat</span>
                </a>
            </div>
        </div>

        @if (session('status'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
                 class="flex items-center gap-3 rounded-xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-emerald-700 shadow-sm">
                <x-heroicon-s-check-circle class="h-5 w-5" />
                <span class="text-sm font-medium">{{ session('status') }}</span>
            </div>
        @endif

        {{-- Search Toolbar --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-1 shadow-sm">
            <form method="GET" class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <x-heroicon-o-magnifying-glass class="h-5 w-5 text-slate-400" />
                </div>
                <input type="search" name="search" value="{{ request('search') }}" 
                       placeholder="Cari nama, NIP, atau jabatan..." 
                       class="block w-full rounded-xl border-0 py-2.5 pl-10 text-sm text-slate-900 ring-1 ring-inset ring-slate-200 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-[#1b3985]">
            </form>
        </div>

        {{-- Content List --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            @forelse ($officials as $official)
                <div class="group flex flex-col gap-4 border-b border-slate-100 p-4 last:border-0 hover:bg-slate-50/50 sm:flex-row sm:items-center sm:justify-between transition-colors">
                    
                    {{-- Info Utama --}}
                    <div class="flex items-center gap-4 sm:w-5/12">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-blue-50 text-[#1b3985] ring-1 ring-blue-100">
                            <x-heroicon-o-user class="h-6 w-6" />
                        </div>
                        <div class="min-w-0">
                            <p class="truncate text-sm font-bold text-slate-900">{{ $official->display_name }}</p>
                            <p class="truncate text-xs text-slate-500">{{ $official->jabatan }}</p>
                            <p class="truncate text-xs text-slate-400 font-mono mt-0.5">NIP: {{ $official->nip ?? '-' }}</p>
                        </div>
                    </div>

                    {{-- Signature & Status --}}
                    <div class="flex flex-1 flex-col gap-3 sm:grid sm:grid-cols-2 sm:items-center sm:gap-6">
                        {{-- Signature Preview --}}
                        <div class="flex items-center gap-2 sm:justify-center">
                            @if($official->signature_path)
                                <div class="h-10 px-2 bg-white border border-slate-100 rounded-md flex items-center justify-center">
                                    <img src="{{ asset('storage/'.$official->signature_path) }}" class="max-h-8 max-w-[100px] object-contain opacity-80 group-hover:opacity-100 transition-opacity" alt="TTD">
                                </div>
                            @else
                                <span class="text-xs text-slate-400 italic bg-slate-50 px-2 py-1 rounded">Tanpa TTD</span>
                            @endif
                        </div>

                        {{-- Status Badge --}}
                        <div class="flex items-center sm:justify-center">
                            @if($official->is_active)
                                <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                    <span class="mr-1.5 h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-600 ring-1 ring-inset ring-slate-500/10">
                                    Non-Aktif
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center justify-end gap-2 sm:w-auto border-t sm:border-t-0 pt-3 sm:pt-0 mt-2 sm:mt-0 border-slate-100">
                        <a href="{{ route('admin.pejabat.edit', $official) }}" 
                           class="rounded-lg p-2 text-slate-400 hover:bg-amber-50 hover:text-amber-600 transition-all"
                           title="Edit Data">
                            <x-heroicon-m-pencil-square class="h-5 w-5" />
                        </a>

                        <form action="{{ route('admin.pejabat.destroy', $official) }}" method="POST" 
                              onsubmit="return confirm('Hapus data pejabat ini? Pastikan tidak ada dokumen yang sedang menggunakan tanda tangan ini.')">
                            @csrf @method('DELETE')
                            <button type="submit" class="rounded-lg p-2 text-slate-400 hover:bg-rose-50 hover:text-rose-600 transition-all"
                                    title="Hapus Data">
                                <x-heroicon-m-trash class="h-5 w-5" />
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center py-16 text-center">
                    <div class="rounded-full bg-slate-50 p-4 ring-1 ring-slate-100">
                        <x-heroicon-o-user-circle class="h-10 w-10 text-slate-400" />
                    </div>
                    <h3 class="mt-4 text-sm font-semibold text-slate-900">Belum ada data pejabat</h3>
                    <p class="mt-1 text-sm text-slate-500">Tambahkan data pejabat struktural untuk keperluan validasi SKPI.</p>
                    <div class="mt-6">
                        <a href="{{ route('admin.pejabat.create') }}" class="text-sm font-medium text-[#1b3985] hover:underline">
                            Tambah Pejabat Baru &rarr;
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
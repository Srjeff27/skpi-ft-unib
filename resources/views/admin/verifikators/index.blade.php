<x-app-layout>
    <div class="space-y-8">
        
        {{-- Header Section --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-slate-900">Data Verifikator</h2>
                <p class="mt-1 text-sm text-slate-500">Kelola akses dosen verifikator untuk validasi portofolio.</p>
            </div>
            <div>
                <a href="{{ route('admin.verifikators.create') }}" 
                   class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#1b3985] px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-blue-900/20 transition-all hover:bg-[#152c66] hover:shadow-blue-900/30 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <x-heroicon-m-plus class="h-5 w-5" />
                    <span>Tambah Verifikator</span>
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

        {{-- Search & Filter Toolbar --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-1 shadow-sm">
            <form method="GET" class="flex flex-col gap-2 lg:flex-row">
                <div class="relative flex-1">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <x-heroicon-o-magnifying-glass class="h-5 w-5 text-slate-400" />
                    </div>
                    <input type="search" name="search" value="{{ request('search') }}" 
                           placeholder="Cari nama atau email..." 
                           class="block w-full rounded-xl border-0 py-2.5 pl-10 text-sm text-slate-900 ring-1 ring-inset ring-slate-200 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-[#1b3985]">
                </div>

                <div class="flex gap-2">
                    <select name="prodi_id" class="block w-full rounded-xl border-0 py-2.5 pl-3 pr-10 text-sm text-slate-900 ring-1 ring-inset ring-slate-200 focus:ring-2 focus:ring-inset focus:ring-[#1b3985] sm:w-48">
                        <option value="">Semua Prodi</option>
                        @foreach ($prodis as $p)
                            <option value="{{ $p->id }}" @selected(request('prodi_id') == $p->id)>{{ $p->nama_prodi }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-slate-100 px-4 py-2.5 text-slate-700 transition-colors hover:bg-slate-200 hover:text-slate-900">
                        <x-heroicon-m-funnel class="h-5 w-5" />
                    </button>
                </div>
            </form>
        </div>

        {{-- Content Table --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            @forelse ($verifikators as $verifier)
                <div class="group flex flex-col gap-4 border-b border-slate-100 p-4 last:border-0 hover:bg-slate-50/50 sm:flex-row sm:items-center sm:justify-between transition-colors">
                    
                    {{-- Profile Info --}}
                    <div class="flex items-center gap-4 sm:w-1/3">
                        <div class="relative h-12 w-12 shrink-0">
                            <img src="{{ $verifier->avatar_url }}" alt="{{ $verifier->name }}" class="h-full w-full rounded-full object-cover ring-2 ring-white shadow-sm">
                        </div>
                        <div class="min-w-0">
                            <p class="truncate text-sm font-bold text-slate-900">{{ $verifier->name }}</p>
                            <p class="truncate text-xs text-slate-500">{{ $verifier->email }}</p>
                        </div>
                    </div>

                    {{-- Academic Info (Prodi) --}}
                    <div class="flex flex-1 flex-col gap-2 sm:grid sm:grid-cols-2 sm:items-center sm:gap-4">
                        <div class="flex items-center gap-2 text-sm text-slate-600 sm:col-span-2 sm:justify-center">
                            @if(optional($verifier->prodi)->nama_prodi)
                                <span class="inline-flex items-center rounded-full bg-indigo-50 px-2.5 py-0.5 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-600/20">
                                    <x-heroicon-m-academic-cap class="mr-1 h-3 w-3" />
                                    {{ $verifier->prodi->nama_prodi }}
                                </span>
                            @else
                                <span class="text-xs text-slate-400 italic">- Belum set prodi -</span>
                            @endif
                        </div>
                    </div>

                    {{-- Actions (Direct Buttons) --}}
                    <div class="flex items-center justify-end gap-2 sm:w-auto border-t sm:border-t-0 pt-3 sm:pt-0 mt-2 sm:mt-0 border-slate-100">
                        {{-- Edit Button --}}
                        <a href="{{ route('admin.verifikators.edit', $verifier) }}" 
                           class="rounded-lg p-2 text-slate-400 hover:bg-amber-50 hover:text-amber-600 transition-all group/edit"
                           title="Edit Data">
                            <x-heroicon-m-pencil-square class="h-5 w-5" />
                        </a>

                        {{-- Delete Button --}}
                        <form action="{{ route('admin.verifikators.destroy', $verifier) }}" method="POST" 
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus verifikator ini?')"
                              class="inline-flex">
                            @csrf @method('DELETE')
                            <button type="submit" class="rounded-lg p-2 text-slate-400 hover:bg-rose-50 hover:text-rose-600 transition-all group/delete"
                                    title="Hapus Permanen">
                                <x-heroicon-m-trash class="h-5 w-5" />
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center py-16 text-center">
                    <div class="rounded-full bg-slate-50 p-4 ring-1 ring-slate-100">
                        <x-heroicon-o-user-group class="h-10 w-10 text-slate-400" />
                    </div>
                    <h3 class="mt-4 text-sm font-semibold text-slate-900">Belum ada verifikator</h3>
                    <p class="mt-1 text-sm text-slate-500">Silakan tambahkan data verifikator baru.</p>
                    <div class="mt-6">
                        <a href="{{ route('admin.verifikators.create') }}" class="text-sm font-medium text-[#1b3985] hover:underline">
                            Tambah Verifikator &rarr;
                        </a>
                    </div>
                </div>
            @endforelse

            @if ($verifikators->hasPages())
                <div class="bg-slate-50 border-t border-slate-200 px-4 py-3 sm:px-6">
                    {{ $verifikators->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <div class="space-y-8" 
         x-data="{ 
            selected: [], 
            allIds: {{ json_encode($students->pluck('id')) }},
            toggleAll() {
                this.selected = this.selected.length === this.allIds.length ? [] : [...this.allIds];
            }
         }">
        
        {{-- Header Section --}}
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-slate-900">Pencetakan Dokumen SKPI</h2>
                <p class="mt-1 text-sm text-slate-500">Kelola dan cetak Surat Keterangan Pendamping Ijazah untuk lulusan.</p>
            </div>
        </div>

        @if (session('status'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
                 class="flex items-center gap-3 rounded-xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-emerald-700 shadow-sm">
                <x-heroicon-s-check-circle class="h-5 w-5" />
                <span class="text-sm font-medium">{{ session('status') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="flex items-center gap-3 rounded-xl border border-rose-100 bg-rose-50 px-4 py-3 text-rose-700 shadow-sm">
                <x-heroicon-s-x-circle class="h-5 w-5" />
                <span class="text-sm font-medium">{{ $errors->first() }}</span>
            </div>
        @endif

        {{-- Search & Filter Toolbar --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-1 shadow-sm">
            <form method="GET" class="flex flex-col gap-2 lg:flex-row">
                <div class="relative flex-grow">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <x-heroicon-o-magnifying-glass class="h-5 w-5 text-slate-400" />
                    </div>
                    <input type="search" name="q" value="{{ request('q') }}" 
                           placeholder="Cari Nama atau NIM..." 
                           class="block w-full rounded-xl border-0 py-2.5 pl-10 text-sm text-slate-900 ring-1 ring-inset ring-slate-200 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-[#1b3985]">
                </div>

                <div class="flex gap-2 overflow-x-auto pb-2 lg:pb-0">
                    <select name="periode" class="block w-full rounded-xl border-0 py-2.5 pl-3 pr-10 text-sm text-slate-900 ring-1 ring-inset ring-slate-200 focus:ring-2 focus:ring-inset focus:ring-[#1b3985] sm:w-48">
                        <option value="">Semua Periode</option>
                        @foreach ($periods as $p)
                            <option value="{{ $p }}" @selected(request('periode') === $p)>
                                {{ \Carbon\Carbon::createFromFormat('Y-m', $p)->translatedFormat('M Y') }}
                            </option>
                        @endforeach
                    </select>

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

        {{-- Main Content List --}}
        <form method="POST" action="{{ route('admin.cetak_skpi.print_bulk') }}" class="space-y-4">
            @csrf
            
            {{-- Bulk Action Bar --}}
            <div class="sticky top-20 z-20 flex items-center justify-between rounded-xl border border-slate-200 bg-white/80 px-4 py-3 shadow-sm backdrop-blur-md transition-all"
                 :class="selected.length > 0 ? 'border-blue-200 bg-blue-50/90' : ''">
                <div class="flex items-center gap-3">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" @click="toggleAll()" 
                               :checked="selected.length > 0 && selected.length === allIds.length"
                               class="h-5 w-5 rounded border-slate-300 text-[#1b3985] focus:ring-[#1b3985]">
                        <span class="text-sm font-semibold text-slate-700" x-text="selected.length > 0 ? selected.length + ' Dipilih' : 'Pilih Semua'"></span>
                    </label>
                </div>
                
                <button type="submit" :disabled="selected.length === 0"
                        class="inline-flex items-center gap-2 rounded-lg bg-[#1b3985] px-4 py-2 text-sm font-bold text-white shadow-md transition-all hover:bg-[#152c66] hover:shadow-lg disabled:cursor-not-allowed disabled:opacity-50 disabled:shadow-none">
                    <x-heroicon-m-printer class="h-4 w-4" />
                    Cetak Batch
                </button>
            </div>

            {{-- Student List --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                @if ($students->count() > 0)
                    <div class="divide-y divide-slate-100">
                        @foreach ($students as $student)
                            <div class="group flex flex-col gap-4 p-4 transition-colors hover:bg-slate-50 sm:flex-row sm:items-center">
                                
                                {{-- Checkbox & Avatar --}}
                                <div class="flex items-center gap-4">
                                    <input type="checkbox" name="selected[]" value="{{ $student->id }}" x-model="selected" 
                                           class="h-5 w-5 rounded border-slate-300 text-[#1b3985] focus:ring-[#1b3985]">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-slate-100 text-slate-500 font-bold text-sm">
                                        {{ substr($student->name, 0, 2) }}
                                    </div>
                                </div>

                                {{-- Info --}}
                                <div class="min-w-0 flex-1">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                        <div>
                                            <p class="truncate text-sm font-bold text-slate-900">{{ $student->name }}</p>
                                            <p class="truncate text-xs text-slate-500">{{ $student->nim }} &bull; {{ optional($student->prodi)->nama_prodi }}</p>
                                        </div>
                                        
                                        {{-- Status & Date --}}
                                        <div class="flex items-center gap-3">
                                            <div class="text-right hidden sm:block">
                                                <p class="text-xs text-slate-400">Tgl Lulus</p>
                                                <p class="text-xs font-medium text-slate-700">
                                                    {{ \Carbon\Carbon::parse($student->tanggal_lulus)->isoFormat('D MMM Y') }}
                                                </p>
                                            </div>
                                            
                                            @if($student->nomor_skpi)
                                                <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                                    Tercetak
                                                </span>
                                            @else
                                                <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-600 ring-1 ring-inset ring-slate-500/10">
                                                    Pending
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Actions --}}
                                <div class="flex items-center gap-2 border-t border-slate-100 pt-3 sm:border-t-0 sm:pt-0 sm:ml-4">
                                    <a href="{{ route('admin.cetak_skpi.preview', $student) }}" target="_blank" 
                                       class="rounded-lg p-2 text-slate-400 hover:bg-blue-50 hover:text-blue-600 transition-all" 
                                       title="Pratinjau">
                                        <x-heroicon-m-eye class="h-5 w-5" />
                                    </a>
                                    <a href="{{ route('admin.cetak_skpi.print_single', $student) }}" 
                                       class="rounded-lg p-2 text-slate-400 hover:bg-emerald-50 hover:text-emerald-600 transition-all" 
                                       title="Cetak Satuan">
                                        <x-heroicon-m-printer class="h-5 w-5" />
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    @if ($students->hasPages())
                        <div class="border-t border-slate-200 bg-slate-50 px-4 py-3">
                            {{ $students->links() }}
                        </div>
                    @endif
                @else
                    {{-- Empty State --}}
                    <div class="flex flex-col items-center justify-center py-16 text-center">
                        <div class="rounded-full bg-slate-50 p-4 ring-1 ring-slate-100 mb-3">
                            <x-heroicon-o-users class="h-10 w-10 text-slate-400" />
                        </div>
                        <h3 class="text-sm font-semibold text-slate-900">Tidak ada data mahasiswa</h3>
                        <p class="text-xs text-slate-500 mt-1 max-w-xs">Coba ubah filter pencarian atau pastikan data kelulusan sudah diinput.</p>
                    </div>
                @endif
            </div>
        </form>
    </div>
</x-app-layout>
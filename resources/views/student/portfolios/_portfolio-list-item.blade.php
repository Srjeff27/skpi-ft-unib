@php
    $p = $portfolio;

    // Konfigurasi Tampilan Berdasarkan Status
    $config = match($p->status) {
        'verified' => [
            'label' => 'Disetujui',
            'color' => 'emerald',
            'icon' => 'heroicon-s-check-badge',
            'bg' => 'bg-emerald-50',
            'text' => 'text-emerald-700',
            'border' => 'border-emerald-500',
            'ring' => 'ring-emerald-600/10'
        ],
        'rejected' => [
            'label' => 'Ditolak',
            'color' => 'rose',
            'icon' => 'heroicon-s-x-circle',
            'bg' => 'bg-rose-50',
            'text' => 'text-rose-700',
            'border' => 'border-rose-500',
            'ring' => 'ring-rose-600/10'
        ],
        'requires_revision' => [
            'label' => 'Perlu Revisi',
            'color' => 'orange',
            'icon' => 'heroicon-s-pencil-square',
            'bg' => 'bg-orange-50',
            'text' => 'text-orange-700',
            'border' => 'border-orange-500',
            'ring' => 'ring-orange-600/10'
        ],
        default => [ // pending
            'label' => 'Menunggu',
            'color' => 'blue',
            'icon' => 'heroicon-s-clock',
            'bg' => 'bg-blue-50',
            'text' => 'text-blue-700',
            'border' => 'border-blue-500',
            'ring' => 'ring-blue-600/10'
        ],
    };
@endphp

<div x-data="{ openMenu: false }"
     class="group relative flex flex-col h-full bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 transition-all duration-300 hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:-translate-y-1 overflow-hidden">
    
    {{-- Color Accent Top Border --}}
    <div class="absolute top-0 left-0 right-0 h-1.5 {{ 'bg-' . $config['color'] . '-500' }}"></div>

    <div class="p-5 flex flex-col h-full">
        {{-- Header: Kategori & Menu --}}
        <div class="flex justify-between items-start mb-4">
            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-slate-100 text-slate-600 tracking-wide uppercase">
                {{ $p->kategori_portfolio }}
            </span>

            {{-- Dropdown Menu --}}
            <div class="relative">
                <button @click.prevent="openMenu = !openMenu" @click.away="openMenu = false"
                        class="p-1 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors focus:outline-none">
                    <x-heroicon-m-ellipsis-horizontal class="h-6 w-6" />
                </button>

                <div x-show="openMenu" 
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="absolute right-0 mt-2 w-48 origin-top-right rounded-xl bg-white shadow-xl ring-1 ring-black/5 focus:outline-none z-20 divide-y divide-slate-100"
                     style="display: none;">
                    
                    <div class="py-1">
                        <a href="{{ $p->link_sertifikat }}" target="_blank"
                           class="group flex items-center px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 hover:text-[#1b3985]">
                            <x-heroicon-s-eye class="mr-3 h-4 w-4 text-slate-400 group-hover:text-[#1b3985]" />
                            Lihat Bukti
                        </a>
                    </div>

                    @if ($p->status === 'pending' || $p->status === 'requires_revision')
                        <div class="py-1">
                            <a href="{{ route('student.portfolios.edit', $p) }}"
                               class="group flex items-center px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 hover:text-amber-600">
                                <x-heroicon-s-pencil-square class="mr-3 h-4 w-4 text-slate-400 group-hover:text-amber-600" />
                                Edit Data
                            </a>
                            <x-confirm :action="route('student.portfolios.destroy', $p)" method="DELETE" type="error"
                                       title="Hapus Portofolio"
                                       message="Apakah Anda yakin? Data yang dihapus tidak dapat dikembalikan.">
                                <x-slot name="trigger">
                                    <button type="button" class="group flex w-full items-center px-4 py-2.5 text-sm text-red-600 hover:bg-red-50">
                                        <x-heroicon-s-trash class="mr-3 h-4 w-4 text-red-400 group-hover:text-red-600" />
                                        Hapus
                                    </button>
                                </x-slot>
                            </x-confirm>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Body: Judul & Link --}}
        <div class="flex-grow mb-4">
            <h3 class="text-lg font-bold text-slate-800 leading-snug group-hover:text-[#1b3985] transition-colors line-clamp-2">
                <a href="{{ route('student.portfolios.edit', $p) }}" class="focus:outline-none">
                    <span class="absolute inset-0" aria-hidden="true"></span>
                    {{ $p->nama_dokumen_id }}
                </a>
            </h3>
        </div>

        {{-- Footer: Status Badge & Tanggal --}}
        <div class="flex items-center justify-between pt-4 border-t border-slate-100 mt-auto">
            {{-- Status Badge --}}
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold {{ $config['bg'] }} {{ $config['text'] }} ring-1 ring-inset {{ $config['ring'] }}">
                    <x-dynamic-component :component="$config['icon']" class="h-3.5 w-3.5" />
                    {{ $config['label'] }}
                </span>

                {{-- Info Tooltip (Jika Ditolak/Revisi) --}}
                @if (($p->status === 'rejected' || $p->status === 'requires_revision') && $p->rejection_reason)
                    <div x-data="{ tooltip: false }" class="relative z-10">
                        <button @mouseenter="tooltip = true" @mouseleave="tooltip = false" @focus="tooltip = true" @blur="tooltip = false"
                                class="text-slate-400 hover:text-rose-500 transition-colors focus:outline-none">
                            <x-heroicon-m-information-circle class="h-5 w-5" />
                        </button>
                        <div x-show="tooltip"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-1"
                             class="absolute bottom-full left-0 mb-2 w-64 p-3 bg-slate-800 text-white text-xs rounded-lg shadow-xl z-50"
                             style="display: none;">
                            <p class="font-bold text-rose-300 mb-1">Catatan Validator:</p>
                            <p class="leading-relaxed">{{ $p->rejection_reason }}</p>
                            <div class="absolute -bottom-1 left-2 h-2 w-2 rotate-45 bg-slate-800"></div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Tanggal --}}
            <div class="flex items-center text-xs font-medium text-slate-400">
                <x-heroicon-m-calendar class="mr-1.5 h-3.5 w-3.5" />
                {{ \Carbon\Carbon::parse($p->tanggal_dokumen)->isoFormat('D MMM YYYY') }}
            </div>
        </div>
    </div>
</div>
@php
    $p = $portfolio;
    
    // Konfigurasi Status dengan Style Tailwind Modern
    $statusConfig = [
        'pending' => [
            'label' => 'Menunggu',
            'style' => 'bg-yellow-50 text-yellow-700 ring-yellow-600/20',
            'icon'  => 'heroicon-m-clock'
        ],
        'verified' => [
            'label' => 'Disetujui',
            'style' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
            'icon'  => 'heroicon-m-check-badge'
        ],
        'rejected' => [
            'label' => 'Ditolak',
            'style' => 'bg-rose-50 text-rose-700 ring-rose-600/20',
            'icon'  => 'heroicon-m-x-circle'
        ],
        'requires_revision' => [
            'label' => 'Perlu Revisi',
            'style' => 'bg-orange-50 text-orange-700 ring-orange-600/20',
            'icon'  => 'heroicon-m-pencil-square'
        ],
    ];

    // Default fallback jika status tidak dikenal
    $currentStatus = $statusConfig[$p->status] ?? [
        'label' => 'N/A', 
        'style' => 'bg-gray-50 text-gray-600 ring-gray-500/20', 
        'icon' => 'heroicon-m-question-mark-circle'
    ];
@endphp

<div class="group relative flex flex-col gap-4 rounded-xl border border-gray-200 bg-white p-5 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:border-[#1b3985]/30 hover:shadow-md sm:flex-row sm:items-center sm:justify-between">
    
    {{-- BAGIAN KIRI: Ikon & Informasi Utama --}}
    <div class="flex items-start gap-4">
        {{-- Ikon Dekoratif (Hanya tampil di Tablet/Desktop) --}}
        <div class="hidden shrink-0 rounded-lg bg-blue-50 p-3 text-[#1b3985] sm:block ring-1 ring-blue-100">
            <x-heroicon-o-document-text class="h-6 w-6" />
        </div>

        <div class="min-w-0 flex-1 space-y-1.5">
            {{-- Metadata: Kategori & Tanggal --}}
            <div class="flex flex-wrap items-center gap-2 text-xs font-medium text-gray-500">
                <span class="inline-flex items-center rounded-md bg-gray-100 px-2 py-0.5 text-gray-600 uppercase tracking-wider text-[10px]">
                    {{ $p->kategori_portfolio }}
                </span>
                <span class="hidden sm:inline text-gray-300">&bull;</span>
                <span class="flex items-center gap-1 text-gray-400">
                    <x-heroicon-m-calendar class="h-3.5 w-3.5" />
                    {{ \Carbon\Carbon::parse($p->tanggal_dokumen)->isoFormat('D MMM YYYY') }}
                </span>
            </div>

            {{-- Judul Dokumen --}}
            <h3 class="font-bold text-gray-900 leading-snug transition-colors group-hover:text-[#1b3985]">
                <a href="{{ route('student.portfolios.edit', $p) }}" class="focus:outline-none">
                    <span class="absolute inset-0 sm:hidden" aria-hidden="true"></span> {{-- Full card click di mobile --}}
                    {{ Str::limit($p->nama_dokumen_id, 65) }}
                </a>
            </h3>
        </div>
    </div>

    {{-- BAGIAN KANAN: Status & Aksi --}}
    <div class="flex items-center justify-between gap-4 sm:justify-end border-t border-gray-100 pt-3 sm:border-0 sm:pt-0">
        
        {{-- Status Badge --}}
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset {{ $currentStatus['style'] }}">
                <x-dynamic-component :component="$currentStatus['icon']" class="h-3.5 w-3.5" />
                {{ $currentStatus['label'] }}
            </span>

            {{-- Tooltip Alasan Penolakan --}}
            @if (($p->status === 'rejected' || $p->status === 'requires_revision') && $p->rejection_reason)
                <div x-data="{ tooltip: false }" class="relative z-20">
                    <button @mouseenter="tooltip = true" @mouseleave="tooltip = false" class="text-gray-400 hover:text-red-500 transition-colors focus:outline-none">
                        <x-heroicon-m-information-circle class="h-5 w-5" />
                    </button>
                    <div x-show="tooltip" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-1"
                         class="absolute bottom-full right-0 sm:left-1/2 sm:-translate-x-1/2 z-50 mb-2 w-64 rounded-lg bg-gray-900 p-3 text-xs text-white shadow-xl"
                         style="display: none;">
                        <p class="font-bold text-red-300 mb-1">Catatan Validator:</p>
                        <p class="leading-relaxed">{{ $p->rejection_reason }}</p>
                        {{-- Panah Tooltip --}}
                        <div class="absolute -bottom-1 right-4 sm:left-1/2 sm:-translate-x-1/2 h-2 w-2 rotate-45 bg-gray-900"></div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Menu Dropdown (Posisi tetap relatif terhadap parent button) --}}
        <div class="relative z-10" x-data="{ open: false }">
            <button @click="open = !open" @click.away="open = false" class="rounded-full p-1.5 text-gray-400 hover:bg-gray-100 hover:text-[#1b3985] transition-colors focus:outline-none focus:ring-2 focus:ring-[#1b3985] focus:ring-offset-2">
                <x-heroicon-m-ellipsis-vertical class="h-5 w-5" />
            </button>

            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute right-0 top-full mt-1 w-48 origin-top-right rounded-lg bg-white shadow-lg ring-1 ring-black/5 focus:outline-none divide-y divide-gray-100 z-30"
                 style="display: none;">
                
                <div class="py-1">
                    <a href="{{ $p->link_sertifikat }}" target="_blank" class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#1b3985]">
                        <x-heroicon-s-eye class="mr-3 h-4 w-4 text-gray-400 group-hover:text-[#1b3985]" />
                        Lihat Bukti
                    </a>
                </div>

                @if ($p->status === 'pending' || $p->status === 'requires_revision')
                    <div class="py-1">
                        <a href="{{ route('student.portfolios.edit', $p) }}" class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-amber-600">
                            <x-heroicon-s-pencil-square class="mr-3 h-4 w-4 text-gray-400 group-hover:text-amber-500" />
                            Edit Data
                        </a>
                        
                        <x-confirm :action="route('student.portfolios.destroy', $p)" method="DELETE" type="error" title="Hapus Portofolio" message="Apakah Anda yakin ingin menghapus portofolio ini? Tindakan ini tidak dapat dibatalkan.">
                            <x-slot name="trigger">
                                <button type="button" class="group flex w-full items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50">
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
</div>
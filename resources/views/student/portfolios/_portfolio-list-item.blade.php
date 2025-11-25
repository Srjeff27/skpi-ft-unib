@php
    $p = $portfolio;
    $statusConfig = [
        'pending' => [
            'label' => 'Menunggu',
            'style' => 'bg-yellow-100 text-yellow-800',
            'icon' => 'heroicon-m-clock',
        ],
        'verified' => [
            'label' => 'Disetujui',
            'style' => 'bg-emerald-100 text-emerald-800',
            'icon' => 'heroicon-m-check-badge',
        ],
        'rejected' => [
            'label' => 'Ditolak',
            'style' => 'bg-rose-100 text-rose-800',
            'icon' => 'heroicon-m-x-circle',
        ],
        'requires_revision' => [
            'label' => 'Perlu Revisi',
            'style' => 'bg-orange-100 text-orange-800',
            'icon' => 'heroicon-m-pencil-square',
        ],
    ];
    $currentStatus = $statusConfig[$p->status] ?? [
        'label' => 'N/A',
        'style' => 'bg-gray-100 text-gray-800',
        'icon' => 'heroicon-m-question-mark-circle',
    ];
@endphp

<div x-data="{ openMenu: false }"
    class="relative group bg-white rounded-xl shadow-sm border border-gray-200/80 h-full flex flex-col transition-all duration-300 hover:shadow-lg hover:border-[#1b3985]/30">

    {{-- Header Kartu --}}
    <div class="flex items-start justify-between p-5 border-b border-gray-100">
        <div class="flex-1 min-w-0">
            <h3 class="text-base font-bold text-gray-800 group-hover:text-[#1b3985] transition-colors leading-tight">
                <a href="{{ route('student.portfolios.edit', $p) }}" class="focus:outline-none">
                    <span class="absolute inset-0" aria-hidden="true"></span>
                    {{ $p->nama_dokumen_id }}
                </a>
            </h3>
        </div>

        {{-- Menu Aksi --}}
        <div class="relative z-10">
            <button @click.prevent="openMenu = !openMenu" @click.away="openMenu = false"
                class="p-1.5 rounded-full text-gray-400 hover:bg-gray-100 hover:text-[#1b3985] transition-colors focus:outline-none focus:ring-2 focus:ring-[#1b3985] focus:ring-offset-2">
                <x-heroicon-m-ellipsis-vertical class="h-5 w-5" />
            </button>
            <div x-show="openMenu" x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute right-0 mt-1 w-48 origin-top-right rounded-xl bg-white shadow-lg ring-1 ring-black/5 focus:outline-none divide-y divide-gray-100 z-30"
                style="display: none;">
                <div class="py-1">
                    <a href="{{ $p->link_sertifikat }}" target="_blank"
                        class="group flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#1b3985]">
                        <x-heroicon-s-eye class="mr-3 h-4 w-4 text-gray-400 group-hover:text-[#1b3985]" />
                        Lihat Bukti
                    </a>
                </div>
                @if ($p->status === 'pending' || $p->status === 'requires_revision')
                    <div class="py-1">
                        <a href="{{ route('student.portfolios.edit', $p) }}"
                            class="group flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-amber-600">
                            <x-heroicon-s-pencil-square class="mr-3 h-4 w-4 text-gray-400 group-hover:text-amber-500" />
                            Edit Data
                        </a>
                        <x-confirm :action="route('student.portfolios.destroy', $p)" method="DELETE" type="error"
                            title="Hapus Portofolio"
                            message="Apakah Anda yakin ingin menghapus portofolio ini? Tindakan ini tidak dapat dibatalkan.">
                            <x-slot name="trigger">
                                <button type="button"
                                    class="group flex w-full items-center px-4 py-2.5 text-sm text-red-600 hover:bg-red-50">
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

    {{-- Body Konten --}}
    <div class="p-5 flex-grow space-y-3">
        <div class="flex items-center gap-2">
            <x-heroicon-o-tag class="h-4 w-4 text-gray-400" />
            <span class="text-xs font-medium text-gray-600 bg-gray-100 px-2 py-1 rounded-md">
                {{ $p->kategori_portfolio }}
            </span>
        </div>
        <div class="flex items-center gap-2">
            <x-heroicon-o-calendar class="h-4 w-4 text-gray-400" />
            <span class="text-sm text-gray-500">
                {{ \Carbon\Carbon::parse($p->tanggal_dokumen)->isoFormat('D MMMM YYYY') }}
            </span>
        </div>
    </div>

    {{-- Footer Kartu --}}
    <div class="px-5 py-4 bg-gray-50/70 rounded-b-xl border-t border-gray-100">
        <div class="flex items-center justify-between">
            <span
                class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold {{ $currentStatus['style'] }}">
                <x-dynamic-component :component="$currentStatus['icon']" class="h-4 w-4" />
                {{ $currentStatus['label'] }}
            </span>

            @if (($p->status === 'rejected' || $p->status === 'requires_revision') && $p->rejection_reason)
                <div x-data="{ tooltip: false }" class="relative z-20">
                    <button @mouseenter="tooltip = true" @mouseleave="tooltip = false"
                        class="text-gray-400 hover:text-red-500 transition-colors focus:outline-none">
                        <x-heroicon-m-information-circle class="h-5 w-5" />
                    </button>
                    <div x-show="tooltip"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-1"
                        class="absolute bottom-full right-0 z-30 mb-2 w-64 rounded-lg bg-gray-900 p-3 text-sm text-white shadow-xl"
                        style="display: none;">
                        <p class="font-bold text-red-300 mb-1">Catatan Validator:</p>
                        <p class="leading-relaxed">{{ $p->rejection_reason }}</p>
                        <div class="absolute -bottom-1 right-4 h-2 w-2 rotate-45 bg-gray-900"></div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

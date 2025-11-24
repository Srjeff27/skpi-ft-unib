@php
    $p = $portfolio; // Alias for brevity
    $statusConfig = [
        'pending' => ['color' => 'yellow', 'text' => 'Menunggu'],
        'verified' => ['color' => 'green', 'text' => 'Disetujui'],
        'rejected' => ['color' => 'red', 'text' => 'Ditolak'],
        'requires_revision' => ['color' => 'orange', 'text' => 'Perbaikan'],
    ];
    $currentStatus = $statusConfig[$p->status] ?? ['color' => 'gray', 'text' => 'N/A'];
    $colors = [
        'yellow' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800'],
        'green' => ['bg' => 'bg-green-100', 'text' => 'text-green-800'],
        'red' => ['bg' => 'bg-red-100', 'text' => 'text-red-800'],
        'orange' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-800'],
        'gray' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800'],
    ];
    $statusColorClasses = $colors[$currentStatus['color']];
@endphp

<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div class="flex-1 min-w-0">
        <a href="{{ route('student.portfolios.edit', $p) }}" class="font-bold text-gray-800 hover:text-[#1b3985] transition-colors truncate block">{{ Str::limit($p->judul_kegiatan, 50) }}</a>
        <p class="text-sm text-gray-500 mt-1">{{ $p->kategori_portfolio }}</p>
    </div>

    <div class="flex items-center gap-6 md:gap-8 text-sm">
        <div class="flex-shrink-0">
            <p class="text-xs text-gray-400 md:hidden">Tanggal</p>
            <p class="font-medium text-gray-700">{{ \Carbon\Carbon::parse($p->tanggal_dokumen)->isoFormat('D MMM YYYY') }}</p>
        </div>
        <div class="flex-shrink-0">
            <p class="text-xs text-gray-400 md:hidden">Status</p>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusColorClasses['bg'] }} {{ $statusColorClasses['text'] }}">{{ $currentStatus['text'] }}</span>
                @if (($p->status === 'rejected' || $p->status === 'requires_revision') && $p->rejection_reason)
                    <div x-data="{ tooltip: false }" class="relative">
                        <svg @mouseenter="tooltip = true" @mouseleave="tooltip = false" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 cursor-pointer" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" /></svg>
                        <div x-show="tooltip" class="absolute z-10 bottom-full -translate-x-1/2 left-1/2 mb-2 w-60 p-2 text-xs text-white bg-gray-900 rounded-md shadow-lg" x-cloak>
                            <span class="font-semibold">Catatan:</span> {{ $p->rejection_reason }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="md:ml-auto flex-shrink-0" x-data="{ open: false }">
        <div class="relative">
            <button @click="open = !open" @click.away="open = false" class="p-2 rounded-full text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition-colors focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" /></svg>
            </button>
            <div x-show="open" x-transition x-cloak
                 class="absolute top-full right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border z-10">
                <a href="{{ $p->link_sertifikat }}" target="_blank" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"><path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z" /><path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z" /></svg>
                    Lihat Bukti
                </a>
                @if ($p->status === 'pending' || $p->status === 'requires_revision')
                    <a href="{{ route('student.portfolios.edit', $p) }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" /><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" /></svg>
                        Edit
                    </a>
                    <x-confirm :action="route('student.portfolios.destroy', $p)" method="DELETE" type="error" title="Hapus Portofolio" message="Anda yakin ingin menghapus portofolio ini?">
                        <x-slot name="trigger">
                            <button type="button" class="flex items-center gap-3 w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                                Hapus
                            </button>
                        </x-slot>
                    </x-confirm>
                @endif
            </div>
        </div>
    </div>
</div>

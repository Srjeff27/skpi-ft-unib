@php
    $p = $portfolio; // Menggunakan variabel $p agar lebih singkat
    $statusConfig = [
        'pending' => ['color' => 'bg-yellow-100 text-yellow-800', 'text' => 'Menunggu'],
        'verified' => ['color' => 'bg-green-100 text-green-800', 'text' => 'Disetujui'],
        'rejected' => ['color' => 'bg-red-100 text-red-800', 'text' => 'Ditolak'],
        'requires_revision' => ['color' => 'bg-orange-100 text-orange-800', 'text' => 'Perbaikan'],
    ];
    $currentStatus = $statusConfig[$p->status] ?? ['color' => 'bg-gray-100 text-gray-800', 'text' => 'N/A'];
@endphp

<tr>
    <td class="p-4 align-top">
        <div class="font-bold text-gray-800">{{ Str::limit($p->judul_kegiatan, 45) }}</div>
        <div class="text-gray-500">{{ $p->penyelenggara }}</div>
    </td>
    <td class="p-4 align-top">{{ $p->kategori_portfolio }}</td>
    <td class="p-4 align-top whitespace-nowrap">{{ \Carbon\Carbon::parse($p->tanggal_dokumen)->isoFormat('D MMM YYYY') }}</td>
    <td class="p-4 align-top">
        <div class="flex items-center gap-2">
            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $currentStatus['color'] }}">{{ $currentStatus['text'] }}</span>
            @if (($p->status === 'rejected' || $p->status === 'requires_revision') && $p->rejection_reason)
                <div x-data="{ tooltip: false }" class="relative">
                    <x-heroicon-s-information-circle @mouseenter="tooltip = true" @mouseleave="tooltip = false" class="w-5 h-5 text-gray-400 cursor-pointer" />
                    <div x-show="tooltip" class="absolute z-10 bottom-full mb-2 w-60 p-2 text-xs text-white bg-gray-800 rounded-md shadow-lg" x-cloak>
                        {{ $p->rejection_reason }}
                    </div>
                </div>
            @endif
        </div>
    </td>
    <td class="p-4 align-top text-right whitespace-nowrap">
        <div class="flex items-center justify-end gap-4 font-semibold">
            <a href="{{ $p->link_sertifikat }}" target="_blank" class="text-blue-600 hover:underline">
                Lihat Bukti
            </a>
            @if ($p->status === 'pending' || $p->status === 'requires_revision')
                <a href="{{ route('student.portfolios.edit', $p) }}" class="text-indigo-600 hover:underline">
                    Edit
                </a>
                <x-confirm :action="route('student.portfolios.destroy', $p)" method="DELETE" type="error"
                           title="Hapus Portofolio" message="Anda yakin ingin menghapus portofolio ini?">
                    <x-slot name="trigger">
                        <button type="button" class="text-red-600 hover:underline">Hapus</button>
                    </x-slot>
                </x-confirm>
            @endif
        </div>
    </td>
</tr>

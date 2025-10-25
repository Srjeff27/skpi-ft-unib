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

<div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
    {{-- Konten Utama Kartu --}}
    <div class="p-5">
        <div class="flex justify-between items-start gap-4">
            <h3 class="font-bold text-base text-gray-800 pr-4">{{ $p->judul_kegiatan }}</h3>
            <span class="flex-shrink-0 px-2.5 py-1 rounded-full text-xs font-semibold {{ $currentStatus['color'] }}">{{ $currentStatus['text'] }}</span>
        </div>

        @if (($p->status === 'rejected' || $p->status === 'requires_revision') && $p->rejection_reason)
            <div class="mt-3 text-xs border-l-4 border-red-300 bg-red-50 p-3 text-red-800 rounded">
                <b>Catatan Verifikator:</b> {{ $p->rejection_reason }}
            </div>
        @endif

        <div class="mt-4 grid grid-cols-2 gap-4 text-sm">
            <div>
                <div class="text-xs text-gray-500">Kategori</div>
                <div class="font-medium text-gray-700">{{ $p->kategori_portfolio }}</div>
            </div>
            <div>
                <div class="text-xs text-gray-500">Tanggal</div>
                <div class="font-medium text-gray-700">{{ \Carbon\Carbon::parse($p->tanggal_dokumen)->isoFormat('D MMM YYYY') }}</div>
            </div>
        </div>
    </div>
    {{-- Footer Aksi Kartu --}}
    <div class="p-2 border-t border-gray-200 bg-gray-50">
        <div class="flex items-center justify-end gap-2 text-sm font-semibold">
            <a href="{{ $p->link_sertifikat }}" target="_blank"
                class="flex-1 text-center px-3 py-2 rounded-md text-blue-600 hover:bg-blue-100">
                Lihat Bukti
            </a>
            @if ($p->status === 'pending' || $p->status === 'requires_revision')
                <a href="{{ route('student.portfolios.edit', $p) }}"
                    class="flex-1 text-center px-3 py-2 rounded-md text-indigo-600 hover:bg-indigo-100">
                    Edit
                </a>
                <x-confirm :action="route('student.portfolios.destroy', $p)" method="DELETE" type="error"
                           title="Hapus Portofolio" message="Anda yakin ingin menghapus portofolio ini?">
                    <x-slot name="trigger">
                        <button type="button" class="w-full text-center px-3 py-2 rounded-md text-red-600 hover:bg-red-100">
                            Hapus
                        </button>
                    </x-slot>
                </x-confirm>
            @endif
        </div>
    </div>
</div>

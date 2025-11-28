@php
    $p = $portfolio;
    
    // Konfigurasi Status & Warna
    $statusConfig = match($p->status) {
        'verified' => [
            'label' => 'Disetujui',
            'style' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
            'icon'  => 'heroicon-m-check-badge'
        ],
        'pending' => [
            'label' => 'Menunggu',
            'style' => 'bg-amber-50 text-amber-700 ring-amber-600/20',
            'icon'  => 'heroicon-m-clock'
        ],
        'requires_revision' => [
            'label' => 'Perlu Revisi',
            'style' => 'bg-orange-50 text-orange-700 ring-orange-600/20',
            'icon'  => 'heroicon-m-exclamation-triangle'
        ],
        'rejected' => [
            'label' => 'Ditolak',
            'style' => 'bg-rose-50 text-rose-700 ring-rose-600/20',
            'icon'  => 'heroicon-m-x-circle'
        ],
        default => [
            'label' => 'Draft',
            'style' => 'bg-slate-50 text-slate-600 ring-slate-500/20',
            'icon'  => 'heroicon-m-document'
        ]
    };

    $isEditable = in_array($p->status, ['pending', 'requires_revision']);
    $title = $p->judul_kegiatan ?? $p->nama_dokumen_id;
    $formattedDate = \Carbon\Carbon::parse($p->tanggal_dokumen)->isoFormat('D MMMM YYYY');
@endphp

<div class="group relative flex flex-col h-full bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-1">
    
    {{-- 1. Card Header: Status & Kategori --}}
    <div class="px-5 pt-5 pb-3 flex items-start justify-between gap-4">
        {{-- Kategori Badge --}}
        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-slate-100 text-xs font-semibold text-slate-600 uppercase tracking-wide">
            <x-heroicon-m-tag class="w-3.5 h-3.5" />
            {{ $p->kategori_portfolio }}
        </div>

        {{-- Status Badge --}}
        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium ring-1 ring-inset {{ $statusConfig['style'] }}">
            <x-dynamic-component :component="$statusConfig['icon']" class="w-3.5 h-3.5" />
            {{ $statusConfig['label'] }}
        </div>
    </div>

    {{-- 2. Card Body: Konten Utama --}}
    <div class="px-5 flex-1">
        {{-- Judul --}}
        <h3 class="text-lg font-bold text-slate-900 leading-snug group-hover:text-[#1b3985] transition-colors line-clamp-2" title="{{ $title }}">
            {{ $title }}
        </h3>
        
        {{-- Penyelenggara --}}
        <div class="mt-2 flex items-center gap-2 text-sm text-slate-500">
            <x-heroicon-o-building-office-2 class="w-4 h-4 shrink-0 text-slate-400" />
            <span class="truncate">{{ $p->penyelenggara }}</span>
        </div>

        {{-- Tanggal --}}
        <div class="mt-1 flex items-center gap-2 text-sm text-slate-500">
            <x-heroicon-o-calendar class="w-4 h-4 shrink-0 text-slate-400" />
            <span>{{ $formattedDate }}</span>
        </div>

        {{-- Alert Revisi/Ditolak (Jika ada) --}}
        @if (($p->status === 'rejected' || $p->status === 'requires_revision') && $p->rejection_reason)
            <div class="mt-4 p-3 rounded-lg bg-orange-50 border border-orange-100 flex gap-3 items-start">
                <x-heroicon-s-information-circle class="w-5 h-5 text-orange-500 shrink-0 mt-0.5" />
                <div class="space-y-1">
                    <p class="text-xs font-bold text-orange-800 uppercase">Catatan Verifikator:</p>
                    <p class="text-xs text-slate-700 leading-relaxed italic">"{{ Str::limit($p->rejection_reason, 80) }}"</p>
                </div>
            </div>
        @endif
    </div>

    {{-- 3. Card Footer: Actions --}}
    <div class="mt-5 px-5 py-4 border-t border-slate-100 bg-slate-50/50 rounded-b-2xl flex items-center justify-between gap-4">
        
        {{-- Link Bukti (Selalu Ada) --}}
        @php
            $evidenceUrl = \Illuminate\Support\Str::startsWith($p->link_sertifikat, ['http://','https://'])
                ? $p->link_sertifikat
                : route('portfolios.proof', $p);
        @endphp
        <a href="{{ $evidenceUrl }}" target="_blank" 
           class="inline-flex items-center gap-1.5 text-sm font-medium text-blue-600 hover:text-blue-700 hover:underline decoration-blue-300 underline-offset-4 transition-all">
            <x-heroicon-m-link class="w-4 h-4" />
            Lihat Bukti
        </a>

        {{-- Edit & Delete (Hanya jika status Pending/Revisi) --}}
        @if ($isEditable)
            <div class="flex items-center gap-1">
                {{-- Edit Button --}}
                <a href="{{ route('student.portfolios.edit', $p) }}" 
                   class="p-2 rounded-lg text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition-all tooltip-trigger"
                   title="Edit Data">
                    <x-heroicon-m-pencil-square class="w-5 h-5" />
                </a>

                {{-- Delete Button (Menggunakan Form Standard) --}}
                <form id="delete-portfolio-{{ $p->id }}" action="{{ route('student.portfolios.destroy', $p) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" 
                            @click="$dispatch('open-delete', { 
                                formId: 'delete-portfolio-{{ $p->id }}', 
                                name: @js($title),
                                badge: @js($p->kategori_portfolio),
                                meta: @js($p->penyelenggara),
                                date: @js($formattedDate)
                            })"
                            class="p-2 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-all"
                            title="Hapus Data">
                        <x-heroicon-m-trash class="w-5 h-5" />
                    </button>
                </form>
            </div>
        @else
            {{-- Indikator Locked --}}
            <span class="text-xs text-slate-400 flex items-center gap-1 cursor-help" title="Data dikunci karena sedang diverifikasi atau sudah disetujui">
                <x-heroicon-m-lock-closed class="w-3.5 h-3.5" />
                Terkunci
            </span>
        @endif
    </div>
</div>

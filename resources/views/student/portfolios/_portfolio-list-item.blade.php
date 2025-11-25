@php
    $p = $portfolio;
    
    $config = match($p->status) {
        'verified' => [
            'label'  => 'Disetujui',
            'style'  => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
            'border' => 'bg-emerald-500',
            'icon'   => 'heroicon-m-check-badge'
        ],
        'rejected' => [
            'label'  => 'Ditolak',
            'style'  => 'bg-rose-50 text-rose-700 ring-rose-600/20',
            'border' => 'bg-rose-500',
            'icon'   => 'heroicon-m-x-circle'
        ],
        'requires_revision' => [
            'label'  => 'Perlu Revisi',
            'style'  => 'bg-amber-50 text-amber-700 ring-amber-600/20',
            'border' => 'bg-amber-500',
            'icon'   => 'heroicon-m-exclamation-triangle'
        ],
        default => [
            'label'  => 'Menunggu',
            'style'  => 'bg-blue-50 text-blue-700 ring-blue-600/20',
            'border' => 'bg-blue-500',
            'icon'   => 'heroicon-m-clock'
        ],
    };

    $isEditable = in_array($p->status, ['pending', 'requires_revision']);
@endphp

<div class="group relative flex flex-col h-full bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 transition-all duration-300 hover:shadow-lg hover:-translate-y-1 overflow-hidden">
    
    {{-- Color Strip Indicator --}}
    <div class="absolute top-0 left-0 right-0 h-1 {{ $config['border'] }}"></div>

    <div class="p-5 flex flex-col h-full">
        {{-- Header: Category & Date --}}
        <div class="flex justify-between items-start mb-3">
            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider bg-slate-100 text-slate-500">
                {{ $p->kategori_portfolio }}
            </span>
            <span class="text-xs font-medium text-slate-400 flex items-center gap-1">
                <x-heroicon-m-calendar class="w-3.5 h-3.5" />
                {{ \Carbon\Carbon::parse($p->tanggal_dokumen)->isoFormat('D MMM YYYY') }}
            </span>
        </div>

        {{-- Body: Title & Organizer --}}
        <div class="flex-grow space-y-2">
            <h3 class="text-lg font-bold text-slate-800 leading-snug group-hover:text-[#1b3985] transition-colors line-clamp-2" title="{{ $p->nama_dokumen_id }}">
                {{ $p->nama_dokumen_id }}
            </h3>
            
            <div class="flex items-center gap-2 text-sm text-slate-500">
                <x-heroicon-o-building-office-2 class="w-4 h-4 shrink-0 text-slate-400" />
                <span class="truncate">{{ $p->penyelenggara }}</span>
            </div>

            {{-- Revision Alert Box (Visible if relevant) --}}
            @if (($p->status === 'rejected' || $p->status === 'requires_revision') && $p->rejection_reason)
                <div class="mt-3 p-3 rounded-lg bg-orange-50 border border-orange-100 text-xs text-orange-800 animate-fade-in-up">
                    <p class="font-bold mb-1 flex items-center gap-1">
                        <x-heroicon-s-chat-bubble-left-right class="w-3.5 h-3.5" />
                        Catatan Validator:
                    </p>
                    <p class="italic opacity-90 leading-relaxed">"{{ Str::limit($p->rejection_reason, 80) }}"</p>
                </div>
            @endif
        </div>

        {{-- Footer: Status & Actions --}}
        <div class="mt-5 pt-4 border-t border-slate-100 flex items-center justify-between">
            
            {{-- Status Badge --}}
            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold ring-1 ring-inset {{ $config['style'] }}">
                <x-dynamic-component :component="$config['icon']" class="w-3.5 h-3.5" />
                {{ $config['label'] }}
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center gap-1">
                {{-- View Evidence --}}
                <a href="{{ $p->link_sertifikat }}" target="_blank" 
                   class="p-2 rounded-lg text-slate-400 hover:text-[#1b3985] hover:bg-blue-50 transition-all"
                   title="Lihat Bukti">
                    <x-heroicon-m-link class="w-4 h-4" />
                </a>

                @if ($isEditable)
                    <div class="w-px h-4 bg-slate-200 mx-1"></div>
                    
                    {{-- Edit --}}
                    <a href="{{ route('student.portfolios.edit', $p) }}" 
                       class="p-2 rounded-lg text-slate-400 hover:text-amber-600 hover:bg-amber-50 transition-all"
                       title="Edit Data">
                        <x-heroicon-m-pencil-square class="w-4 h-4" />
                    </a>

                    {{-- Delete --}}
                    <form action="{{ route('student.portfolios.destroy', $p) }}" method="POST" 
                          onsubmit="return confirm('Yakin ingin menghapus data ini?');" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="p-2 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-all"
                                title="Hapus Permanen">
                            <x-heroicon-m-trash class="w-4 h-4" />
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
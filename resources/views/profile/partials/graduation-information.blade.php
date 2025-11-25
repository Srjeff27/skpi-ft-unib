<section class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    @php
        $fields = [
            [
                'label' => 'Tanggal Lulus',
                'value' => $user->tanggal_lulus ? $user->tanggal_lulus->format('d F Y') : null,
                'icon'  => 'heroicon-m-calendar-days',
                'color' => 'text-blue-600',
                'bg'    => 'bg-blue-50'
            ],
            [
                'label' => 'Nomor Ijazah',
                'value' => $user->nomor_ijazah,
                'icon'  => 'heroicon-m-document-check',
                'color' => 'text-emerald-600',
                'bg'    => 'bg-emerald-50'
            ],
            [
                'label' => 'Nomor SKPI',
                'value' => $user->nomor_skpi,
                'icon'  => 'heroicon-m-clipboard-document-list',
                'color' => 'text-purple-600',
                'bg'    => 'bg-purple-50'
            ],
            [
                'label' => 'Gelar (Indonesia)',
                'value' => $user->gelar_id,
                'icon'  => 'heroicon-m-academic-cap',
                'color' => 'text-[#1b3985]',
                'bg'    => 'bg-slate-100'
            ],
            [
                'label' => 'Degree (English)',
                'value' => $user->gelar_en,
                'icon'  => 'heroicon-m-globe-alt',
                'color' => 'text-[#1b3985]',
                'bg'    => 'bg-slate-100'
            ],
        ];
        
        $hasData = collect($fields)->every(fn($f) => filled($f['value']));
    @endphp

    {{-- Header Section --}}
    <div class="px-6 py-6 sm:px-8 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                <x-heroicon-o-academic-cap class="w-5 h-5 text-[#1b3985]" />
                Data Kelulusan
            </h2>
            <p class="mt-1 text-sm text-slate-500">Informasi resmi terkait legalitas kelulusan akademik Anda.</p>
        </div>
        
        <div>
            @if($hasData)
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-100 shadow-sm">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-wide">Terverifikasi</span>
                </div>
            @else
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-50 border border-amber-100 shadow-sm">
                    <span class="h-2 w-2 rounded-full bg-amber-400"></span>
                    <span class="text-xs font-bold text-amber-700 uppercase tracking-wide">Belum Lengkap</span>
                </div>
            @endif
        </div>
    </div>

    {{-- Grid Content --}}
    <div class="p-6 sm:p-8 bg-slate-50/30">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach ($fields as $field)
                <div class="group relative bg-white rounded-xl p-4 border border-slate-200 shadow-sm transition-all duration-300 hover:shadow-md hover:border-[#1b3985]/30 hover:-translate-y-0.5">
                    <div class="flex items-start gap-4">
                        {{-- Icon --}}
                        <div class="shrink-0">
                            <div class="h-10 w-10 rounded-lg {{ $field['bg'] }} {{ $field['color'] }} flex items-center justify-center transition-transform group-hover:scale-110">
                                <x-dynamic-component :component="$field['icon']" class="h-5 w-5" />
                            </div>
                        </div>

                        {{-- Data --}}
                        <div class="min-w-0 flex-1">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-0.5">
                                {{ $field['label'] }}
                            </p>
                            
                            @if(filled($field['value']))
                                <p class="text-sm font-semibold text-slate-800 truncate" title="{{ $field['value'] }}">
                                    {{ $field['value'] }}
                                </p>
                            @else
                                <p class="text-sm text-slate-400 italic flex items-center gap-1">
                                    <span>-</span>
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Warning State if Empty --}}
        @unless($hasData)
            <div class="mt-8 rounded-xl bg-amber-50 border border-amber-100 p-4 flex gap-4 items-start animate-fade-in-up">
                <x-heroicon-s-information-circle class="h-6 w-6 text-amber-500 shrink-0" />
                <div class="space-y-1">
                    <h3 class="text-sm font-bold text-amber-800">Sinkronisasi Data Diperlukan</h3>
                    <p class="text-xs text-amber-700/80 leading-relaxed">
                        Data kelulusan Anda belum tersedia atau belum lengkap. Jika Anda telah dinyatakan lulus, silakan hubungi bagian akademik Fakultas Teknik untuk pembaruan data PDDikti/SIAKAD.
                    </p>
                </div>
            </div>
        @endunless
    </div>
</section>
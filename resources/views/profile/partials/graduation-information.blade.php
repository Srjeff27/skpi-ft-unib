<section class="rounded-2xl bg-white p-6 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] sm:p-8 ring-1 ring-gray-900/5">
    @php
        $fields = [
            [
                'label' => 'Tanggal Lulus',
                'value' => $user->tanggal_lulus ? $user->tanggal_lulus->format('d F Y') : null,
                'icon'  => 'calendar'
            ],
            [
                'label' => 'Nomor Ijazah',
                'value' => $user->nomor_ijazah,
                'icon'  => 'document'
            ],
            [
                'label' => 'Nomor SKPI',
                'value' => $user->nomor_skpi,
                'icon'  => 'clipboard'
            ],
            [
                'label' => 'Gelar (Indonesia)',
                'value' => $user->gelar_id,
                'icon'  => 'academic'
            ],
            [
                'label' => 'Degree (English)',
                'value' => $user->gelar_en,
                'icon'  => 'academic'
            ],
        ];
        
        $hasData = collect($fields)->contains(fn($f) => filled($f['value']));
    @endphp

    <header class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between border-b border-gray-100 pb-6">
        <div>
            <h2 class="text-xl font-bold text-[#1b3985] tracking-tight">Data Kelulusan</h2>
            <p class="mt-1 text-sm text-slate-500">Rekam jejak akademik dan legalitas kelulusan Anda.</p>
        </div>
        
        <div>
            @if($hasData)
                <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    Data Terverifikasi
                </span>
            @else
                <span class="inline-flex items-center gap-2 rounded-full bg-amber-50 px-3 py-1.5 text-xs font-medium text-amber-700 ring-1 ring-inset ring-amber-600/20">
                    <span class="h-2 w-2 rounded-full bg-amber-500"></span>
                    Data Belum Lengkap
                </span>
            @endif
        </div>
    </header>

    <div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($fields as $field)
            <div class="group relative flex items-start gap-4 rounded-xl border border-slate-200 bg-slate-50/50 p-4 transition-all duration-300 hover:bg-white hover:border-[#1b3985]/30 hover:shadow-lg hover:shadow-[#1b3985]/5">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-white text-[#1b3985] shadow-sm ring-1 ring-slate-900/5 transition-colors group-hover:bg-[#1b3985] group-hover:text-white">
                    @switch($field['icon'])
                        @case('calendar')
                            <x-heroicon-o-calendar class="h-6 w-6" />
                            @break
                        @case('document')
                            <x-heroicon-o-document-text class="h-6 w-6" />
                            @break
                        @case('clipboard')
                            <x-heroicon-o-clipboard-document-check class="h-6 w-6" />
                            @break
                        @default
                            <x-heroicon-o-academic-cap class="h-6 w-6" />
                    @endswitch
                </div>
                
                <div class="flex-1 min-w-0">
                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400 group-hover:text-[#1b3985]/70 transition-colors">
                        {{ $field['label'] }}
                    </p>
                    <p class="mt-1 truncate text-sm font-semibold text-slate-800">
                        {{ $field['value'] ?? '-' }}
                    </p>
                    @if(empty($field['value']))
                        <p class="text-[10px] text-amber-600 mt-0.5 italic">Menunggu data</p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    @unless($hasData)
        <div class="mt-8 flex items-start gap-4 rounded-lg bg-amber-50 p-4 text-amber-800 ring-1 ring-inset ring-amber-600/10">
            <x-heroicon-o-information-circle class="h-6 w-6 flex-shrink-0 text-amber-600" />
            <div class="text-sm">
                <p class="font-semibold">Perhatian</p>
                <p class="mt-1 opacity-90">Beberapa data kelulusan Anda belum tersedia. Mohon segera menghubungi Bagian Akademik Fakultas Teknik jika Anda merasa sudah memenuhi syarat kelulusan.</p>
            </div>
        </div>
    @endunless
</section>
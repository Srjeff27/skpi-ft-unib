<x-app-layout>
    @php
        $user = auth()->user();
        $portfolios = \App\Models\Portfolio::where('user_id', $user->id)->latest()->get();
        
        $stats = [
            'semua' => $portfolios->count(),
            'verified' => $portfolios->where('status', 'verified')->count(),
            'pending' => $portfolios->where('status', 'pending')->count(),
            'rejected' => $portfolios->whereIn('status', ['rejected', 'requires_revision'])->count(),
        ];
    @endphp

    <div x-data="{ tab: 'semua' }" class="min-h-[80vh] flex flex-col space-y-8">
        
        {{-- 1. Header Section --}}
        <div class="relative rounded-2xl bg-gradient-to-br from-slate-900 via-[#1b3985] to-[#2b50a8] p-8 shadow-xl overflow-hidden group">
            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="space-y-2">
                    <h1 class="text-3xl font-bold text-white tracking-tight">Portofolio Saya</h1>
                    <p class="text-slate-200/90 text-sm md:text-base max-w-xl leading-relaxed">
                        Arsip digital pencapaian akademik dan non-akademik Anda. Kelola bukti kegiatan untuk transkrip SKPI.
                    </p>
                </div>
                
                <a href="{{ route('student.portfolios.create') }}" 
                   class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-white text-[#1b3985] font-bold text-sm shadow-lg shadow-blue-900/20 hover:bg-blue-50 hover:scale-105 hover:shadow-xl transition-all duration-300 focus:ring-4 focus:ring-blue-300/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    <span>Tambah Portofolio</span>
                </a>
            </div>

            {{-- Decorative Elements --}}
            <div class="absolute right-0 top-0 -mt-10 -mr-10 h-64 w-64 rounded-full bg-white/5 blur-3xl group-hover:bg-white/10 transition-all duration-700"></div>
            <div class="absolute left-0 bottom-0 -mb-10 -ml-10 h-40 w-40 rounded-full bg-blue-500/20 blur-2xl"></div>
        </div>

        {{-- Flash Message --}}
        @if (session('status'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                class="flex items-center gap-3 p-4 text-sm font-medium text-emerald-800 bg-emerald-50 border border-emerald-100 rounded-xl shadow-sm animate-fade-in-down">
                <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ session('status') }}
            </div>
        @endif

        {{-- 2. Main Content --}}
        @if ($portfolios->isEmpty())
            <div class="flex-1 flex flex-col items-center justify-center py-20 px-4 text-center bg-white border border-dashed border-slate-300 rounded-2xl">
                <div class="bg-slate-50 p-4 rounded-full mb-4">
                    <svg class="w-12 h-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900">Belum Ada Portofolio</h3>
                <p class="text-slate-500 max-w-sm mt-1 mb-8">Mulai bangun rekam jejak akademik Anda dengan mengunggah sertifikat pertama.</p>
                <a href="{{ route('student.portfolios.create') }}" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all">
                    Unggah Sekarang
                </a>
            </div>
        @else
            <div class="space-y-6">
                {{-- Tabs Navigation --}}
                <div class="sticky top-[88px] z-20 bg-slate-50/95 backdrop-blur-sm py-2 -mx-2 px-2 md:static md:bg-transparent md:p-0">
                    <div class="bg-white p-1.5 rounded-xl border border-slate-200 shadow-sm inline-flex w-full md:w-auto overflow-x-auto no-scrollbar">
                        @php
                            $tabs = [
                                ['id' => 'semua', 'label' => 'Semua', 'color' => 'bg-slate-100 text-slate-600', 'active_text' => 'text-slate-700'],
                                ['id' => 'verified', 'label' => 'Disetujui', 'color' => 'bg-emerald-100 text-emerald-700', 'active_text' => 'text-emerald-700'],
                                ['id' => 'pending', 'label' => 'Menunggu', 'color' => 'bg-amber-100 text-amber-700', 'active_text' => 'text-amber-700'],
                                ['id' => 'rejected', 'label' => 'Ditolak', 'color' => 'bg-rose-100 text-rose-700', 'active_text' => 'text-rose-700'],
                            ];
                        @endphp

                        @foreach($tabs as $t)
                            <button @click="tab = '{{ $t['id'] }}'"
                                :class="tab === '{{ $t['id'] }}' ? 'bg-white shadow-sm ring-1 ring-slate-200 {{ $t['active_text'] }}' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50'"
                                class="flex-1 md:flex-none flex items-center justify-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200 whitespace-nowrap">
                                {{ $t['label'] }}
                                <span :class="tab === '{{ $t['id'] }}' ? '{{ $t['color'] }}' : 'bg-slate-100 text-slate-500'" 
                                      class="px-2 py-0.5 rounded-md text-[10px] transition-colors">
                                    {{ $stats[$t['id']] }}
                                </span>
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Grid Content --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-12">
                    @foreach ($portfolios as $p)
                        {{-- Normalizing status for JS check --}}
                        @php
                            $statusKey = match($p->status) {
                                'verified' => 'verified',
                                'pending' => 'pending',
                                'rejected', 'requires_revision' => 'rejected',
                                default => 'semua'
                            };
                        @endphp

                        <div x-show="tab === 'semua' || tab === '{{ $statusKey }}'"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-y-4"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-cloak
                             class="h-full">
                            @include('student.portfolios._portfolio-list-item', ['portfolio' => $p])
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
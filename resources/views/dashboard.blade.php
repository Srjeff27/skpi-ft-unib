<x-app-layout>
    @php
        // Greeting Logic
        $h = now()->format('H');
        $greet = match(true) {
            $h >= 4 && $h < 11 => 'Selamat Pagi',
            $h >= 11 && $h < 15 => 'Selamat Siang',
            $h >= 15 && $h < 18 => 'Selamat Sore',
            default => 'Selamat Malam',
        };
        
        $user = auth()->user();
        
        // Data Query
        $baseQuery = \App\Models\Portfolio::where('user_id', $user->id);
        $total = $baseQuery->count();
        $verified = (clone $baseQuery)->where('status', 'verified')->count();
        $pending = (clone $baseQuery)->where('status', 'pending')->count();
        $rejected = (clone $baseQuery)->where('status', 'rejected')->count();
        $recent = (clone $baseQuery)->latest()->limit(5)->get();
    @endphp

    <div class="space-y-8">
        
        {{-- 1. Hero / Welcome Section --}}
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900 via-[#1b3985] to-[#2b50a8] p-8 shadow-lg">
            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="space-y-2">
                    <h1 class="text-3xl font-bold text-white tracking-tight">
                        {{ $greet }}, <span class="text-blue-200">{{ $user->name }}</span>
                    </h1>
                    <p class="text-slate-300 max-w-xl text-sm md:text-base leading-relaxed">
                        Selamat datang di Dashboard SKPI. Pantau progres validasi poin aktivitas dan kelola portofolio akademik Anda di sini.
                    </p>
                </div>
                <div class="hidden md:block">
                     <a href="{{ route('student.portfolios.create') }}" 
                        class="inline-flex items-center gap-2 px-5 py-3 bg-white/10 backdrop-blur-md border border-white/20 hover:bg-white/20 text-white rounded-xl transition-all duration-300 font-medium text-sm group">
                        <span>Tambah Portofolio</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                    </a>
                </div>
            </div>
            
            {{-- Decorative Blobs --}}
            <div class="absolute top-0 right-0 -mt-10 -mr-10 h-64 w-64 rounded-full bg-blue-500 blur-3xl opacity-20 pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 h-40 w-40 rounded-full bg-indigo-500 blur-3xl opacity-20 pointer-events-none"></div>
        </div>

        {{-- 2. Statistics Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @php
                $cards = [
                    [
                        'title' => 'Total Upload', 
                        'count' => $total, 
                        'bg_icon' => 'bg-blue-50 text-blue-600', 
                        'border' => 'border-l-4 border-blue-500',
                        'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'
                    ],
                    [
                        'title' => 'Terverifikasi', 
                        'count' => $verified, 
                        'bg_icon' => 'bg-emerald-50 text-emerald-600', 
                        'border' => 'border-l-4 border-emerald-500',
                        'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'
                    ],
                    [
                        'title' => 'Menunggu', 
                        'count' => $pending, 
                        'bg_icon' => 'bg-amber-50 text-amber-600', 
                        'border' => 'border-l-4 border-amber-500',
                        'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'
                    ],
                    [
                        'title' => 'Perlu Revisi', 
                        'count' => $rejected, 
                        'bg_icon' => 'bg-rose-50 text-rose-600', 
                        'border' => 'border-l-4 border-rose-500',
                        'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'
                    ],
                ];
            @endphp

            @foreach($cards as $card)
                <div class="bg-white rounded-xl p-5 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] hover:-translate-y-1 transition-transform duration-300 {{ $card['border'] }}">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-500 text-xs font-semibold uppercase tracking-wider">{{ $card['title'] }}</p>
                            <h3 class="text-3xl font-bold text-slate-800 mt-1">{{ $card['count'] }}</h3>
                        </div>
                        <div class="p-3 rounded-lg {{ $card['bg_icon'] }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $card['icon'] }}" />
                            </svg>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- 3. Content Grid (Chart & Recent) --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Left Column: Recent Activity (Takes 2 cols) --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                        <h3 class="font-bold text-slate-800 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Aktivitas Terbaru
                        </h3>
                        @if($total > 0)
                            <a href="{{ route('student.portfolios.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700 hover:underline">
                                Lihat Semua
                            </a>
                        @endif
                    </div>

                    @if($recent->isNotEmpty())
                        <ul class="divide-y divide-slate-100">
                            @foreach($recent as $item)
                                <li class="px-6 py-4 hover:bg-slate-50 transition-colors group">
                                    <div class="flex items-center gap-4">
                                        {{-- Icon Status --}}
                                        <div class="flex-shrink-0">
                                            @if($item->status == 'verified')
                                                <div class="h-10 w-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 ring-4 ring-white group-hover:ring-emerald-50 transition-all">
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                </div>
                                            @elseif($item->status == 'pending')
                                                <div class="h-10 w-10 rounded-full bg-amber-100 flex items-center justify-center text-amber-600 ring-4 ring-white group-hover:ring-amber-50 transition-all">
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                                </div>
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-rose-100 flex items-center justify-center text-rose-600 ring-4 ring-white group-hover:ring-rose-50 transition-all">
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                                </div>
                                            @endif
                                        </div>

                                        {{-- Content --}}
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-sm font-semibold text-slate-800 truncate group-hover:text-blue-700 transition-colors">
                                                {{ $item->nama_dokumen_id }}
                                            </h4>
                                            <p class="text-xs text-slate-500 mt-0.5">
                                                {{ $item->kategori_portfolio }} &bull; <span class="text-slate-400">{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</span>
                                            </p>
                                        </div>
                                        
                                        {{-- Arrow --}}
                                        <div class="text-slate-300 group-hover:text-slate-500 group-hover:translate-x-1 transition-all">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        {{-- Empty State --}}
                        <div class="flex flex-col items-center justify-center py-12 px-4 text-center">
                            <div class="bg-blue-50 rounded-full p-4 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-slate-900">Belum Ada Aktivitas</h3>
                            <p class="text-slate-500 max-w-sm mt-1 mb-6 text-sm">
                                Portofolio Anda masih kosong. Mulailah membangun rekam jejak akademik Anda hari ini.
                            </p>
                            <a href="{{ route('student.portfolios.create') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white transition-colors bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Mulai Upload Sekarang
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Right Column: Chart (Takes 1 col) --}}
            <div class="lg:col-span-1">
                @if($total > 0)
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 h-full flex flex-col">
                        <h3 class="font-bold text-slate-800 mb-6 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" /></svg>
                            Ringkasan Status
                        </h3>
                        <div class="relative flex-1 flex items-center justify-center min-h-[250px]">
                            <canvas id="chartStatus"></canvas>
                        </div>
                        <div class="mt-6 grid grid-cols-3 gap-2 text-center text-xs text-slate-500">
                            <div>
                                <span class="block w-3 h-3 rounded-full bg-emerald-500 mx-auto mb-1"></span>
                                Valid
                            </div>
                            <div>
                                <span class="block w-3 h-3 rounded-full bg-amber-500 mx-auto mb-1"></span>
                                Pending
                            </div>
                            <div>
                                <span class="block w-3 h-3 rounded-full bg-rose-500 mx-auto mb-1"></span>
                                Revisi
                            </div>
                        </div>
                    </div>
                @else
                    {{-- Empty Chart Placeholder --}}
                    <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl shadow-lg p-6 text-white h-full flex flex-col justify-between overflow-hidden relative">
                        <div class="relative z-10">
                            <h3 class="font-bold text-lg mb-2">Tips Sukses SKPI</h3>
                            <p class="text-slate-300 text-sm leading-relaxed">
                                Pastikan sertifikat yang diunggah terbaca jelas dan sesuai dengan kategori kegiatan untuk mempercepat proses verifikasi.
                            </p>
                        </div>
                        <div class="mt-4 relative z-10">
                            <div class="w-12 h-1 bg-blue-500 rounded-full mb-2"></div>
                            <p class="text-xs text-slate-400">Tim Akademik FT UNIB</p>
                        </div>
                        {{-- Decoration --}}
                        <svg class="absolute -bottom-6 -right-6 w-32 h-32 text-slate-700 opacity-50" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/></svg>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>

{{-- Chart Script --}}
@if($total > 0)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('chartStatus').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Terverifikasi', 'Ditolak', 'Menunggu'],
                datasets: [{
                    data: [{{ $verified }}, {{ $rejected }}, {{ $pending }}],
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.9)', // Emerald 500
                        'rgba(244, 63, 94, 0.9)',  // Rose 500
                        'rgba(245, 158, 11, 0.9)'  // Amber 500
                    ],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: true,
                    }
                }
            }
        });
    });
</script>
@endif
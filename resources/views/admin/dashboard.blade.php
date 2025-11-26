<x-app-layout>
    @push('scripts')
        <script src="{{ asset('js/admin-portfolio-trend.js') }}"></script>
        <script src="{{ asset('js/portfolio-status-donut.js') }}"></script>
    @endpush

    <div class="space-y-8 pb-12">
        
        {{-- 1. Hero / Welcome Section --}}
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900 via-[#1b3985] to-[#2b50a8] p-8 shadow-xl">
            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="space-y-2">
                    <h1 class="text-3xl font-bold text-white tracking-tight">
                        Selamat Datang, {{ Auth::user()->name }}
                    </h1>
                    <p class="text-blue-100/90 text-sm md:text-base max-w-2xl leading-relaxed">
                        Ini adalah pusat kendali sistem SKPI. Pantau statistik pengajuan, validasi data, dan aktivitas mahasiswa secara real-time.
                    </p>
                </div>
                <div class="hidden md:block">
                    <div class="h-12 w-12 rounded-xl bg-white/10 backdrop-blur-md flex items-center justify-center text-white border border-white/20 shadow-lg">
                        <x-heroicon-o-chart-bar class="w-6 h-6" />
                    </div>
                </div>
            </div>
            
            {{-- Decorative Blobs --}}
            <div class="absolute top-0 right-0 -mt-10 -mr-10 h-64 w-64 rounded-full bg-white/5 blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 h-40 w-40 rounded-full bg-blue-400/10 blur-2xl pointer-events-none"></div>
        </div>

        {{-- 2. Statistic Cards --}}
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @php
                $stats = [
                    ['label' => 'Total Mahasiswa', 'value' => $totalMahasiswa, 'icon' => 'heroicon-o-users', 'bg' => 'bg-blue-50', 'text' => 'text-blue-600', 'route' => route('admin.students.index')],
                    ['label' => 'Total Verifikator', 'value' => $totalVerifikator, 'icon' => 'heroicon-o-user-group', 'bg' => 'bg-cyan-50', 'text' => 'text-cyan-600', 'route' => route('admin.verifikators.index')],
                    ['label' => 'Menunggu Validasi', 'value' => $pending, 'icon' => 'heroicon-o-clock', 'bg' => 'bg-amber-50', 'text' => 'text-amber-600', 'route' => route('admin.portfolios.index', ['status' => 'pending'])],
                    ['label' => 'Selesai Diverifikasi', 'value' => $verified, 'icon' => 'heroicon-o-check-badge', 'bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'route' => route('admin.portfolios.index', ['status' => 'verified'])],
                ];
            @endphp

            @foreach ($stats as $stat)
                <a href="{{ $stat['route'] }}" class="group relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200 transition-all duration-300 hover:shadow-md hover:-translate-y-1">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-500">{{ $stat['label'] }}</p>
                            <h3 class="mt-2 text-3xl font-bold text-slate-800">{{ number_format($stat['value']) }}</h3>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl {{ $stat['bg'] }} {{ $stat['text'] }} transition-colors group-hover:scale-110">
                            <x-dynamic-component :component="$stat['icon']" class="h-6 w-6" />
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- 3. Main Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Left Column (Charts) --}}
            <div class="lg:col-span-2 space-y-8">
                
                {{-- Portfolio Trend Chart Container --}}
                {{-- Saya mengembalikan container ini karena script admin-portfolio-trend.js disertakan --}}
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="font-bold text-slate-800 flex items-center gap-2">
                                <x-heroicon-o-presentation-chart-line class="w-5 h-5 text-slate-400" />
                                Tren Pengajuan
                            </h3>
                            <p class="text-sm text-slate-500">Aktivitas pengajuan bulan ini</p>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-slate-800">{{ number_format($currentMonth['value'] ?? 0) }}</div>
                            <div class="text-xs font-medium {{ ($delta ?? 0) >= 0 ? 'text-emerald-600' : 'text-rose-600' }} flex items-center justify-end gap-1">
                                @if(($delta ?? 0) >= 0)
                                    <x-heroicon-s-arrow-trending-up class="w-3 h-3" />
                                @else
                                    <x-heroicon-s-arrow-trending-down class="w-3 h-3" />
                                @endif
                                {{ $delta ?? 0 }}% dari bulan lalu
                            </div>
                        </div>
                    </div>
                    <div id="portfolio-trend-chart" class="w-full overflow-hidden" data-series='@json($portfolioTrend ?? [])'></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    {{-- Status Donut Chart Container --}}
                    {{-- Container ini juga dikembalikan agar script donut chart bekerja --}}
                    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200 flex flex-col">
                        <h3 class="font-bold text-slate-800 mb-6 flex items-center gap-2">
                            <x-heroicon-o-chart-pie class="w-5 h-5 text-slate-400" />
                            Komposisi Status
                        </h3>
                        @php $statusTotal = collect($statusDonut ?? [])->sum('value'); @endphp
                        <div class="flex-1 flex flex-col items-center justify-center relative pt-4">
                            <div class="portfolio-status-donut h-48 w-48 relative z-10" data-series='@json($statusDonut ?? [])'></div>
                            <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                                <span class="text-xl font-bold text-slate-800" data-donut-value>{{ $statusTotal }}</span>
                                <span class="text-[10px] uppercase tracking-wide text-slate-400">Total</span>
                            </div>
                        </div>
                        <div class="mt-6 space-y-3">
                            @foreach ($statusDonut ?? [] as $item)
                                <div class="flex items-center justify-between text-sm">
                                    <div class="flex items-center gap-2">
                                        <span class="h-3 w-3 rounded-full" style="background: {{ $item['color'] }}"></span>
                                        <span class="text-slate-600">{{ $item['label'] }}</span>
                                    </div>
                                    <span class="font-semibold text-slate-800">{{ $item['value'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Prestasi per Prodi --}}
                    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                        <h3 class="font-bold text-slate-800 mb-1">Performa Program Studi</h3>
                        <p class="text-xs text-slate-500 mb-6">Prestasi terverifikasi terbanyak</p>
                        
                        <div class="space-y-5 overflow-y-auto max-h-[300px] pr-2 scrollbar-thin scrollbar-thumb-slate-200">
                            @php $maxPrestasi = $prestasiProdi->max('total') ?: 1; @endphp
                            @forelse ($prestasiProdi as $data)
                                <div>
                                    <div class="flex justify-between items-end mb-1">
                                        <span class="text-xs font-semibold text-slate-700 truncate max-w-[70%]">{{ $data->nama_prodi }}</span>
                                        <span class="text-xs font-bold text-blue-600">{{ $data->total }}</span>
                                    </div>
                                    <div class="w-full bg-slate-100 rounded-full h-2">
                                        <div class="h-2 rounded-full transition-all duration-500 bg-[#1b3985]" 
                                             style="width: {{ ($data->total / $maxPrestasi) * 100 }}%"></div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <p class="text-sm text-slate-500 italic">Belum ada data prestasi.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column (Recent Activity) --}}
            <div class="lg:col-span-1">
                <div class="sticky top-24 rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                        <h3 class="font-bold text-slate-800 flex items-center gap-2">
                            <x-heroicon-o-inbox-stack class="w-5 h-5 text-slate-400" />
                            Perlu Verifikasi
                        </h3>
                        @php
                             $countPending = \App\Models\Portfolio::where('status', 'pending')->count();
                        @endphp
                        @if($countPending > 0)
                            <span class="bg-amber-100 text-amber-700 text-xs font-bold px-2 py-0.5 rounded-full">{{ $countPending }}</span>
                        @endif
                    </div>

                    <ul class="divide-y divide-slate-100">
                        @php
                            $recentPending = \App\Models\Portfolio::with('user:id,name,avatar')->where('status', 'pending')->latest()->take(6)->get();
                        @endphp
                        
                        @forelse ($recentPending as $portfolio)
                            <li>
                                <a href="{{ route('admin.portfolios.show', $portfolio) }}" class="block p-4 hover:bg-slate-50 transition-colors group">
                                    <div class="flex items-start gap-3">
                                        <img class="h-9 w-9 rounded-full object-cover ring-2 ring-white shadow-sm" src="{{ $portfolio->user->avatar_url }}" alt="">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-slate-900 group-hover:text-blue-600 truncate">
                                                {{ $portfolio->user->name }}
                                            </p>
                                            <p class="text-xs text-slate-500 truncate mt-0.5">
                                                {{ $portfolio->judul_kegiatan }}
                                            </p>
                                            <p class="text-[10px] text-slate-400 mt-1.5 flex items-center gap-1">
                                                <x-heroicon-m-clock class="w-3 h-3" />
                                                {{ $portfolio->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                        <x-heroicon-m-chevron-right class="w-4 h-4 text-slate-300 group-hover:text-blue-500" />
                                    </div>
                                </a>
                            </li>
                        @empty
                            <div class="p-8 text-center">
                                <div class="mx-auto h-12 w-12 rounded-full bg-emerald-50 flex items-center justify-center mb-3">
                                    <x-heroicon-o-check class="w-6 h-6 text-emerald-500" />
                                </div>
                                <h4 class="text-sm font-semibold text-slate-900">Semua Beres!</h4>
                                <p class="text-xs text-slate-500 mt-1">Tidak ada portofolio pending saat ini.</p>
                            </div>
                        @endforelse
                    </ul>

                    @if($recentPending->count() > 0)
                        <div class="p-4 bg-slate-50 border-t border-slate-100">
                            <a href="{{ route('admin.portfolios.index', ['status' => 'pending']) }}" class="flex items-center justify-center w-full rounded-xl bg-white border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 hover:text-blue-600 transition-all">
                                Lihat Semua Pending
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

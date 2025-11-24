<x-app-layout>
    <div class="space-y-8">
        {{-- Header --}}
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ Auth::user()->name }}!</h1>
            <p class="text-sm text-gray-500">Berikut adalah ringkasan aktivitas dan statistik sistem SKPI.</p>
        </div>

        {{-- Stat Cards --}}
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @php
                $stats = [
                    ['label' => 'Total Mahasiswa', 'value' => $totalMahasiswa, 'icon' => 'heroicon-o-users', 'color' => 'bg-blue-500', 'route' => route('admin.students.index')],
                    ['label' => 'Total Verifikator', 'value' => $totalVerifikator, 'icon' => 'heroicon-o-user-group', 'color' => 'bg-cyan-500', 'route' => route('admin.verifikators.index')],
                    ['label' => 'Portofolio Pending', 'value' => $pending, 'icon' => 'heroicon-o-clock', 'color' => 'bg-amber-500', 'route' => route('admin.portfolios.index', ['status' => 'pending'])],
                    ['label' => 'Portofolio Verified', 'value' => $verified, 'icon' => 'heroicon-o-check-circle', 'color' => 'bg-green-500', 'route' => route('admin.portfolios.index', ['status' => 'verified'])],
                ];
            @endphp

            @foreach ($stats as $stat)
                <a href="{{ $stat['route'] }}" class="overflow-hidden rounded-xl bg-white p-5 shadow-sm border border-gray-100 hover:border-gray-300 transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full {{ $stat['color'] }} text-white">
                            <x-dynamic-component :component="$stat['icon']" class="h-6 w-6" />
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-500">{{ $stat['label'] }}</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $stat['value'] }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Left Column: Charts --}}
            <div class="lg:col-span-2 space-y-8">
                {{-- Prestasi per Prodi --}}
                <div class="rounded-xl bg-white p-5 sm:p-6 shadow-sm border border-gray-100">
                    <h3 class="text-base font-semibold text-gray-800">Prestasi Terverifikasi per Program Studi</h3>
                    <p class="text-sm text-gray-500 mb-4">Jumlah portofolio berstatus 'verified' untuk setiap prodi.</p>
                    <div class="space-y-3">
                        @php
                            $maxPrestasi = $prestasiProdi->max('total') ?: 1;
                        @endphp
                        @forelse ($prestasiProdi as $data)
                            <div class="grid grid-cols-4 gap-4 items-center text-sm">
                                <div class="col-span-1 text-gray-600 truncate">{{ $data->nama_prodi }}</div>
                                <div class="col-span-3 flex items-center gap-4">
                                    <div class="w-full rounded-full bg-gray-100 h-2.5">
                                        <div class="rounded-full bg-blue-500 h-2.5" style="width: {{ ($data->total / $maxPrestasi) * 100 }}%"></div>
                                    </div>
                                    <div class="font-semibold text-gray-800 w-8 text-right">{{ $data->total }}</div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-sm text-gray-500 py-8">Belum ada data prestasi.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Right Column: Recent Activity --}}
            <div class="rounded-xl bg-white p-5 sm:p-6 shadow-sm border border-gray-100">
                <h3 class="text-base font-semibold text-gray-800">Menunggu Verifikasi</h3>
                <p class="text-sm text-gray-500 mb-4">Daftar portofolio terbaru yang perlu diverifikasi.</p>
                <div class="flow-root">
                    <ul role="list" class="-mb-4">
                        @php
                            $recentPending = \App\Models\Portfolio::with('user:id,name,avatar')->where('status', 'pending')->latest()->take(5)->get();
                        @endphp
                        @forelse ($recentPending as $portfolio)
                            <li>
                                <a href="{{ route('admin.portfolios.show', $portfolio) }}" class="relative flex items-start space-x-4 py-4 hover:bg-gray-50 rounded-lg px-2 -mx-2">
                                    <img class="h-8 w-8 flex-shrink-0 rounded-full object-cover" src="{{ $portfolio->user->avatar_url }}" alt="">
                                    <div class="min-w-0 flex-auto text-sm">
                                        <h4 class="font-semibold text-gray-800 truncate">{{ $portfolio->user->name }}</h4>
                                        <p class="text-gray-500 truncate">{{ $portfolio->judul_kegiatan }}</p>
                                    </div>
                                    <div class="text-xs text-gray-400 flex-shrink-0 self-center">
                                        {{ $portfolio->created_at->diffForHumans() }}
                                    </div>
                                </a>
                            </li>
                        @empty
                             <div class="text-center text-sm text-gray-500 py-8">
                                <div class="flex justify-center items-center mx-auto w-12 h-12 rounded-full bg-green-50 text-green-500 mb-2">
                                    <x-heroicon-o-check-circle class="w-6 h-6" />
                                </div>
                                Semua sudah terverifikasi!
                            </div>
                        @endforelse
                    </ul>
                </div>
                @if($recentPending->count() > 0)
                <div class="mt-6">
                    <a href="{{ route('admin.portfolios.index', ['status' => 'pending']) }}" class="block w-full rounded-lg bg-gray-50 px-4 py-2 text-center text-sm font-semibold text-gray-600 hover:bg-gray-100">
                        Lihat Semua
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    @php
        $hour = now()->timezone(config('app.timezone'))->format('H');
        if ($hour >= 4 && $hour < 11) {
            $greet = 'Selamat Pagi';
        } elseif ($hour >= 11 && $hour < 15) {
            $greet = 'Selamat Siang';
        } elseif ($hour >= 15 && $hour < 18) {
            $greet = 'Selamat Sore';
        } else {
            $greet = 'Selamat Malam';
        }
        $user = auth()->user();
        $name = $user?->name ?? 'Pengguna';
        
        // Data fetching
        $portfolios = \App\Models\Portfolio::where('user_id', $user->id);
        $total = $portfolios->count();
        $pending = (clone $portfolios)->where('status', 'pending')->count();
        $verified = (clone $portfolios)->where('status', 'verified')->count();
        $rejected = (clone $portfolios)->where('status', 'rejected')->count();
        $recent = (clone $portfolios)->latest()->limit(3)->get();
    @endphp

    <div class="space-y-6">
        <div class="relative rounded-xl bg-gradient-to-r from-[#1b3985] to-[#2b50a8] p-6 overflow-hidden">
            <div class="relative z-10 space-y-2">
                <h1 class="text-2xl font-bold text-white">{{ $greet }}, {{ $name }}!</h1>
                <p class="text-blue-200 max-w-md">Selamat datang di portal SKPI. Kelola semua portofolio Anda di sini dengan mudah.</p>
            </div>
            <div class="absolute -bottom-12 -right-12 w-40 h-40 rounded-full bg-blue-800 opacity-50"></div>
            <div class="absolute -bottom-4 -right-4 w-24 h-24 rounded-full bg-blue-700 opacity-50"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $stats = [
                    ['label' => 'Total Portofolio', 'value' => $total, 'color' => 'blue', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>'],
                    ['label' => 'Terverifikasi', 'value' => $verified, 'color' => 'green', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>'],
                    ['label' => 'Menunggu', 'value' => $pending, 'color' => 'yellow', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>'],
                    ['label' => 'Ditolak', 'value' => $rejected, 'color' => 'red', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>'],
                ];
                $colors = [
                    'blue' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-600', 'border' => 'border-blue-200'],
                    'green' => ['bg' => 'bg-green-50', 'text' => 'text-green-600', 'border' => 'border-green-200'],
                    'yellow' => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-600', 'border' => 'border-yellow-200'],
                    'red' => ['bg' => 'bg-red-50', 'text' => 'text-red-600', 'border' => 'border-red-200'],
                ];
            @endphp
            @foreach ($stats as $stat)
                <div class="bg-white border {{ $colors[$stat['color']]['border'] }} rounded-xl p-5 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                    <div class="flex items-center gap-4">
                        <div class="p-3 rounded-full {{ $colors[$stat['color']]['bg'] }} {{ $colors[$stat['color']]['text'] }}">
                            {!! $stat['icon'] !!}
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">{{ $stat['label'] }}</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $stat['value'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
            @if($total > 0)
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Status Portofolio</h3>
                <canvas id="chartStatus"></canvas>
            </div>
            @endif

            <div class="@if($total > 0) lg:col-span-3 @else lg:col-span-5 @endif bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-800">Aktivitas Terbaru</h3>
                    <a href="{{ route('student.portfolios.index') }}" class="text-sm font-medium text-[#1b3985] hover:underline">Lihat Semua</a>
                </div>
                
                @if($recent->isNotEmpty())
                    <div class="flow-root">
                        <ul role="list" class="divide-y divide-gray-200">
                            @foreach ($recent as $p)
                                <li class="p-6 hover:bg-gray-50 transition-colors">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            @php 
                                                $statusInfo = match($p->status) {
                                                    'verified' => ['icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>', 'color' => 'text-green-500'],
                                                    'pending' => ['icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>', 'color' => 'text-yellow-500'],
                                                    'rejected' => ['icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" /></svg>', 'color' => 'text-red-500'],
                                                    default => ['icon' => '', 'color' => 'text-gray-500']
                                                };
                                            @endphp
                                            <span class="{{ $statusInfo['color'] }}">{!! $statusInfo['icon'] !!}</span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">{{ $p->nama_dokumen_id}}</p>
                                            <p class="text-sm text-gray-500 truncate">{{ $p->kategori_portfolio }}</p>
                                        </div>
                                        <div class="text-right text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($p->tanggal_mulai)->diffForHumans() }}
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <div class="text-center py-16 px-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada portofolio</h3>
                        <p class="mt-1 text-sm text-gray-500">Unggah portofolio pertama Anda untuk memulai.</p>
                        <div class="mt-6">
                            <a href="{{ route('student.portfolios.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#F97316] hover:bg-[#E8630B] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F97316]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Unggah Portofolio
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if ({{ $total }} > 0) {
            const ctx = document.getElementById('chartStatus')?.getContext('2d');
            if (ctx) {
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Terverifikasi', 'Ditolak', 'Menunggu'],
                        datasets: [{
                            data: [{{ $verified }}, {{ $rejected }}, {{ $pending }}],
                            backgroundColor: ['#22c55e', '#ef4444', '#f59e0b'],
                            borderColor: '#fff',
                            borderWidth: 2,
                        }]
                    },
                    options: {
                        responsive: true,
                        cutout: '70%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    boxWidth: 12,
                                    font: {
                                        size: 14
                                    }
                                }
                            }
                        }
                    }
                });
            }
        }
    });
</script>

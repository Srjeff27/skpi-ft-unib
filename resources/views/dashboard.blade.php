<x-app-layout>
    <x-slot name="header">
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
            $name = auth()->user()?->name ?? 'Pengguna';
        @endphp
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $greet }}, {{ $name }} 👋
        </h2>
        <p class="text-sm text-gray-500">Selamat datang kembali di dashboard Anda.</p>
    </x-slot>

    {{-- Logika pengambilan data --}}
    @php
        $uid = auth()->id();
        $portfolios = \App\Models\Portfolio::where('user_id', $uid);
        $total = $portfolios->count();
        $pending = (clone $portfolios)->where('status', 'pending')->count();
        $verified = (clone $portfolios)->where('status', 'verified')->count();
        $rejected = (clone $portfolios)->where('status', 'rejected')->count();
        $recent = (clone $portfolios)->latest()->limit(2)->get();
    @endphp

    {{-- DIUBAH: Padding bawah ditambahkan untuk memberi ruang pada navigasi mobile --}}
    <div class="pt-8 pb-24 sm:pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Grid Statistik --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
                    <div class="text-sm text-gray-500">Total Portofolio</div>
                    <div class="mt-1 text-3xl font-bold text-gray-800">{{ $total }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
                    <div class="text-sm text-gray-500">Menunggu Verifikasi</div>
                    <div class="mt-1 text-3xl font-bold text-yellow-500">{{ $pending }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
                    <div class="text-sm text-gray-500">Terverifikasi</div>
                    <div class="mt-1 text-3xl font-bold text-green-500">{{ $verified }}</div>
                </div>
            </div>

            {{-- Grid Chart --}}
            @if($total > 0)
            <div class="max-w-xl mx-auto">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
                    <h3 class="text-base font-semibold text-gray-700 mb-3">Portofolio per Status</h3>
                    <canvas id="chartStatus"></canvas>
                </div>
            </div>
            @endif

            {{-- Header Tabel Terbaru --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h3 class="text-lg font-semibold text-gray-800">Portofolio Terbaru</h3>
                <div class="flex items-center space-x-3 w-full sm:w-auto">
                    <a href="{{ route('student.portfolios.index') }}" class="w-full sm:w-auto text-center rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                        Lihat Semua
                    </a>
                    <a href="{{ route('student.portfolios.create') }}" class="w-full sm:w-auto text-center inline-flex items-center justify-center rounded-lg bg-orange-500 px-4 py-2 text-sm font-medium text-white hover:bg-orange-600 transition shadow-sm">
                        <svg class="w-5 h-5 mr-1.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                        </svg>
                        Upload Baru
                    </a>
                </div>
            </div>

            {{-- Tabel & Kartu Portofolio Terbaru --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                {{-- Tampilan Tabel untuk Desktop --}}
                <div class="hidden sm:block">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="bg-gray-50 text-left text-gray-500">
                                <tr>
                                    <th class="p-4 font-semibold">Judul Kegiatan</th>
                                    <th class="p-4 font-semibold">Kategori</th>
                                    <th class="p-4 font-semibold">Tanggal</th>
                                    <th class="p-4 font-semibold text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($recent as $p)
                                    <tr>
                                        <td class="p-4 align-top font-medium text-gray-800">{{ $p->judul_kegiatan }}</td>
                                        <td class="p-4 align-top text-gray-600">{{ $p->kategori_portfolio }}</td>
                                        <td class="p-4 align-top text-gray-600 whitespace-nowrap">
                                            {{ \Carbon\Carbon::parse($p->tanggal_mulai)->isoFormat('D MMM YYYY') }}
                                        </td>
                                        <td class="p-4 align-top text-center">
                                            @php $colors = ['pending' => 'bg-yellow-100 text-yellow-800', 'verified' => 'bg-green-100 text-green-800', 'rejected' => 'bg-red-100 text-red-800']; @endphp
                                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $colors[$p->status] ?? 'bg-gray-100 text-gray-800' }}">{{ ucfirst($p->status) }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="p-10 text-center text-gray-500" colspan="4">Anda belum mengunggah portofolio.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Tampilan Kartu untuk Mobile --}}
                <div class="block sm:hidden">
                    <div class="p-4 space-y-4">
                        @forelse ($recent as $p)
                            <div class="border border-gray-200 rounded-lg p-4 space-y-3">
                                <div class="flex justify-between items-start gap-3">
                                    <h4 class="font-semibold text-gray-800 leading-tight">{{ $p->judul_kegiatan }}</h4>
                                    @php $colors = ['pending' => 'bg-yellow-100 text-yellow-800', 'verified' => 'bg-green-100 text-green-800', 'rejected' => 'bg-red-100 text-red-800']; @endphp
                                    <span class="flex-shrink-0 px-2 py-1 rounded-full text-xs font-semibold {{ $colors[$p->status] ?? 'bg-gray-100 text-gray-800' }}">{{ ucfirst($p->status) }}</span>
                                </div>
                                <div class="grid grid-cols-2 gap-4 pt-2 border-t border-gray-100">
                                    <div>
                                        <div class="text-xs text-gray-500">Kategori</div>
                                        <div class="text-sm text-gray-700 font-medium">{{ $p->kategori_portfolio }}</div>
                                    </div>
                                    <div>
                                        <div class="text-xs text-gray-500">Tanggal</div>
                                        <div class="text-sm text-gray-700 font-medium">
                                            {{ \Carbon\Carbon::parse($p->tanggal_mulai)->isoFormat('D MMM YYYY') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="py-10 text-center text-gray-500">Anda belum mengunggah portofolio.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if ({{ $total }} > 0) {
            // Chart Status
            const ctx1 = document.getElementById('chartStatus')?.getContext('2d');
            if (ctx1) {
                new Chart(ctx1, {
                    type: 'doughnut',
                    data: {
                        labels: ['Terverifikasi', 'Ditolak', 'Menunggu'],
                        datasets: [{ data: [{{ $verified }}, {{ $rejected }}, {{ $pending }}], backgroundColor: ['#22c55e', '#ef4444', '#f59e0b'] }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { position: 'bottom' }
                        }
                    }
                });
            }
        }
    });
</script>

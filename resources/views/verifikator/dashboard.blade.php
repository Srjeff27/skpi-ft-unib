<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">Dashboard Verifikator</h2>
        <p class="text-sm text-gray-500">Ringkasan verifikasi</p>
    </x-slot>

    <div class="pt-8 pb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white p-5 rounded-lg shadow-sm">
                    <div class="text-sm text-gray-500">Menunggu</div>
                    <div class="mt-1 text-2xl font-semibold">{{ $pending }}</div>
                </div>
                <div class="bg-white p-5 rounded-lg shadow-sm">
                    <div class="text-sm text-gray-500">Disetujui</div>
                    <div class="mt-1 text-2xl font-semibold">{{ $verified }}</div>
                </div>
                <div class="bg-white p-5 rounded-lg shadow-sm">
                    <div class="text-sm text-gray-500">Ditolak</div>
                    <div class="mt-1 text-2xl font-semibold">{{ $rejected }}</div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-5">
                <div class="font-semibold mb-3">Prestasi per Prodi</div>
                <div class="h-64">
                    <canvas id="prestasiProdiChart"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-5">
                <div class="font-semibold mb-3">Mahasiswa per Prodi</div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="text-left text-gray-500">
                                <th class="p-2">Prodi</th>
                                <th class="p-2 text-right">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($byProdi as $p)
                                <tr class="border-t">
                                    <td class="p-2">{{ optional($p->prodi)->nama_prodi ?? '-' }}</td>
                                    <td class="p-2 text-right">{{ $p->total }}</td>
                                </tr>
                            @empty
                                <tr><td class="p-4 text-center text-gray-500" colspan="2">Tidak ada data.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('prestasiProdiChart').getContext('2d');
            
            // Data prestasi per prodi
            const prestasiData = {
                labels: [
                    @foreach($prestasiProdi as $data)
                        '{{ optional($data->prodi)->nama_prodi ?? "Tidak ada prodi" }}',
                    @endforeach
                ],
                datasets: [{
                    label: 'Jumlah Prestasi Terverifikasi',
                    data: [
                        @foreach($prestasiProdi as $data)
                            {{ $data->total }},
                        @endforeach
                    ],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(255, 159, 64, 0.7)',
                        'rgba(199, 199, 199, 0.7)',
                        'rgba(83, 102, 255, 0.7)',
                        'rgba(40, 159, 64, 0.7)',
                        'rgba(210, 199, 199, 0.7)',
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(199, 199, 199, 1)',
                        'rgba(83, 102, 255, 1)',
                        'rgba(40, 159, 64, 1)',
                        'rgba(210, 199, 199, 1)',
                    ],
                    borderWidth: 1
                }]
            };

            new Chart(ctx, {
                type: 'bar',
                data: prestasiData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>


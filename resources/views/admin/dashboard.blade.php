<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">Dashboard Admin</h2>
        <p class="text-sm text-gray-500">Statistik ringkas</p>
    </x-slot>

    <div class="pt-8 pb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white p-5 rounded-lg shadow-sm">
                    <div class="text-sm text-gray-500">Total User</div>
                    <div class="mt-1 text-2xl font-semibold">{{ $totalUsers }}</div>
                </div>
                <div class="bg-white p-5 rounded-lg shadow-sm">
                    <div class="text-sm text-gray-500">Mahasiswa</div>
                    <div class="mt-1 text-2xl font-semibold">{{ $totalMahasiswa }}</div>
                </div>
                <div class="bg-white p-5 rounded-lg shadow-sm">
                    <div class="text-sm text-gray-500">Verifikator</div>
                    <div class="mt-1 text-2xl font-semibold">{{ $totalVerifikator }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white p-5 rounded-lg shadow-sm">
                    <div class="text-sm text-gray-500">Portofolio</div>
                    <div class="mt-1 text-2xl font-semibold">{{ $totalPortfolios }}</div>
                </div>
                <div class="bg-white p-5 rounded-lg shadow-sm">
                    <div class="text-sm text-gray-500">Terverifikasi</div>
                    <div class="mt-1 text-2xl font-semibold">{{ $verified }}</div>
                </div>
                <div class="bg-white p-5 rounded-lg shadow-sm">
                    <div class="text-sm text-gray-500">Ditolak</div>
                    <div class="mt-1 text-2xl font-semibold">{{ $rejected }}</div>
                </div>
                <div class="bg-white p-5 rounded-lg shadow-sm">
                    <div class="text-sm text-gray-500">Belum Diverifikasi</div>
                    <div class="mt-1 text-2xl font-semibold">{{ $pending }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white p-5 rounded-lg shadow-sm">
                    <div class="text-sm text-gray-500 mb-2">Portofolio per Status</div>
                    <canvas id="chartStatus" height="140"></canvas>
                </div>
                <div class="bg-white p-5 rounded-lg shadow-sm">
                    <div class="text-sm text-gray-500 mb-2">Mahasiswa per Prodi</div>
                    <canvas id="chartProdi" height="140"></canvas>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm p-5">
                <div class="font-semibold mb-3">Prestasi per Prodi</div>
                <div class="h-64">
                    <canvas id="prestasiProdiChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx1 = document.getElementById('chartStatus').getContext('2d');
    new Chart(ctx1, {
        type: 'doughnut',
        data: {
            labels: ['Verified','Rejected','Pending'],
            datasets: [{
                data: [{{ $verified }}, {{ $rejected }}, {{ $pending }}],
                backgroundColor: ['#22c55e','#ef4444','#f59e0b']
            }]
        },
        options: { plugins: { legend: { position: 'bottom' } } }
    });

    const ctx2 = document.getElementById('chartProdi').getContext('2d');
    const labelsProdi = @json(\App\Models\Prodi::orderBy('nama_prodi')->pluck('nama_prodi'));
    const dataProdi = @json(\App\Models\Prodi::withCount('users')->orderBy('nama_prodi')->pluck('users_count'));
    new Chart(ctx2, {
        type: 'bar',
        data: { labels: labelsProdi, datasets: [{ label: 'Mahasiswa', data: dataProdi, backgroundColor: '#3b82f6' }]},
        options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
    });
    
    document.addEventListener('DOMContentLoaded', function() {
        const ctx3 = document.getElementById('prestasiProdiChart').getContext('2d');
        
        // Data prestasi per prodi
        const prestasiData = {
            labels: [
                @foreach($prestasiProdi as $data)
                    '{{ $data->nama_prodi }}',
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

        new Chart(ctx3, {
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

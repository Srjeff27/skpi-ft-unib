<x-app-layout>
    <x-slot name="header">
        @php
            $hour = now()->timezone(config('app.timezone'))->format('H');
            if ($hour < 11) {
                $greet = 'Selamat Pagi';
            } elseif ($hour < 15) {
                $greet = 'Selamat Siang';
            } elseif ($hour < 18) {
                $greet = 'Selamat Sore';
            } else {
                $greet = 'Selamat Malam';
            }
            $name = auth()->user()?->name ?? 'Pengguna';
        @endphp
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ $greet }}, {{ $name }}
        </h2>
        <p class="text-sm text-gray-500">Dashboard</p>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Quick stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @php
                    $uid = auth()->id();
                    $total = \App\Models\Portfolio::where('user_id',$uid)->count();
                    $pending = \App\Models\Portfolio::where('user_id',$uid)->where('status','pending')->count();
                    $verified = \App\Models\Portfolio::where('user_id',$uid)->where('status','verified')->count();
                @endphp
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
                    <div class="text-sm text-gray-500">Total Portofolio</div>
                    <div class="mt-1 text-2xl font-semibold">{{ $total }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
                    <div class="text-sm text-gray-500">Menunggu Verifikasi</div>
                    <div class="mt-1 text-2xl font-semibold">{{ $pending }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
                    <div class="text-sm text-gray-500">Terverifikasi</div>
                    <div class="mt-1 text-2xl font-semibold">{{ $verified }}</div>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-800">Portofolio Terbaru</h3>
                <div class="space-x-2">
                    <a href="{{ route('student.portfolios.index') }}" class="rounded-md border border-[#1b3985] px-3 py-2 text-[#1b3985] hover:bg-blue-50">Lihat Semua</a>
                    <a href="{{ route('student.portfolios.create') }}" class="inline-flex items-center rounded-md bg-[#fa7516] px-3 py-2 text-white hover:bg-[#e5670c]">+ Upload</a>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @php $recent = \App\Models\Portfolio::where('user_id',$uid)->latest()->limit(5)->get(); @endphp
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="text-left text-gray-500">
                                <tr>
                                    <th class="py-2 pr-4">Judul</th>
                                    <th class="py-2 pr-4">Kategori</th>
                                    <th class="py-2 pr-4">Tanggal</th>
                                    <th class="py-2 pr-4">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse ($recent as $p)
                                <tr class="border-t border-gray-100">
                                    <td class="py-2 pr-4">{{ $p->judul_kegiatan }}</td>
                                    <td class="py-2 pr-4">{{ $p->kategori }}</td>
                                    <td class="py-2 pr-4">{{ $p->tanggal_mulai }}{{ $p->tanggal_selesai ? ' - ' . $p->tanggal_selesai : '' }}</td>
                                    <td class="py-2 pr-4">
                                        @php $colors = ['pending'=>'bg-yellow-100 text-yellow-700','verified'=>'bg-green-100 text-green-700','rejected'=>'bg-red-100 text-red-700']; @endphp
                                        <span class="px-2 py-1 rounded text-xs {{ $colors[$p->status] ?? 'bg-gray-100 text-gray-700' }}">{{ ucfirst($p->status) }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr><td class="py-6 text-center text-gray-500" colspan="4">Belum ada portofolio.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


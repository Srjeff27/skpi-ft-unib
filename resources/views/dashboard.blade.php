<x-app-layout>
    <x-slot name="header">
        @php
            $hour = now()->timezone(config('app.timezone'))->format('H');
            if ($hour > 3 && $hour < 11) {
                $greet = 'Selamat Pagi';
            } elseif ($hour > 11 && $hour < 15) {
                $greet = 'Selamat Siang';
            } elseif ($hour > 15 && $hour < 18) {
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

    {{-- Logika pengambilan data dipindahkan ke atas agar lebih rapi --}}
    @php
        $uid = auth()->id();
        $total = \App\Models\Portfolio::where('user_id', $uid)->count();
        $pending = \App\Models\Portfolio::where('user_id', $uid)->where('status', 'pending')->count();
        $verified = \App\Models\Portfolio::where('user_id', $uid)->where('status', 'verified')->count();
        $recent = \App\Models\Portfolio::where('user_id', $uid)->latest()->limit(5)->get();
    @endphp

    <div class="pt-10 pb-24 md:pb-10">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">


            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
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


            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h3 class="text-lg font-semibold text-gray-800">Portofolio Terbaru</h3>
                <div class="flex items-center space-x-2">
                    <a href="{{ route('student.portfolios.index') }}"
                        class="flex-grow sm:flex-grow-0 text-center rounded-md border border-[#1b3985] px-3 py-2 text-sm font-medium text-[#1b3985] hover:bg-blue-50">Lihat
                        Semua</a>
                    <a href="{{ route('student.portfolios.create') }}"
                        class="flex-grow sm:flex-grow-0 text-center inline-flex items-center justify-center rounded-md bg-[#fa7516] px-3 py-2 text-sm font-medium text-white hover:bg-[#e5670c]">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            class="w-5 h-5 mr-1">
                            <path
                                d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                        </svg>
                        Upload
                    </a>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="hidden sm:block">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="text-left text-gray-500">
                                <tr>
                                    <th class="p-4 font-medium">Judul</th>
                                    <th class="p-4 font-medium">Kategori</th>
                                    <th class="p-4 font-medium">Tanggal</th>
                                    <th class="p-4 font-medium">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recent as $p)
                                    <tr class="border-t border-gray-100">
                                        <td class="p-4 align-top">{{ $p->judul_kegiatan }}</td>
                                        <td class="p-4 align-top">{{ $p->kategori }}</td>
                                        <td class="p-4 align-top whitespace-nowrap">
                                            {{ \Carbon\Carbon::parse($p->tanggal_mulai)->isoFormat('D MMM YYYY') }}{{ $p->tanggal_selesai ? ' - ' . \Carbon\Carbon::parse($p->tanggal_selesai)->isoFormat('D MMM YYYY') : '' }}
                                        </td>
                                        <td class="p-4 align-top">
                                            @php $colors = ['pending'=>'bg-yellow-100 text-yellow-800','verified'=>'bg-green-100 text-green-800','rejected'=>'bg-red-100 text-red-800']; @endphp
                                            <span
                                                class="px-2 py-1 rounded-full text-xs font-medium {{ $colors[$p->status] ?? 'bg-gray-100 text-gray-800' }}">{{ ucfirst($p->status) }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="p-6 text-center text-gray-500" colspan="4">Belum ada portofolio.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="block sm:hidden p-4 space-y-4">
                    @forelse ($recent as $p)
                        <div class="border border-gray-200 rounded-lg p-4 space-y-3">
                            {{-- Judul dan Status --}}
                            <div class="flex justify-between items-start gap-4">
                                <h4 class="font-semibold text-gray-800">{{ $p->judul_kegiatan }}</h4>
                                @php $colors = ['pending'=>'bg-yellow-100 text-yellow-800','verified'=>'bg-green-100 text-green-800','rejected'=>'bg-red-100 text-red-800']; @endphp
                                <span
                                    class="flex-shrink-0 px-2 py-1 rounded-full text-xs font-medium {{ $colors[$p->status] ?? 'bg-gray-100 text-gray-800' }}">{{ ucfirst($p->status) }}</span>
                            </div>
                            {{-- Kategori --}}
                            <div>
                                <div class="text-xs text-gray-500">Kategori</div>
                                <div class="text-sm text-gray-700">{{ $p->kategori }}</div>
                            </div>
                            {{-- Tanggal --}}
                            <div>
                                <div class="text-xs text-gray-500">Tanggal</div>
                                <div class="text-sm text-gray-700">
                                    {{ \Carbon\Carbon::parse($p->tanggal_mulai)->isoFormat('D MMMM YYYY') }}{{ $p->tanggal_selesai ? ' - ' . \Carbon\Carbon::parse($p->tanggal_selesai)->isoFormat('D MMMM YYYY') : '' }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="py-6 text-center text-gray-500">Belum ada portofolio.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

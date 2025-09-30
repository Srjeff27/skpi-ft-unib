<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    @php
                        $hour = now()->timezone(config('app.timezone'))->format('H');
                        $greet =
                            $hour < 11
                                ? 'Selamat Pagi'
                                : ($hour < 15
                                    ? 'Selamat Siang'
                                    : ($hour < 18
                                        ? 'Selamat Sore'
                                        : 'Selamat Malam'));
                        $name = auth()->user()?->name ?? 'Pengguna';
                    @endphp
                    <h2 class="font-bold text-2xl text-gray-800 leading-tight">{{ $greet }}, {{ $name }}!</h2>
                    <p class="text-sm text-gray-500 mt-1">Kelola semua portofolio kegiatan Anda di halaman ini.</p>
                </div>
                <a href="{{ route('student.portfolios.create') }}"
                    class="w-full sm:w-auto inline-flex items-center justify-center rounded-lg bg-[#1b3985] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-800 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <x-heroicon-o-plus-circle class="w-5 h-5 mr-2" />
                    Upload Portofolio
                </a>
            </div>
        </div>
    </x-slot>

    <div class="pt-6 pb-24 sm:pt-8 sm:pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-6 rounded-lg border border-green-300 bg-green-50 p-4 text-sm text-green-800 shadow-sm">
                    {{ session('status') }}
                </div>
            @endif

            @if ($portfolios->isEmpty())
                {{-- Tampilan jika tidak ada portofolio --}}
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl text-center p-12">
                    <x-heroicon-o-document-duplicate class="mx-auto w-12 h-12 text-gray-300" />
                    <h3 class="mt-4 text-lg font-semibold text-gray-800">Anda Belum Memiliki Portofolio</h3>
                    <p class="mt-1 text-sm text-gray-500">Mulai kumpulkan prestasi dan pengalaman Anda sekarang.</p>
                    <a href="{{ route('student.portfolios.create') }}"
                        class="mt-6 inline-flex items-center rounded-lg bg-[#1b3985] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-800 transition-colors">
                        <x-heroicon-o-plus-circle class="w-5 h-5 mr-2" />
                        Upload Portofolio Pertama
                    </a>
                </div>
            @else
                {{-- TAMPILAN TABLET BESAR & DESKTOP --}}
                <div class="hidden md:block bg-white overflow-hidden shadow-lg sm:rounded-xl">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="text-left text-gray-500 bg-gray-50/75 border-b border-gray-200">
                                <tr>
                                    <th class="p-4 font-semibold">Judul Kegiatan</th>
                                    <th class="p-4 font-semibold">Kategori</th>
                                    <th class="p-4 font-semibold">Tanggal</th>
                                    <th class="p-4 font-semibold">Status</th>
                                    <th class="p-4 font-semibold text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($portfolios as $p)
                                    @include('student.portfolios._portfolio-row', ['portfolio' => $p])
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- TAMPILAN MOBILE & TABLET KECIL --}}
                <div class="block md:hidden space-y-4">
                    @foreach ($portfolios as $p)
                        @include('student.portfolios._portfolio-card', ['portfolio' => $p])
                    @endforeach
                </div>

                @if ($portfolios->hasPages())
                    <div class="mt-8">{{ $portfolios->links() }}</div>
                @endif
            @endif
        </div>
    </div>
</x-app-layout>

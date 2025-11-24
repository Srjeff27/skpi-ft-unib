<x-app-layout>
    <div class="space-y-6">
        {{-- Header --}}
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Dashboard Verifikator</h2>
            <p class="text-sm text-gray-500">Ringkasan data untuk Program Studi {{ auth()->user()->prodi->nama_prodi ?? '' }}</p>
        </div>

        {{-- Stat Cards --}}
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <x-heroicon-o-clock class="h-6 w-6 text-gray-400" />
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="truncate text-sm font-medium text-gray-500">Perlu Diverifikasi</dt>
                                <dd>
                                    <div class="text-lg font-bold text-gray-900">{{ $pending }}</div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <a href="{{ route('verifikator.portfolios.index', ['status' => 'pending']) }}" class="font-medium text-[#1b3985] hover:text-orange-500">Lihat semua</a>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <x-heroicon-o-check-circle class="h-6 w-6 text-gray-400" />
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="truncate text-sm font-medium text-gray-500">Telah Diverifikasi</dt>
                                <dd>
                                    <div class="text-lg font-bold text-gray-900">{{ $verified }}</div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <a href="{{ route('verifikator.portfolios.index', ['status' => 'verified']) }}" class="font-medium text-[#1b3985] hover:text-orange-500">Lihat semua</a>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <x-heroicon-o-users class="h-6 w-6 text-gray-400" />
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="truncate text-sm font-medium text-gray-500">Total Mahasiswa</dt>
                                <dd>
                                    <div class="text-lg font-bold text-gray-900">{{ $totalStudents }}</div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <a href="{{ route('verifikator.students.index') }}" class="font-medium text-[#1b3985] hover:text-orange-500">Lihat semua</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Pending Portfolios --}}
        <div>
            <h3 class="text-lg font-semibold text-gray-800">Menunggu Verifikasi Terbaru</h3>
            <div class="mt-4 flow-root">
                <div class="-my-2 overflow-x-auto">
                    <div class="inline-block min-w-full py-2 align-middle">
                        <div class="overflow-hidden rounded-xl border border-gray-100 shadow-sm">
                            <ul role="list" class="divide-y divide-gray-100">
                                @forelse ($recentPending as $portfolio)
                                    <li>
                                        <a href="{{ route('verifikator.portfolios.show', $portfolio) }}" class="flex items-center justify-between gap-x-6 px-5 py-4 hover:bg-gray-50">
                                            <div class="flex min-w-0 gap-x-4">
                                                <img class="h-12 w-12 flex-none rounded-full bg-gray-50 object-cover" src="{{ $portfolio->user->avatar_url }}" alt="">
                                                <div class="min-w-0 flex-auto">
                                                    <p class="text-sm font-semibold leading-6 text-gray-900">{{ $portfolio->user->name }}</p>
                                                    <p class="mt-1 truncate text-xs leading-5 text-gray-500">{{ $portfolio->nama_kegiatan }}</p>
                                                </div>
                                            </div>
                                            <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                                                <p class="text-sm leading-6 text-gray-900">Diajukan</p>
                                                <p class="mt-1 text-xs leading-5 text-gray-500">{{ $portfolio->created_at->diffForHumans() }}</p>
                                            </div>
                                            <x-heroicon-o-chevron-right class="h-5 w-5 flex-none text-gray-400" />
                                        </a>
                                    </li>
                                @empty
                                    <li class="px-5 py-8 text-center text-sm text-gray-500">
                                        <x-heroicon-o-circle-stack class="mx-auto h-10 w-10 text-gray-400" />
                                        <p class="mt-2 font-semibold">Tidak ada portofolio</p>
                                        <p>Semua portofolio yang perlu diverifikasi sudah selesai.</p>
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

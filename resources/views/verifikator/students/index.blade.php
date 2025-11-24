<x-app-layout>
    <div class="space-y-6">
        {{-- Header --}}
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Data Mahasiswa</h2>
            <p class="text-sm text-gray-500">Daftar mahasiswa pada Program Studi {{ auth()->user()->prodi->nama_prodi ?? '' }}.</p>
        </div>

        {{-- Filters and Search --}}
        <div class="rounded-xl border border-gray-100 bg-white p-4 shadow-sm">
            <form method="GET">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div class="sm:col-span-2">
                        <label for="search" class="sr-only">Cari</label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <x-heroicon-o-magnifying-glass class="h-5 w-5 text-gray-400" />
                            </div>
                            <input type="search" name="search" id="search" placeholder="Cari nama atau NIM mahasiswa..." value="{{ request('search') }}"
                                class="block w-full rounded-lg border-gray-200 pl-10 focus:border-[#1b3985] focus:ring-[#1b3985]">
                        </div>
                    </div>
                    <div>
                        <label for="angkatan" class="sr-only">Angkatan</label>
                        <select name="angkatan" id="angkatan" onchange="this.form.submit()"
                            class="block w-full rounded-lg border-gray-200 focus:border-[#1b3985] focus:ring-[#1b3985]">
                            <option value="">Semua Angkatan</option>
                            @foreach($angkatanList as $angkatan)
                                <option value="{{ $angkatan }}" @selected(request('angkatan') == $angkatan)>{{ $angkatan }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>

        {{-- Student Grid --}}
        @if ($students->count() > 0)
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                @foreach ($students as $student)
                    <div class="flex flex-col divide-y divide-gray-200 rounded-xl bg-white text-center shadow-sm border border-gray-100">
                        <div class="flex flex-1 flex-col p-8">
                            <img class="mx-auto h-24 w-24 flex-shrink-0 rounded-full object-cover" src="{{ $student->avatar_url }}" alt="Avatar">
                            <h3 class="mt-6 text-sm font-medium text-gray-900">{{ $student->name }}</h3>
                            <dl class="mt-1 flex flex-grow flex-col justify-between">
                                <dt class="sr-only">NIM</dt>
                                <dd class="text-sm text-gray-500">{{ $student->nim }}</dd>
                                <dt class="sr-only">Angkatan</dt>
                                <dd class="mt-3">
                                    <span class="inline-flex items-center rounded-full bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                        Angkatan {{ $student->angkatan }}
                                    </span>
                                </dd>
                            </dl>
                        </div>
                        <div>
                            <div class="-mt-px flex divide-x divide-gray-200">
                                <div class="flex w-0 flex-1">
                                    <a href="{{ route('verifikator.portfolios.index', ['user_id' => $student->id]) }}" 
                                       class="relative -mr-px inline-flex w-0 flex-1 items-center justify-center gap-x-3 rounded-bl-xl border border-transparent py-4 text-sm font-semibold text-gray-900 hover:bg-gray-50">
                                        <x-heroicon-o-folder-open class="h-5 w-5 text-gray-400" />
                                        Lihat Portofolio
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @if ($students->hasPages())
                <div class="mt-8">
                    {{ $students->links() }}
                </div>
            @endif
        @else
            <div class="text-center rounded-xl border-2 border-dashed border-gray-200 bg-white p-12">
                <x-heroicon-o-users class="mx-auto h-12 w-12 text-gray-400" />
                <h3 class="mt-2 text-sm font-semibold text-gray-900">Mahasiswa Tidak Ditemukan</h3>
                <p class="mt-1 text-sm text-gray-500">Tidak ada data mahasiswa yang cocok dengan pencarian atau filter Anda.</p>
            </div>
        @endif
    </div>
</x-app-layout>

<x-app-layout>
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Manajemen Verifikator</h2>
                <p class="text-sm text-gray-500">Tambah, edit, dan kelola akun dosen verifikator.</p>
            </div>
            <div>
                <a href="{{ route('admin.verifikators.create') }}"
                    class="inline-flex items-center gap-2 justify-center rounded-lg bg-[#1b3985] px-4 py-2 text-sm font-semibold text-white shadow-sm transition-all hover:bg-[#152c66] focus:outline-none focus:ring-2 focus:ring-[#1b3985] focus:ring-offset-2">
                    <x-heroicon-o-plus class="h-4 w-4" />
                    Tambah Verifikator
                </a>
            </div>
        </div>

        @if (session('status'))
            <x-toast type="success" :message="session('status')" />
        @endif

        {{-- Filters and Search --}}
        <div class="rounded-xl border border-gray-100 bg-white p-4 shadow-sm">
            <form method="GET">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <input type="search" name="search" placeholder="Cari nama atau email..." value="{{ request('search') }}"
                        class="w-full rounded-lg border-gray-200 focus:border-[#1b3985] focus:ring-[#1b3985] sm:col-span-1">
                    
                    <select name="prodi_id" class="w-full rounded-lg border-gray-200 focus:border-[#1b3985] focus:ring-[#1b3985]">
                        <option value="">Semua Prodi</option>
                        @foreach ($prodis as $p)
                            <option value="{{ $p->id }}" @selected(request('prodi_id') == $p->id)>{{ $p->nama_prodi }}</option>
                        @endforeach
                    </select>

                    <button type="submit"
                        class="inline-flex items-center gap-2 justify-center rounded-lg bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-700 transition-all hover:bg-gray-200">
                        <x-heroicon-o-magnifying-glass class="h-4 w-4" />
                        Filter
                    </button>
                </div>
            </form>
        </div>

        {{-- Verifikator List --}}
        <div class="flow-root">
            @if ($verifikators->count() > 0)
                <div class="divide-y divide-gray-100 rounded-xl border border-gray-100 bg-white shadow-sm">
                    {{-- Table Header --}}
                    <div class="hidden grid-cols-10 gap-4 bg-gray-50/75 px-4 py-2.5 text-xs font-semibold text-gray-500 md:grid">
                        <div class="col-span-4">Nama</div>
                        <div class="col-span-4">Email</div>
                        <div class="col-span-1">Prodi</div>
                        <div class="col-span-1"></div>
                    </div>
                    {{-- Table Body --}}
                    <div class="divide-y divide-gray-100">
                        @foreach ($verifikators as $verifier)
                            <div class="grid grid-cols-1 gap-4 px-4 py-4 text-sm md:grid-cols-10 md:gap-4 md:py-2">
                                {{-- Column 1: Name & Avatar --}}
                                <div class="flex items-center gap-3 md:col-span-4">
                                    <img src="{{ $verifier->avatar_url }}" alt="Avatar" class="h-9 w-9 rounded-full object-cover">
                                    <div>
                                        <div class="font-medium text-gray-800">{{ $verifier->name }}</div>
                                        <div class="text-gray-500 md:hidden">{{ $verifier->email }}</div>
                                    </div>
                                </div>
                                {{-- Column 2: Email (hidden on mobile) --}}
                                <div class="hidden items-center text-gray-600 md:col-span-4 md:flex">{{ $verifier->email }}</div>
                                {{-- Column 3: Prodi --}}
                                <div class="md:col-span-1"><span class="font-medium text-gray-500 md:hidden">Prodi: </span>{{ optional($verifier->prodi)->nama_prodi ?? '-' }}</div>
                                {{-- Column 4: Actions --}}
                                <div class="flex items-center justify-end md:col-span-1">
                                    <x-dropdown align="right" width="48">
                                        <x-slot name="trigger">
                                            <button class="rounded-full p-1.5 text-gray-500 hover:bg-gray-100 hover:text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-400">
                                                <x-heroicon-o-ellipsis-vertical class="h-5 w-5" />
                                            </button>
                                        </x-slot>
                                        <x-slot name="content">
                                            <x-dropdown-link :href="route('admin.verifikators.edit', $verifier)">
                                                Edit
                                            </x-dropdown-link>
                                            <form action="{{ route('admin.verifikators.destroy', $verifier) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus verifikator ini?')">
                                                @csrf @method('DELETE')
                                                <x-dropdown-link as="button" type="submit" class="text-red-600">
                                                    Hapus
                                                </x-dropdown-link>
                                            </form>
                                        </x-slot>
                                    </x-dropdown>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if ($verifikators->hasPages())
                        <div class="border-t p-4">
                            {{ $verifikators->links() }}
                        </div>
                    @endif
                </div>
            @else
                {{-- Empty State --}}
                <div class="text-center rounded-xl border-2 border-dashed border-gray-200 bg-white p-12">
                    <x-heroicon-o-user-group class="mx-auto h-12 w-12 text-gray-400" />
                    <h3 class="mt-2 text-sm font-semibold text-gray-900">Belum Ada Verifikator</h3>
                    <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan data verifikator baru.</p>
                    <div class="mt-6">
                        <a href="{{ route('admin.verifikators.create') }}"
                            class="inline-flex items-center gap-2 rounded-md bg-[#1b3985] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#152c66]">
                            <x-heroicon-o-plus class="h-4 w-4" />
                            Tambah Verifikator
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

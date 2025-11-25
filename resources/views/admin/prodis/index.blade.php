<x-app-layout>
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Manajemen Program Studi</h2>
                <p class="text-sm text-gray-500">Kelola data program studi di lingkungan Fakultas Teknik.</p>
            </div>
            <div>
                <a href="{{ route('admin.prodis.create') }}"
                    class="inline-flex items-center gap-2 justify-center rounded-lg bg-[#1b3985] px-4 py-2 text-sm font-semibold text-white shadow-sm transition-all hover:bg-[#152c66] focus:outline-none focus:ring-2 focus:ring-[#1b3985] focus:ring-offset-2">
                    <x-heroicon-o-plus class="h-4 w-4" />
                    Tambah Prodi
                </a>
            </div>
        </div>

        @if (session('status'))
            <x-toast type="success" :message="session('status')" />
        @endif

        @if (session('error'))
            <x-toast type="error" :message="session('error')" />
        @endif

        {{-- Search --}}
        <div class="rounded-xl border border-gray-100 bg-white p-4 shadow-sm">
            <form method="GET">
                <div class="flex items-center gap-4">
                    <input type="search" name="search" placeholder="Cari nama prodi atau jenjang..." value="{{ request('search') }}"
                        class="w-full rounded-lg border-gray-200 focus:border-[#1b3985] focus:ring-[#1b3985]">
                    <button type="submit"
                        class="inline-flex items-center gap-2 justify-center rounded-lg bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-700 transition-all hover:bg-gray-200">
                        <x-heroicon-o-magnifying-glass class="h-4 w-4" />
                        <span>Cari</span>
                    </button>
                </div>
            </form>
        </div>

        {{-- Study Programs List --}}
        <div class="flow-root">
            @if ($prodis->count() > 0)
                <div class="divide-y divide-gray-100 rounded-xl border border-gray-100 bg-white shadow-sm">
                    {{-- Table Header --}}
                    <div class="hidden grid-cols-10 gap-4 bg-gray-50/75 px-4 py-2.5 text-xs font-semibold text-gray-500 md:grid">
                        <div class="col-span-6">Nama Program Studi</div>
                        <div class="col-span-3">Jenjang</div>
                        <div class="col-span-1"></div>
                    </div>
                    {{-- Table Body --}}
                    <div class="divide-y divide-gray-100">
                        @foreach ($prodis as $prodi)
                            <div class="grid grid-cols-1 gap-4 px-4 py-4 text-sm md:grid-cols-10 md:gap-4 md:py-3">
                                {{-- Column 1: Name --}}
                                <div class="font-medium text-gray-800 md:col-span-6">{{ $prodi->nama_prodi }}</div>
                                {{-- Column 2: Jenjang --}}
                                <div class="md:col-span-3"><span class="font-medium text-gray-500 md:hidden">Jenjang: </span>{{ $prodi->jenjang }}</div>
                                {{-- Column 3: Actions --}}
                                <div class="flex items-center justify-end md:col-span-1">
                                    <x-dropdown align="right" width="48">
                                        <x-slot name="trigger">
                                            <button class="rounded-full p-1.5 text-gray-500 hover:bg-gray-100 hover:text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-400">
                                                <x-heroicon-o-ellipsis-vertical class="h-5 w-5" />
                                            </button>
                                        </x-slot>
                                        <x-slot name="content">
                                            <x-dropdown-link :href="route('admin.prodis.edit', $prodi)">
                                                Edit
                                            </x-dropdown-link>
                                            <form action="{{ route('admin.prodis.destroy', $prodi) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus prodi ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="block w-full px-4 py-2 text-start text-sm leading-5 text-red-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out">
                                                    Hapus
                                                </button>
                                            </form>
                                        </x-slot>
                                    </x-dropdown>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if ($prodis->hasPages())
                        <div class="border-t p-4">
                            {{ $prodis->links() }}
                        </div>
                    @endif
                </div>
            @else
                {{-- Empty State --}}
                <div class="text-center rounded-xl border-2 border-dashed border-gray-200 bg-white p-12">
                    <x-heroicon-o-academic-cap class="mx-auto h-12 w-12 text-gray-400" />
                    <h3 class="mt-2 text-sm font-semibold text-gray-900">Belum Ada Program Studi</h3>
                    <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan data program studi baru.</p>
                    <div class="mt-6">
                        <a href="{{ route('admin.prodis.create') }}"
                            class="inline-flex items-center gap-2 rounded-md bg-[#1b3985] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#152c66]">
                            <x-heroicon-o-plus class="h-4 w-4" />
                            Tambah Prodi
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Manajemen Kategori Portofolio</h2>
                <p class="text-sm text-gray-500">Kelola daftar kategori yang dapat dipilih mahasiswa.</p>
            </div>
            <div>
                <a href="{{ route('admin.portfolio-categories.create') }}"
                    class="inline-flex items-center gap-2 justify-center rounded-lg bg-[#1b3985] px-4 py-2 text-sm font-semibold text-white shadow-sm transition-all hover:bg-[#152c66] focus:outline-none focus:ring-2 focus:ring-[#1b3985] focus:ring-offset-2">
                    <x-heroicon-o-plus class="h-4 w-4" />
                    Tambah Kategori
                </a>
            </div>
        </div>

        @if (session('status'))
            <x-toast type="success" :message="session('status')" />
        @endif

        {{-- Search --}}
        <div class="rounded-xl border border-gray-100 bg-white p-4 shadow-sm">
            <form method="GET">
                <div class="flex items-center gap-4">
                    <input type="search" name="search" placeholder="Cari nama kategori..." value="{{ request('search') }}"
                        class="w-full rounded-lg border-gray-200 focus:border-[#1b3985] focus:ring-[#1b3985]">
                    <button type="submit"
                        class="inline-flex items-center gap-2 justify-center rounded-lg bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-700 transition-all hover:bg-gray-200">
                        <x-heroicon-o-magnifying-glass class="h-4 w-4" />
                        <span>Cari</span>
                    </button>
                </div>
            </form>
        </div>

        {{-- Categories List --}}
        <div class="flow-root">
            @if ($categories->count() > 0)
                <div class="divide-y divide-gray-100 rounded-xl border border-gray-100 bg-white shadow-sm">
                    <div class="divide-y divide-gray-100">
                        @foreach ($categories as $category)
                            <div class="flex flex-col gap-3 p-4 text-sm md:flex-row md:items-center md:justify-between">
                                <div class="font-medium text-gray-800">{{ $category->name }}</div>
                                <div class="flex flex-shrink-0 items-center justify-end gap-2">
                                    <a href="{{ route('admin.portfolio-categories.edit', $category) }}" class="rounded-lg bg-gray-50 px-3 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100">Edit</a>
                                    <form action="{{ route('admin.portfolio-categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus kategori ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="rounded-lg bg-red-50 px-3 py-2 text-sm font-semibold text-red-600 hover:bg-red-100">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if ($categories->hasPages())
                        <div class="border-t p-4">
                            {{ $categories->links() }}
                        </div>
                    @endif
                </div>
            @else
                {{-- Empty State --}}
                <div class="text-center rounded-xl border-2 border-dashed border-gray-200 bg-white p-12">
                    <x-heroicon-o-tag class="mx-auto h-12 w-12 text-gray-400" />
                    <h3 class="mt-2 text-sm font-semibold text-gray-900">Belum Ada Kategori</h3>
                    <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan kategori portofolio baru.</p>
                    <div class="mt-6">
                        <a href="{{ route('admin.portfolio-categories.create') }}"
                            class="inline-flex items-center gap-2 rounded-md bg-[#1b3985] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#152c66]">
                            <x-heroicon-o-plus class="h-4 w-4" />
                            Tambah Kategori
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

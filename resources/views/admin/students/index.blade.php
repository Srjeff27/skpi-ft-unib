<x-app-layout>
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Manajemen Mahasiswa</h2>
                <p class="text-sm text-gray-500">Tambah, edit, dan kelola data mahasiswa.</p>
            </div>
            <div>
                <a href="{{ route('admin.students.create') }}"
                    class="inline-flex items-center gap-2 justify-center rounded-lg bg-[#1b3985] px-4 py-2 text-sm font-semibold text-white shadow-sm transition-all hover:bg-[#152c66] focus:outline-none focus:ring-2 focus:ring-[#1b3985] focus:ring-offset-2">
                    <x-heroicon-o-plus class="h-4 w-4" />
                    Tambah Mahasiswa
                </a>
            </div>
        </div>

        @if (session('status'))
            <x-toast type="success" :message="session('status')" />
        @endif

        {{-- Filters and Search --}}
        <div class="rounded-xl border border-gray-100 bg-white p-4 shadow-sm">
            <form method="GET">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <input type="search" name="search" placeholder="Cari nama, email, atau NIM..." value="{{ request('search') }}"
                        class="w-full rounded-lg border-gray-200 focus:border-[#1b3985] focus:ring-[#1b3985]">
                    
                    <select name="prodi_id" class="w-full rounded-lg border-gray-200 focus:border-[#1b3985] focus:ring-[#1b3985]">
                        <option value="">Semua Prodi</option>
                        @foreach ($prodis as $p)
                            <option value="{{ $p->id }}" @selected(request('prodi_id') == $p->id)>{{ $p->nama_prodi }}</option>
                        @endforeach
                    </select>

                    <select name="angkatan" class="w-full rounded-lg border-gray-200 focus:border-[#1b3985] focus:ring-[#1b3985]">
                        <option value="">Semua Angkatan</option>
                        @foreach ($angkatanList as $a)
                            <option value="{{ $a }}" @selected(request('angkatan') == $a)>{{ $a }}</option>
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

        {{-- Student List --}}
        <div class="flow-root">
            @if ($students->count() > 0)
                <div class="divide-y divide-gray-100 rounded-xl border border-gray-100 bg-white shadow-sm">
                    {{-- Table Header --}}
                    <div class="hidden grid-cols-12 gap-4 bg-gray-50/75 px-4 py-2.5 text-xs font-semibold text-gray-500 md:grid">
                        <div class="col-span-3">Nama</div>
                        <div class="col-span-3">Email</div>
                        <div class="col-span-2">NIM</div>
                        <div class="col-span-2">Prodi</div>
                        <div class="col-span-1">Angkatan</div>
                        <div class="col-span-1"></div>
                    </div>
                    {{-- Table Body --}}
                    <div class="divide-y divide-gray-100">
                        @foreach ($students as $student)
                            <div class="grid grid-cols-1 gap-4 px-4 py-4 text-sm md:grid-cols-12 md:gap-4 md:py-2">
                                {{-- Column 1: Name & Avatar --}}
                                <div class="flex items-center gap-3 md:col-span-3">
                                    <img src="{{ $student->avatar_url }}" alt="Avatar" class="h-9 w-9 rounded-full object-cover">
                                    <div>
                                        <div class="font-medium text-gray-800">{{ $student->name }}</div>
                                        <div class="text-gray-500 md:hidden">{{ $student->email }}</div>
                                    </div>
                                </div>
                                {{-- Column 2: Email (hidden on mobile) --}}
                                <div class="hidden items-center text-gray-600 md:col-span-3 md:flex">{{ $student->email }}</div>
                                {{-- Column 3: NIM --}}
                                <div class="md:col-span-2"><span class="font-medium text-gray-500 md:hidden">NIM: </span>{{ $student->nim }}</div>
                                {{-- Column 4: Prodi --}}
                                <div class="md:col-span-2"><span class="font-medium text-gray-500 md:hidden">Prodi: </span>{{ optional($student->prodi)->nama_prodi ?? '-' }}</div>
                                {{-- Column 5: Angkatan --}}
                                <div class="md:col-span-1"><span class="font-medium text-gray-500 md:hidden">Angkatan: </span>{{ $student->angkatan }}</div>
                                {{-- Column 6: Actions --}}
                                <div class="flex items-center justify-end md:col-span-1">
                                    <x-dropdown align="right" width="48">
                                        <x-slot name="trigger">
                                            <button class="rounded-full p-1.5 text-gray-500 hover:bg-gray-100 hover:text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-400">
                                                <x-heroicon-o-ellipsis-vertical class="h-5 w-5" />
                                            </button>
                                        </x-slot>
                                        <x-slot name="content">
                                            <x-dropdown-link :href="route('admin.students.edit', $student)">
                                                Edit
                                            </x-dropdown-link>
                                            <form action="{{ route('admin.students.destroy', $student) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus mahasiswa ini?')">
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
                    @if ($students->hasPages())
                        <div class="border-t p-4">
                            {{ $students->links() }}
                        </div>
                    @endif
                </div>
            @else
                {{-- Empty State --}}
                <div class="text-center rounded-xl border-2 border-dashed border-gray-200 bg-white p-12">
                    <x-heroicon-o-users class="mx-auto h-12 w-12 text-gray-400" />
                    <h3 class="mt-2 text-sm font-semibold text-gray-900">Belum Ada Mahasiswa</h3>
                    <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan data mahasiswa baru.</p>
                    <div class="mt-6">
                        <a href="{{ route('admin.students.create') }}"
                            class="inline-flex items-center gap-2 rounded-md bg-[#1b3985] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#152c66]">
                            <x-heroicon-o-plus class="h-4 w-4" />
                            Tambah Mahasiswa
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <div class="space-y-6" x-data="{ showCreateModal: false }">
        {{-- Header --}}
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Manajemen Kurikulum & CPL</h2>
                <p class="text-sm text-gray-500">Kelola kurikulum dan Capaian Pembelajaran Lulusan per prodi.</p>
            </div>
        </div>

        @if (session('status'))
            <x-toast type="success" :message="session('status')" />
        @endif

        {{-- Prodi Selector --}}
        <div class="rounded-xl border border-gray-100 bg-white p-4 shadow-sm">
            <form method="GET" action="{{ route('admin.cpl.index') }}" class="flex flex-col gap-4 sm:flex-row sm:items-end sm:gap-3">
                <div class="flex-grow">
                    <label for="prodi_id" class="block text-sm font-medium text-gray-700">Pilih Program Studi</label>
                    <select name="prodi_id" id="prodi_id" onchange="this.form.submit()"
                        class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm focus:border-[#1b3985] focus:ring-[#1b3985]">
                        <option value="">-- Pilih --</option>
                        @foreach ($prodis as $p)
                            <option value="{{ $p->id }}" @selected($selectedProdiId == $p->id)>
                                {{ $p->nama_prodi }} ({{ $p->jenjang }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="button" @click="showCreateModal = true"
                    class="inline-flex items-center gap-2 justify-center rounded-lg bg-[#1b3985] px-4 py-2 text-sm font-semibold text-white shadow-sm transition-all hover:bg-[#152c66] focus:outline-none focus:ring-2 focus:ring-[#1b3985] focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                    :disabled="!{{ $selectedProdiId ? 'true' : 'false' }}">
                    <x-heroicon-o-plus class="h-4 w-4" />
                    Tambah Kurikulum
                </button>
            </form>
        </div>

        {{-- Curricula List --}}
        <div class="flow-root">
            @if ($selectedProdiId)
                @if ($curricula->count() > 0)
                    <div class="divide-y divide-gray-100 rounded-xl border border-gray-100 bg-white shadow-sm">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-800">Daftar Kurikulum: {{ $selectedProdi->nama_prodi }}</h3>
                        </div>
                        <div class="divide-y divide-gray-100">
                            @foreach ($curricula as $curriculum)
                                <div class="flex flex-col gap-3 p-4 text-sm md:flex-row md:items-center md:justify-between">
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-800">{{ $curriculum->name }}</p>
                                        <div class="flex items-center gap-4 text-gray-500">
                                            <span>Tahun: {{ $curriculum->year ?? '-' }}</span>
                                            @if ($curriculum->is_active)
                                                <span class="inline-flex items-center gap-1.5 rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-700">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-green-600"></span> Aktif
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex flex-shrink-0 items-center gap-2">
                                        <a href="{{ route('admin.cpl.manage', $curriculum) }}"
                                            class="inline-flex items-center gap-2 justify-center rounded-lg bg-gray-100 px-3 py-2 text-sm font-semibold text-gray-700 transition-all hover:bg-gray-200">
                                            Kelola CPL
                                        </a>
                                        <x-dropdown align="right" width="48">
                                            <x-slot name="trigger">
                                                <button class="rounded-full p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-400">
                                                    <x-heroicon-o-ellipsis-vertical class="h-5 w-5" />
                                                </button>
                                            </x-slot>
                                            <x-slot name="content">
                                                <x-dropdown-link :href="route('admin.cpl.curricula.edit', $curriculum)">Edit</x-dropdown-link>
                                                <form action="{{ route('admin.cpl.curricula.destroy', $curriculum) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus kurikulum ini? Seluruh CPL terkait akan ikut terhapus.')">
                                                    @csrf @method('DELETE')
                                                    <x-dropdown-link as="button" type="submit" class="text-red-600">Hapus</x-dropdown-link>
                                                </form>
                                            </x-slot>
                                        </x-dropdown>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    {{-- Empty State for selected prodi --}}
                    <div class="text-center rounded-xl border-2 border-dashed border-gray-200 bg-white p-12">
                        <x-heroicon-o-document-text class="mx-auto h-12 w-12 text-gray-400" />
                        <h3 class="mt-2 text-sm font-semibold text-gray-900">Belum Ada Kurikulum</h3>
                        <p class="mt-1 text-sm text-gray-500">Prodi ini belum memiliki kurikulum. Tambahkan sekarang.</p>
                    </div>
                @endif
            @else
                {{-- Empty State for no prodi selected --}}
                <div class="text-center rounded-xl border-2 border-dashed border-gray-200 bg-white p-12">
                    <x-heroicon-o-academic-cap class="mx-auto h-12 w-12 text-gray-400" />
                    <h3 class="mt-2 text-sm font-semibold text-gray-900">Pilih Program Studi</h3>
                    <p class="mt-1 text-sm text-gray-500">Silakan pilih program studi dari daftar di atas untuk melihat kurikulumnya.</p>
                </div>
            @endif
        </div>

        <!-- Modal Tambah Kurikulum -->
        <div x-show="showCreateModal" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
            <div @click.away="showCreateModal = false" class="w-full max-w-lg rounded-xl bg-white p-6 shadow-xl">
                <h3 class="text-lg font-semibold text-gray-800">Tambah Kurikulum Baru</h3>
                <p class="text-sm text-gray-500 mb-4">Untuk prodi: <span class="font-medium">{{ $selectedProdi->nama_prodi ?? '' }}</span></p>
                <form method="POST" action="{{ route('admin.cpl.curricula.store') }}" class="space-y-4">
                    @csrf
                    <input type="hidden" name="prodi_id" value="{{ $selectedProdiId }}">
                    <div>
                        <x-input-label for="name" value="Nama Kurikulum" />
                        <x-text-input id="name" name="name" class="mt-1 block w-full" required placeholder="Contoh: Kurikulum 2024 - MBKM" />
                    </div>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <x-input-label for="year" value="Tahun Berlaku" />
                            <x-text-input id="year" name="year" type="number" min="2000" max="2100" class="mt-1 block w-full" placeholder="Contoh: 2024" />
                        </div>
                        <div class="flex items-end pb-1">
                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-[#1b3985] shadow-sm focus:ring-[#1b3985]">
                                <span class="text-sm text-gray-700">Jadikan Aktif</span>
                            </label>
                        </div>
                    </div>
                    <div class="flex items-center justify-end gap-4 pt-4">
                        <button type="button" @click="showCreateModal = false" class="rounded-lg border border-gray-200 bg-white px-4 py-2 text-center text-sm font-medium text-gray-700 shadow-sm transition-all hover:bg-gray-50">Batal</button>
                        <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-[#1b3985] px-4 py-2 text-sm font-semibold text-white shadow-sm transition-all hover:bg-[#152c66]">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

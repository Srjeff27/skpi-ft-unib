<x-app-layout>
    <div x-data="{ activeTab: 'sikap', editItem: null, showEditModal: false }">
        {{-- Header --}}
        <div class="space-y-6">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <a href="{{ route('admin.cpl.index', ['prodi_id' => $curriculum->prodi_id]) }}"
                        class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-gray-800 mb-2">
                        <x-heroicon-o-arrow-left class="h-4 w-4" />
                        Kembali ke Daftar Kurikulum
                    </a>
                    <h2 class="text-2xl font-bold text-gray-800">Kelola CPL: {{ $curriculum->name }}</h2>
                    <p class="text-sm text-gray-500">{{ optional($curriculum->prodi)->nama_prodi }}</p>
                </div>
            </div>

            @if (session('status'))
                <x-toast type="success" :message="session('status')" />
            @endif
        </div>

        {{-- Main Content Grid --}}
        <div class="mt-6 grid grid-cols-1 gap-8 lg:grid-cols-3">
            {{-- Left Column: Add Form --}}
            <div class="lg:col-span-1">
                <div class="sticky top-6 rounded-xl border border-gray-100 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-800">Tambah CPL Baru</h3>
                    <form method="POST" action="{{ route('admin.cpl.items.store', $curriculum) }}" class="mt-4 space-y-4">
                        @csrf
                        <div>
                            <x-input-label for="category" value="Kategori CPL" />
                            <select id="category" name="category" required class="mt-1 block w-full rounded-lg border-gray-200 text-gray-700 shadow-sm focus:border-[#1b3985] focus:ring-[#1b3985]">
                                <option value="sikap">Sikap</option>
                                <option value="pengetahuan">Penguasaan Pengetahuan</option>
                                <option value="umum">Keterampilan Umum</option>
                                <option value="khusus">Keterampilan Khusus</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="code" value="Kode (Opsional)" />
                                <x-text-input id="code" name="code" class="mt-1 block w-full" placeholder="S1" />
                            </div>
                            <div>
                                <x-input-label for="order" value="Urutan (Opsional)" />
                                <x-text-input id="order" name="order" type="number" min="0" class="mt-1 block w-full" placeholder="1" />
                            </div>
                        </div>
                        <div>
                            <x-input-label for="desc_id" value="Deskripsi (Indonesia)" />
                            <textarea id="desc_id" name="desc_id" rows="4" required class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm focus:border-[#1b3985] focus:ring-[#1b3985]"></textarea>
                        </div>
                        <div>
                            <x-input-label for="desc_en" value="Deskripsi (English)" />
                            <textarea id="desc_en" name="desc_en" rows="4" class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm focus:border-[#1b3985] focus:ring-[#1b3985]"></textarea>
                        </div>
                        <div class="flex justify-end pt-2">
                            <button type="submit" class="inline-flex items-center gap-2 justify-center rounded-lg bg-[#1b3985] px-4 py-2 text-sm font-semibold text-white shadow-sm transition-all hover:bg-[#152c66]">
                                Simpan CPL
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Right Column: CPL List --}}
            <div class="lg:col-span-2">
                <div class="rounded-xl border border-gray-100 bg-white shadow-sm">
                    {{-- Tabs --}}
                    <div class="border-b border-gray-200">
                        <nav class="-mb-px flex gap-4 px-6" aria-label="Tabs">
                            @foreach ($itemsByCategory as $category => $items)
                                <button @click="activeTab = '{{ $category }}'"
                                    :class="activeTab === '{{ $category }}' ? 'border-[#1b3985] text-[#1b3985]' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'"
                                    class="whitespace-nowrap border-b-2 py-3 px-1 text-sm font-medium">
                                    {{ ucfirst($category) }} <span class="ml-1 rounded-full bg-gray-100 px-2 py-0.5 text-xs">{{ $items->count() }}</span>
                                </button>
                            @endforeach
                        </nav>
                    </div>

                    {{-- Tab Content --}}
                    <div class="p-6">
                        @foreach ($itemsByCategory as $category => $items)
                            <div x-show="activeTab === '{{ $category }}'" class="flow-root">
                                @if ($items->count() > 0)
                                    <ul class="divide-y divide-gray-100">
                                        @foreach ($items as $item)
                                            <li class="flex flex-col gap-3 py-4 text-sm md:flex-row md:items-center md:justify-between">
                                                <div class="flex-1 space-y-1">
                                                    <div class="flex items-center gap-3">
                                                        @if($item->code)
                                                            <span class="font-mono text-xs rounded bg-gray-100 px-1.5 py-0.5 font-semibold text-gray-600">{{ $item->code }}</span>
                                                        @endif
                                                        <p class="text-gray-800">{{ $item->desc_id }}</p>
                                                    </div>
                                                    <p class="pl-1 text-gray-500 text-xs">{{ $item->desc_en }}</p>
                                                </div>
                                                <div class="flex flex-shrink-0 items-center justify-end gap-2">
                                                    <button @click="editItem = {{ $item->toJson() }}; showEditModal = true" class="rounded-lg bg-gray-50 px-3 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100">Edit</button>
                                                    <form action="{{ route('admin.cpl.items.destroy', $item) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus CPL ini?')">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="rounded-lg bg-red-50 px-3 py-2 text-sm font-semibold text-red-600 hover:bg-red-100">Hapus</button>
                                                    </form>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <div class="text-center rounded-xl border-2 border-dashed border-gray-200 p-12">
                                        <x-heroicon-o-document-magnifying-glass class="mx-auto h-12 w-12 text-gray-400" />
                                        <h3 class="mt-2 text-sm font-semibold text-gray-900">Belum Ada CPL</h3>
                                        <p class="mt-1 text-sm text-gray-500">Belum ada data CPL untuk kategori ini.</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit CPL Item -->
        <div x-show="showEditModal" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
            <div @click.away="showEditModal = false" class="w-full max-w-lg rounded-xl bg-white p-6 shadow-xl">
                <h3 class="text-lg font-semibold text-gray-800">Edit CPL</h3>
                <template x-if="editItem">
                    <form :action="`/admin/cpl/items/${editItem.id}`" method="POST" class="mt-4 space-y-4">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="category" :value="editItem.category">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="edit_code" value="Kode (Opsional)" />
                                <x-text-input id="edit_code" name="code" class="mt-1 block w-full" x-model="editItem.code" />
                            </div>
                            <div>
                                <x-input-label for="edit_order" value="Urutan (Opsional)" />
                                <x-text-input id="edit_order" name="order" type="number" min="0" class="mt-1 block w-full" x-model="editItem.order" />
                            </div>
                        </div>
                        <div>
                            <x-input-label for="edit_desc_id" value="Deskripsi (Indonesia)" />
                            <textarea id="edit_desc_id" name="desc_id" rows="4" required class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm" x-model="editItem.desc_id"></textarea>
                        </div>
                        <div>
                            <x-input-label for="edit_desc_en" value="Deskripsi (English)" />
                            <textarea id="edit_desc_en" name="desc_en" rows="4" class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm" x-model="editItem.desc_en"></textarea>
                        </div>
                        <div class="flex items-center justify-end gap-4 pt-2">
                            <button type="button" @click="showEditModal = false" class="rounded-lg border border-gray-200 bg-white px-4 py-2 text-center text-sm font-medium text-gray-700">Batal</button>
                            <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-[#1b3985] px-4 py-2 text-sm font-semibold text-white">Perbarui CPL</button>
                        </div>
                    </form>
                </template>
            </div>
        </div>
    </div>
</x-app-layout>

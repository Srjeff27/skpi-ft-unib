<x-app-layout>
    <div x-data="{ activeTab: 'sikap', editItem: null, showEditModal: false }" class="space-y-8 pb-20">
        
        {{-- Header Section --}}
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <a href="{{ route('admin.cpl.index', ['prodi_id' => $curriculum->prodi_id]) }}" 
                   class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-[#1b3985] transition-colors mb-2">
                    <x-heroicon-m-arrow-long-left class="w-5 h-5" />
                    Kembali ke Daftar Kurikulum
                </a>
                <h2 class="text-2xl font-bold tracking-tight text-slate-900">
                    Kelola CPL: <span class="text-[#1b3985]">{{ $curriculum->name }}</span>
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    {{ optional($curriculum->prodi)->nama_prodi }} &bull; Tahun {{ $curriculum->year }}
                </p>
            </div>
        </div>

        @if (session('status'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
                 class="flex items-center gap-3 rounded-xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-emerald-700 shadow-sm">
                <x-heroicon-s-check-circle class="h-5 w-5" />
                <span class="text-sm font-medium">{{ session('status') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-12 items-start">
            
            {{-- Left Column: Sticky Add Form --}}
            <div class="lg:col-span-4 lg:sticky lg:top-24">
                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4">
                        <h3 class="font-bold text-slate-800 flex items-center gap-2">
                            <x-heroicon-o-plus-circle class="w-5 h-5 text-[#1b3985]" />
                            Tambah CPL Baru
                        </h3>
                    </div>
                    <form method="POST" action="{{ route('admin.cpl.items.store', $curriculum) }}" class="p-6 space-y-5">
                        @csrf
                        
                        <div>
                            <x-input-label for="category" value="Kategori Capaian" />
                            <div class="relative mt-1">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <x-heroicon-o-tag class="h-5 w-5 text-slate-400" />
                                </div>
                                <select id="category" name="category" required 
                                        class="block w-full rounded-xl border-slate-300 pl-10 focus:border-[#1b3985] focus:ring-[#1b3985] sm:text-sm">
                                    <option value="sikap">Sikap</option>
                                    <option value="pengetahuan">Penguasaan Pengetahuan</option>
                                    <option value="umum">Keterampilan Umum</option>
                                    <option value="khusus">Keterampilan Khusus</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="code" value="Kode (Cth: S1)" />
                                <input type="text" id="code" name="code" 
                                       class="mt-1 block w-full rounded-xl border-slate-300 focus:border-[#1b3985] focus:ring-[#1b3985] sm:text-sm" 
                                       placeholder="S1">
                            </div>
                            <div>
                                <x-input-label for="order" value="Urutan" />
                                <input type="number" id="order" name="order" min="0" 
                                       class="mt-1 block w-full rounded-xl border-slate-300 focus:border-[#1b3985] focus:ring-[#1b3985] sm:text-sm" 
                                       placeholder="1">
                            </div>
                        </div>

                        <div>
                            <x-input-label for="desc_id" value="Deskripsi (Indonesia)" />
                            <textarea id="desc_id" name="desc_id" rows="3" required 
                                      class="mt-1 block w-full rounded-xl border-slate-300 focus:border-[#1b3985] focus:ring-[#1b3985] sm:text-sm" 
                                      placeholder="Mampu menerapkan pemikiran logis..."></textarea>
                        </div>

                        <div>
                            <x-input-label for="desc_en" value="Deskripsi (Inggris)" />
                            <textarea id="desc_en" name="desc_en" rows="3" 
                                      class="mt-1 block w-full rounded-xl border-slate-300 focus:border-[#1b3985] focus:ring-[#1b3985] sm:text-sm" 
                                      placeholder="Able to apply logical thinking..."></textarea>
                        </div>

                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-[#1b3985] px-4 py-2.5 text-sm font-bold text-white shadow-lg shadow-blue-900/20 transition-all hover:bg-[#152c66] hover:shadow-blue-900/40 hover:-translate-y-0.5">
                            <x-heroicon-m-check class="w-5 h-5" />
                            Simpan CPL
                        </button>
                    </form>
                </div>
            </div>

            {{-- Right Column: CPL List --}}
            <div class="lg:col-span-8">
                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm min-h-[600px]">
                    
                    {{-- Tabs Navigation --}}
                    <div class="border-b border-slate-200 bg-slate-50/50 px-2">
                        <nav class="-mb-px flex gap-6 overflow-x-auto" aria-label="Tabs">
                            @foreach ($itemsByCategory as $category => $items)
                                <button @click="activeTab = '{{ $category }}'"
                                    :class="activeTab === '{{ $category }}' 
                                        ? 'border-[#1b3985] text-[#1b3985]' 
                                        : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700'"
                                    class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-semibold transition-colors flex items-center gap-2">
                                    {{ ucfirst($category) }}
                                    <span :class="activeTab === '{{ $category }}' ? 'bg-blue-100 text-blue-700' : 'bg-slate-200 text-slate-600'" 
                                          class="rounded-full px-2 py-0.5 text-xs transition-colors">
                                        {{ $items->count() }}
                                    </span>
                                </button>
                            @endforeach
                        </nav>
                    </div>

                    {{-- Tab Content --}}
                    <div class="p-0">
                        @foreach ($itemsByCategory as $category => $items)
                            <div x-show="activeTab === '{{ $category }}'" x-cloak>
                                @if ($items->count() > 0)
                                    <div class="divide-y divide-slate-100">
                                        @foreach ($items as $item)
                                            <div class="group flex flex-col gap-4 p-5 transition-colors hover:bg-slate-50 sm:flex-row sm:items-start">
                                                
                                                {{-- Code Badge --}}
                                                <div class="shrink-0 pt-1">
                                                    <span class="inline-flex h-8 w-10 items-center justify-center rounded-lg bg-slate-100 font-mono text-sm font-bold text-slate-700 border border-slate-200">
                                                        {{ $item->code ?? '-' }}
                                                    </span>
                                                </div>

                                                {{-- Descriptions --}}
                                                <div class="flex-1 space-y-2">
                                                    <p class="text-sm font-medium text-slate-800 leading-relaxed">
                                                        {{ $item->desc_id }}
                                                    </p>
                                                    @if($item->desc_en)
                                                        <div class="flex gap-2 items-start">
                                                            <span class="shrink-0 mt-0.5 text-[10px] uppercase font-bold text-slate-400 bg-slate-100 px-1.5 rounded">EN</span>
                                                            <p class="text-sm text-slate-500 italic leading-relaxed">
                                                                {{ $item->desc_en }}
                                                            </p>
                                                        </div>
                                                    @endif
                                                </div>

                                                {{-- Actions --}}
                                                <div class="flex items-center gap-1 sm:flex-col sm:items-end opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity">
                                                    <button @click="editItem = {{ $item->toJson() }}; showEditModal = true" 
                                                            class="p-2 text-slate-400 hover:text-[#1b3985] hover:bg-blue-50 rounded-lg transition-colors"
                                                            title="Edit">
                                                        <x-heroicon-m-pencil-square class="w-5 h-5" />
                                                    </button>
                                                    
                                                    <form action="{{ route('admin.cpl.items.destroy', $item) }}" method="POST" 
                                                          onsubmit="return confirm('Hapus poin CPL ini?')">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" 
                                                                class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors"
                                                                title="Hapus">
                                                            <x-heroicon-m-trash class="w-5 h-5" />
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="flex flex-col items-center justify-center py-20 text-center">
                                        <div class="rounded-full bg-slate-50 p-4 ring-1 ring-slate-100">
                                            <x-heroicon-o-document-magnifying-glass class="h-10 w-10 text-slate-400" />
                                        </div>
                                        <h3 class="mt-4 text-sm font-semibold text-slate-900">Belum Ada CPL</h3>
                                        <p class="mt-1 text-sm text-slate-500">Tambahkan poin CPL untuk kategori ini melalui form di sebelah kiri.</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Edit Modal --}}
        <div x-show="showEditModal" style="display: none;"
             class="fixed inset-0 z-50 flex items-center justify-center px-4 sm:px-6" x-cloak>
            
            <div x-show="showEditModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" 
                 @click="showEditModal = false">
            </div>

            <div x-show="showEditModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-2xl ring-1 ring-black/5">
                
                <div class="bg-[#1b3985] px-6 py-4 text-white flex justify-between items-center">
                    <h3 class="text-lg font-bold">Edit Poin CPL</h3>
                    <button @click="showEditModal = false" class="text-white/70 hover:text-white transition-colors">
                        <x-heroicon-m-x-mark class="h-6 w-6" />
                    </button>
                </div>

                <template x-if="editItem">
                    <form :action="`/admin/cpl/items/${editItem.id}`" method="POST" class="p-6 space-y-5">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="category" :value="editItem.category">
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="edit_code" value="Kode" />
                                <input type="text" id="edit_code" name="code" x-model="editItem.code"
                                       class="mt-1 block w-full rounded-xl border-slate-300 focus:border-[#1b3985] focus:ring-[#1b3985] sm:text-sm">
                            </div>
                            <div>
                                <x-input-label for="edit_order" value="Urutan" />
                                <input type="number" id="edit_order" name="order" min="0" x-model="editItem.order"
                                       class="mt-1 block w-full rounded-xl border-slate-300 focus:border-[#1b3985] focus:ring-[#1b3985] sm:text-sm">
                            </div>
                        </div>

                        <div>
                            <x-input-label for="edit_desc_id" value="Deskripsi (Indonesia)" />
                            <textarea id="edit_desc_id" name="desc_id" rows="4" required x-model="editItem.desc_id"
                                      class="mt-1 block w-full rounded-xl border-slate-300 focus:border-[#1b3985] focus:ring-[#1b3985] sm:text-sm"></textarea>
                        </div>

                        <div>
                            <x-input-label for="edit_desc_en" value="Deskripsi (Inggris)" />
                            <textarea id="edit_desc_en" name="desc_en" rows="4" x-model="editItem.desc_en"
                                      class="mt-1 block w-full rounded-xl border-slate-300 focus:border-[#1b3985] focus:ring-[#1b3985] sm:text-sm"></textarea>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-2">
                            <button type="button" @click="showEditModal = false" 
                                    class="rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">
                                Batal
                            </button>
                            <button type="submit" 
                                    class="inline-flex items-center gap-2 rounded-xl bg-[#1b3985] px-6 py-2.5 text-sm font-bold text-white shadow-md hover:bg-[#152c66] hover:shadow-lg transition-all">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </template>
            </div>
        </div>

    </div>
</x-app-layout>
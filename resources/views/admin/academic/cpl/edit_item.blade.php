<x-app-layout>
    {{-- Header Navigation --}}
    <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <div class="flex items-center gap-2 text-sm text-slate-500 mb-1">
                <span>{{ optional($curriculum->prodi)->nama_prodi }}</span>
                <x-heroicon-m-chevron-right class="h-3 w-3" />
                <span>{{ $curriculum->name }}</span>
            </div>
            <h2 class="text-2xl font-bold text-slate-900">Edit Capaian Pembelajaran</h2>
        </div>
        <a href="{{ route('admin.cpl.manage', $curriculum->id) }}" 
           class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition-all hover:bg-slate-50 hover:text-slate-900">
            <x-heroicon-m-arrow-left class="h-4 w-4" />
            Kembali
        </a>
    </div>

    <div class="max-w-4xl mx-auto">
        <form method="POST" action="{{ route('admin.cpl.items.update', $item) }}">
            @csrf
            @method('PUT')

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                
                {{-- Card Header --}}
                <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <x-heroicon-o-pencil-square class="h-5 w-5 text-[#1b3985]" />
                        Detail CPL
                    </h3>
                </div>

                <div class="p-6 sm:p-8 space-y-6">
                    
                    {{-- Row 1: Kategori, Kode, Urutan --}}
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-12">
                        {{-- Kategori --}}
                        <div class="md:col-span-6">
                            <x-input-label for="category" value="Kategori CPL" />
                            <div class="relative mt-1">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <x-heroicon-o-tag class="h-5 w-5 text-slate-400" />
                                </div>
                                <select name="category" id="category"
                                        class="block w-full rounded-xl border-slate-300 pl-10 focus:border-[#1b3985] focus:ring-[#1b3985] sm:text-sm bg-white">
                                    @foreach(['sikap'=>'Sikap', 'pengetahuan'=>'Penguasaan Pengetahuan', 'umum'=>'Keterampilan Umum', 'khusus'=>'Keterampilan Khusus'] as $k=>$v)
                                        <option value="{{ $k }}" @selected(old('category', $item->category) === $k)>{{ $v }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <x-input-error :messages="$errors->get('category')" class="mt-2" />
                        </div>

                        {{-- Kode --}}
                        <div class="md:col-span-3">
                            <x-input-label for="code" value="Kode (Cth: S1)" />
                            <div class="relative mt-1">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <x-heroicon-o-hashtag class="h-5 w-5 text-slate-400" />
                                </div>
                                <input type="text" name="code" id="code" value="{{ old('code', $item->code) }}"
                                       class="block w-full rounded-xl border-slate-300 pl-10 focus:border-[#1b3985] focus:ring-[#1b3985] sm:text-sm" placeholder="S1">
                            </div>
                        </div>

                        {{-- Urutan --}}
                        <div class="md:col-span-3">
                            <x-input-label for="order" value="Urutan Tampil" />
                            <div class="relative mt-1">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <x-heroicon-o-queue-list class="h-5 w-5 text-slate-400" />
                                </div>
                                <input type="number" name="order" id="order" value="{{ old('order', $item->order) }}" min="0"
                                       class="block w-full rounded-xl border-slate-300 pl-10 focus:border-[#1b3985] focus:ring-[#1b3985] sm:text-sm" placeholder="1">
                            </div>
                        </div>
                    </div>

                    <hr class="border-slate-100">

                    {{-- Row 2: Deskripsi --}}
                    <div class="space-y-6">
                        <div>
                            <x-input-label for="desc_id" value="Deskripsi (Bahasa Indonesia)" />
                            <div class="relative mt-1">
                                <textarea name="desc_id" id="desc_id" rows="4" required
                                          class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-[#1b3985] focus:ring-[#1b3985] sm:text-sm p-4"
                                          placeholder="Masukkan deskripsi capaian pembelajaran...">{{ old('desc_id', $item->desc_id) }}</textarea>
                                <div class="absolute top-3 right-3 text-slate-300">
                                    <span class="text-[10px] font-bold bg-slate-100 px-2 py-1 rounded">ID</span>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('desc_id')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="desc_en" value="Description (English)" />
                            <div class="relative mt-1">
                                <textarea name="desc_en" id="desc_en" rows="4"
                                          class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-[#1b3985] focus:ring-[#1b3985] sm:text-sm p-4 italic text-slate-600 bg-slate-50/30"
                                          placeholder="Enter learning outcome description...">{{ old('desc_en', $item->desc_en) }}</textarea>
                                <div class="absolute top-3 right-3 text-slate-300">
                                    <span class="text-[10px] font-bold bg-blue-50 text-blue-600 px-2 py-1 rounded border border-blue-100">EN</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Footer Actions --}}
                <div class="flex items-center justify-end gap-4 border-t border-slate-100 bg-slate-50 px-6 py-4">
                    <a href="{{ route('admin.cpl.manage', $curriculum->id) }}" 
                       class="rounded-xl px-5 py-2.5 text-sm font-semibold text-slate-600 transition-colors hover:bg-white hover:text-slate-900 hover:shadow-sm ring-1 ring-transparent hover:ring-slate-200">
                        Batal
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center gap-2 rounded-xl bg-[#1b3985] px-6 py-2.5 text-sm font-bold text-white shadow-lg shadow-blue-900/20 transition-all hover:bg-[#152c66] hover:shadow-blue-900/40 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <x-heroicon-m-check class="h-5 w-5" />
                        Simpan Perubahan
                    </button>
                </div>

            </div>
        </form>
    </div>
</x-app-layout>
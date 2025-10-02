<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">Edit CPL</h2>
        <p class="text-sm text-gray-500">{{ optional($curriculum->prodi)->nama_prodi }} ({{ optional($curriculum->prodi)->jenjang }}) — {{ $curriculum->name }}</p>
    </x-slot>

    <div class="pt-8 pb-16">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                <form method="POST" action="{{ route('admin.cpl.items.update', $item) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="text-xs text-gray-600">Kategori</label>
                        <select name="category" class="mt-1 w-full rounded-md border-gray-300">
                            @foreach(['sikap'=>'Sikap','pengetahuan'=>'Penguasaan Pengetahuan','umum'=>'Keterampilan Umum','khusus'=>'Keterampilan Khusus'] as $k=>$v)
                                <option value="{{ $k }}" @selected(old('category', $item->category)===$k)>{{ $v }}</option>
                            @endforeach
                        </select>
                        @error('category')<div class="text-xs text-red-600 mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs text-gray-600">Kode (opsional)</label>
                            <input type="text" name="code" value="{{ old('code', $item->code) }}" class="mt-1 w-full rounded-md border-gray-300" />
                        </div>
                        <div>
                            <label class="text-xs text-gray-600">Urutan (opsional)</label>
                            <input type="number" name="order" value="{{ old('order', $item->order) }}" min="0" class="mt-1 w-full rounded-md border-gray-300" />
                        </div>
                    </div>

                    <div>
                        <label class="text-xs text-gray-600">Deskripsi (Indonesia)</label>
                        <textarea name="desc_id" rows="4" class="mt-1 w-full rounded-md border-gray-300" required>{{ old('desc_id', $item->desc_id) }}</textarea>
                        @error('desc_id')<div class="text-xs text-red-600 mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="text-xs text-gray-600">Description (English)</label>
                        <textarea name="desc_en" rows="4" class="mt-1 w-full rounded-md border-gray-300">{{ old('desc_en', $item->desc_en) }}</textarea>
                    </div>

                    <div class="pt-2 flex gap-2">
                        <a href="{{ route('admin.cpl.manage', $curriculum->id) }}" class="px-4 py-2 rounded-md bg-gray-100 text-gray-700">Batal</a>
                        <button class="px-4 py-2 rounded-md bg-[#1b3985] text-white">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>


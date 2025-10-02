<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">Edit Kurikulum</h2>
        <p class="text-sm text-gray-500">{{ optional($curriculum->prodi)->nama_prodi }} ({{ optional($curriculum->prodi)->jenjang }})</p>
    </x-slot>

    <div class="pt-8 pb-16">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                <form method="POST" action="{{ route('admin.cpl.curricula.update', $curriculum) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="text-xs text-gray-600">Nama Kurikulum</label>
                        <input type="text" name="name" value="{{ old('name', $curriculum->name) }}" required class="mt-1 w-full rounded-md border-gray-300" />
                        @error('name')<div class="text-xs text-red-600 mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs text-gray-600">Tahun Berlaku</label>
                            <input type="number" name="year" min="1900" max="2100" value="{{ old('year', $curriculum->year) }}" class="mt-1 w-full rounded-md border-gray-300" />
                            @error('year')<div class="text-xs text-red-600 mt-1">{{ $message }}</div>@enderror
                        </div>
                        <label class="flex items-center gap-2 mt-6">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $curriculum->is_active) ? 'checked' : '' }} class="rounded border-gray-300">
                            Jadikan Aktif
                        </label>
                    </div>

                    <div class="pt-2 flex gap-2">
                        <a href="{{ route('admin.cpl.index', ['prodi_id'=>$curriculum->prodi_id]) }}" class="px-4 py-2 rounded-md bg-gray-100 text-gray-700">Batal</a>
                        <button class="px-4 py-2 rounded-md bg-[#1b3985] text-white">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>


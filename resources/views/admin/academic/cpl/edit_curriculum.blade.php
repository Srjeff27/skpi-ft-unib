<x-app-layout>
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <a href="{{ route('admin.cpl.index', ['prodi_id' => $curriculum->prodi_id]) }}"
                    class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-gray-800 mb-2">
                    <x-heroicon-o-arrow-left class="h-4 w-4" />
                    Kembali
                </a>
                <h2 class="text-2xl font-bold text-gray-800">Edit Kurikulum</h2>
                <p class="text-sm text-gray-500">
                    Perbarui detail untuk kurikulum <span class="font-medium">{{ $curriculum->name }}</span>.
                </p>
            </div>
        </div>

        <div class="max-w-2xl mx-auto">
            <form method="POST" action="{{ route('admin.cpl.curricula.update', $curriculum) }}"
                class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm space-y-6">
                @csrf
                @method('PUT')

                {{-- Form Fields --}}
                <div>
                    <x-input-label for="name" value="Nama Kurikulum" />
                    <x-text-input id="name" name="name" class="mt-1 block w-full" 
                        :value="old('name', $curriculum->name)" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <x-input-label for="year" value="Tahun Berlaku" />
                        <x-text-input id="year" name="year" type="number" min="2000" max="2100" 
                            class="mt-1 block w-full" :value="old('year', $curriculum->year)" />
                        <x-input-error :messages="$errors->get('year')" class="mt-2" />
                    </div>
                    <div class="flex items-end pb-1">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $curriculum->is_active))
                                class="h-4 w-4 rounded border-gray-300 text-[#1b3985] shadow-sm focus:ring-[#1b3985]">
                            <span class="text-sm text-gray-700">Jadikan Aktif</span>
                        </label>
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="flex items-center justify-end gap-4 pt-4">
                    <a href="{{ route('admin.cpl.index', ['prodi_id' => $curriculum->prodi_id]) }}"
                        class="rounded-lg border border-gray-200 bg-white px-4 py-2 text-center text-sm font-medium text-gray-700 shadow-sm transition-all hover:bg-gray-50">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center gap-2 justify-center rounded-lg bg-[#1b3985] px-4 py-2 text-sm font-semibold text-white shadow-sm transition-all hover:bg-[#152c66]">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

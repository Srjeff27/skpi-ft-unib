<x-app-layout>
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">{{ $category->exists ? 'Edit' : 'Tambah' }} Kategori</h2>
                <p class="text-sm text-gray-500">
                    {{ $category->exists ? 'Perbarui nama kategori portofolio.' : 'Buat kategori portofolio baru.' }}
                </p>
            </div>
        </div>

        <div class="max-w-2xl mx-auto">
            <form method="POST"
                action="{{ $category->exists ? route('admin.portfolio-categories.update', $category) : route('admin.portfolio-categories.store') }}"
                class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm space-y-6">
                @csrf
                @if ($category->exists)
                    @method('PUT')
                @endif

                {{-- Form Fields --}}
                <div>
                    <x-input-label for="name" value="Nama Kategori" />
                    <x-text-input id="name" name="name" class="mt-1 block w-full"
                        :value="old('name', $category->name)" required autofocus
                        placeholder="Contoh: Prestasi/Penghargaan" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                {{-- Form Actions --}}
                <div class="flex items-center justify-end gap-4 pt-4">
                    <a href="{{ route('admin.portfolio-categories.index') }}"
                        class="rounded-lg border border-gray-200 bg-white px-4 py-2 text-center text-sm font-medium text-gray-700 shadow-sm transition-all hover:bg-gray-50 focus:ring focus:ring-gray-100">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center gap-2 justify-center rounded-lg bg-[#1b3985] px-4 py-2 text-sm font-semibold text-white shadow-sm transition-all hover:bg-[#152c66] focus:outline-none focus:ring-2 focus:ring-[#1b3985] focus:ring-offset-2">
                        <x-heroicon-o-check-circle class="h-4 w-4" />
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

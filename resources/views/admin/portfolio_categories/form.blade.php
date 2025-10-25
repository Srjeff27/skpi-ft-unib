<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">{{ $category->exists ? 'Edit' : 'Tambah' }} Kategori Portofolio</h2>
    </x-slot>

    <div class="pt-8 pb-16">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <form method="POST" action="{{ $category->exists ? route('admin.portfolio-categories.update', $category) : route('admin.portfolio-categories.store') }}">
                    @csrf
                    @if($category->exists) @method('PUT') @endif

                    <div class="space-y-4">
                        <div>
                            <x-input-label value="Nama" />
                            <x-text-input name="name" class="w-full" value="{{ old('name',$category->name) }}" required />
                            <x-input-error :messages="$errors->get('name')" />
                        </div>
                    </div>

                    <div class="mt-6 flex gap-3">
                        <a href="{{ route('admin.portfolio-categories.index') }}" class="px-4 py-2 border rounded-md">Batal</a>
                        <button class="px-4 py-2 rounded-md bg-[#1b3985] text-white">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

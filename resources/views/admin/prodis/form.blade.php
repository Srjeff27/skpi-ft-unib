<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">{{ $prodi->exists ? 'Edit' : 'Tambah' }} Prodi</h2>
    </x-slot>

    <div class="pt-8 pb-16">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <form method="POST" action="{{ $prodi->exists ? route('admin.prodis.update', $prodi) : route('admin.prodis.store') }}">
                    @csrf
                    @if($prodi->exists) @method('PUT') @endif

                    <div class="space-y-4">
                        <div>
                            <x-input-label value="Nama Prodi" />
                            <x-text-input name="nama_prodi" class="w-full" value="{{ old('nama_prodi',$prodi->nama_prodi) }}" required />
                            <x-input-error :messages="$errors->get('nama_prodi')" />
                        </div>
                        <div>
                            <x-input-label value="Jenjang" />
                            <x-text-input name="jenjang" class="w-full" value="{{ old('jenjang',$prodi->jenjang) }}" required />
                            <x-input-error :messages="$errors->get('jenjang')" />
                        </div>
                    </div>

                    <div class="mt-6 flex gap-3">
                        <a href="{{ route('admin.prodis.index') }}" class="px-4 py-2 border rounded-md">Batal</a>
                        <button class="px-4 py-2 rounded-md bg-[#1b3985] text-white">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>


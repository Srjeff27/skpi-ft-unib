<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">{{ $official->exists ? 'Edit Pejabat' : 'Tambah Pejabat Baru' }}</h2>
        <p class="text-sm text-gray-500">Data pejabat penandatangan SKPI</p>
    </x-slot>

    <div class="pt-8 pb-16">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                <form method="POST" action="{{ $official->exists ? route('admin.pejabat.update', $official) : route('admin.pejabat.store') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @if($official->exists)
                        @method('PUT')
                    @endif

                    <div>
                        <label class="text-xs text-gray-600">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $official->name) }}" required class="mt-1 w-full rounded-md border-gray-300" />
                        @error('name')<div class="text-xs text-red-600 mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs text-gray-600">Gelar Depan</label>
                            <input type="text" name="gelar_depan" value="{{ old('gelar_depan', $official->gelar_depan) }}" class="mt-1 w-full rounded-md border-gray-300" />
                        </div>
                        <div>
                            <label class="text-xs text-gray-600">Gelar Belakang</label>
                            <input type="text" name="gelar_belakang" value="{{ old('gelar_belakang', $official->gelar_belakang) }}" class="mt-1 w-full rounded-md border-gray-300" />
                        </div>
                    </div>

                    <div>
                        <label class="text-xs text-gray-600">Jabatan</label>
                        <input type="text" name="jabatan" value="{{ old('jabatan', $official->jabatan) }}" required class="mt-1 w-full rounded-md border-gray-300" />
                        @error('jabatan')<div class="text-xs text-red-600 mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label class="text-xs text-gray-600">NIP/NIDN</label>
                        <input type="text" name="nip" value="{{ old('nip', $official->nip) }}" class="mt-1 w-full rounded-md border-gray-300" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-end">
                        <div>
                            <label class="text-xs text-gray-600">Upload Tanda Tangan (PNG)</label>
                            <input type="file" name="signature" accept="image/*" class="mt-1 w-full" />
                            @error('signature')<div class="text-xs text-red-600 mt-1">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label class="text-xs text-gray-600">Status</label>
                            <select name="is_active" class="mt-1 w-full rounded-md border-gray-300">
                                <option value="0" {{ old('is_active', $official->is_active ? 1 : 0) ? '' : 'selected' }}>Tidak Aktif</option>
                                <option value="1" {{ old('is_active', $official->is_active ? 1 : 0) ? 'selected' : '' }}>Aktif</option>
                            </select>
                        </div>
                    </div>

                    @if($official->signature_path)
                        <div class="pt-2">
                            <div class="text-xs text-gray-600 mb-1">Pratinjau Tanda Tangan Saat Ini</div>
                            <img src="{{ asset('storage/'.$official->signature_path) }}" alt="Signature" class="h-16 object-contain">
                        </div>
                    @endif

                    <div class="pt-3 flex gap-2">
                        <a href="{{ route('admin.pejabat.index') }}" class="px-4 py-2 rounded-md bg-gray-100 text-gray-700">Batal</a>
                        <button class="px-4 py-2 rounded-md bg-[#1b3985] text-white">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>


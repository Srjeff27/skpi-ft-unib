<x-app-layout>
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">{{ $prodi->exists ? 'Edit' : 'Tambah' }} Program Studi</h2>
                <p class="text-sm text-gray-500">
                    {{ $prodi->exists ? 'Perbarui detail program studi.' : 'Isi formulir untuk menambahkan program studi baru.' }}
                </p>
            </div>
        </div>

        <div class="max-w-2xl mx-auto">
            <form method="POST" action="{{ $prodi->exists ? route('admin.prodis.update', $prodi) : route('admin.prodis.store') }}"
                class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm space-y-6">
                @csrf
                @if ($prodi->exists)
                    @method('PUT')
                @endif

                {{-- Form Fields --}}
                <div>
                    <x-input-label for="nama_prodi" value="Nama Program Studi" />
                    <x-text-input id="nama_prodi" name="nama_prodi" class="mt-1 block w-full"
                        :value="old('nama_prodi', $prodi->nama_prodi)" required autofocus
                        placeholder="Contoh: Sistem Informasi" />
                    <x-input-error :messages="$errors->get('nama_prodi')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="jenjang" value="Jenjang" />
                    <select id="jenjang" name="jenjang" required
                        class="mt-1 block w-full rounded-lg border-gray-200 text-gray-700 shadow-sm focus:border-[#1b3985] focus:ring-[#1b3985]">
                        <option value="" disabled @selected(old('jenjang', $prodi->jenjang) == '')>- Pilih Jenjang -</option>
                        <option value="D3" @selected(old('jenjang', $prodi->jenjang) == 'D3')>D3</option>
                        <option value="S1" @selected(old('jenjang', $prodi->jenjang) == 'S1')>S1</option>
                        <option value="S2" @selected(old('jenjang', $prodi->jenjang) == 'S2')>S2</option>
                        <option value="S3" @selected(old('jenjang', $prodi->jenjang) == 'S3')>S3</option>
                    </select>
                    <x-input-error :messages="$errors->get('jenjang')" class="mt-2" />
                </div>

                {{-- Form Actions --}}
                <div class="flex items-center justify-end gap-4 pt-4">
                    <a href="{{ route('admin.prodis.index') }}"
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

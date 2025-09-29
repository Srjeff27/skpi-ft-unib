<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">{{ $student->exists ? 'Edit' : 'Tambah' }} Mahasiswa</h2>
    </x-slot>

    <div class="pt-8 pb-16">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <form method="POST" action="{{ $student->exists ? route('admin.students.update', $student) : route('admin.students.store') }}" enctype="multipart/form-data">
                    @csrf
                    @if($student->exists) @method('PUT') @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <div class="text-sm font-medium text-gray-700 mb-2">Foto Profil</div>
                            <div class="flex items-center gap-4">
                                <img class="h-16 w-16 rounded-full object-cover" src="{{ $student->profile_photo_path ? asset('storage/'.$student->profile_photo_path) : 'https://ui-avatars.com/api/?name='.urlencode(old('name',$student->name)).'&background=1b3985&color=fff' }}" alt="Foto Profil">
                                <div>
                                    <input type="file" name="profile_photo" accept="image/*" class="block w-full text-sm text-gray-600">
                                    <div class="text-xs text-gray-500">Format: JPG, PNG, WEBP. Maks 2MB.</div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <x-input-label value="Nama" />
                            <x-text-input name="name" class="w-full" value="{{ old('name',$student->name) }}" required />
                            <x-input-error :messages="$errors->get('name')" />
                        </div>
                        <div>
                            <x-input-label value="Email" />
                            <x-text-input type="email" name="email" class="w-full" value="{{ old('email',$student->email) }}" required />
                            <x-input-error :messages="$errors->get('email')" />
                        </div>
                        <div>
                            <x-input-label value="NPM" />
                            <x-text-input name="nim" class="w-full" value="{{ old('nim',$student->nim) }}" />
                            <x-input-error :messages="$errors->get('nim')" />
                        </div>
                        <div>
                            <x-input-label value="Tempat Lahir" />
                            <x-text-input name="tempat_lahir" class="w-full" value="{{ old('tempat_lahir',$student->tempat_lahir) }}" />
                            <x-input-error :messages="$errors->get('tempat_lahir')" />
                        </div>
                        <div>
                            <x-input-label value="Tanggal Lahir" />
                            <x-text-input type="date" name="tanggal_lahir" class="w-full" value="{{ old('tanggal_lahir', optional($student->tanggal_lahir)->format('Y-m-d')) }}" />
                            <x-input-error :messages="$errors->get('tanggal_lahir')" />
                        </div>
                        <div>
                            <x-input-label value="Nomor HP" />
                            <x-text-input name="nomor_hp" class="w-full" value="{{ old('nomor_hp',$student->nomor_hp) }}" />
                            <x-input-error :messages="$errors->get('nomor_hp')" />
                        </div>
                        <div>
                            <x-input-label value="Tahun Masuk" />
                            <x-text-input name="angkatan" class="w-full" value="{{ old('angkatan',$student->angkatan) }}" />
                            <x-input-error :messages="$errors->get('angkatan')" />
                        </div>
                        <div class="md:col-span-2">
                            <x-input-label value="Prodi" />
                            <select name="prodi_id" class="w-full border-gray-300 rounded-md">
                                <option value="">-</option>
                                @foreach($prodis as $p)
                                    <option value="{{ $p->id }}" @selected(old('prodi_id',$student->prodi_id)==$p->id)>{{ $p->nama_prodi }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('prodi_id')" />
                        </div>
                        <div class="md:col-span-2">
                            <x-input-label value="Password {{ $student->exists ? '(kosongkan jika tidak diubah)' : '' }}" />
                            <x-text-input type="password" name="password" class="w-full" />
                            <x-input-error :messages="$errors->get('password')" />
                        </div>
                    </div>

                    <div class="mt-6">
                        <div class="text-sm font-medium text-gray-700 mb-2">Data Kelulusan</div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label value="Tanggal Lulus" />
                                <x-text-input type="date" name="tanggal_lulus" class="w-full" value="{{ old('tanggal_lulus', optional($student->tanggal_lulus)->format('Y-m-d')) }}" />
                                <x-input-error :messages="$errors->get('tanggal_lulus')" />
                            </div>
                            <div>
                                <x-input-label value="Nomor Ijazah" />
                                <x-text-input name="nomor_ijazah" class="w-full" value="{{ old('nomor_ijazah',$student->nomor_ijazah) }}" />
                                <x-input-error :messages="$errors->get('nomor_ijazah')" />
                            </div>
                            <div>
                                <x-input-label value="Nomor SKPI" />
                                <x-text-input name="nomor_skpi" class="w-full" value="{{ old('nomor_skpi',$student->nomor_skpi) }}" />
                                <x-input-error :messages="$errors->get('nomor_skpi')" />
                            </div>
                            <div>
                                <x-input-label value="Gelar (ID)" />
                                <x-text-input name="gelar_id" class="w-full" value="{{ old('gelar_id',$student->gelar_id) }}" />
                                <x-input-error :messages="$errors->get('gelar_id')" />
                            </div>
                            <div>
                                <x-input-label value="Gelar (EN)" />
                                <x-text-input name="gelar_en" class="w-full" value="{{ old('gelar_en',$student->gelar_en) }}" />
                                <x-input-error :messages="$errors->get('gelar_en')" />
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-3">
                        <a href="{{ route('admin.students.index') }}" class="px-4 py-2 border rounded-md">Batal</a>
                        <button class="px-4 py-2 rounded-md bg-[#1b3985] text-white">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

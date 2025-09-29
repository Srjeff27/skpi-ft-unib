<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">{{ $user->exists ? 'Edit' : 'Tambah' }} User</h2>
    </x-slot>

    <div class="pt-8 pb-16">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <form method="POST" action="{{ $user->exists ? route('admin.users.update', $user) : route('admin.users.store') }}">
                    @csrf
                    @if($user->exists) @method('PUT') @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label value="Nama" />
                            <x-text-input name="name" class="w-full" value="{{ old('name',$user->name) }}" required />
                            <x-input-error :messages="$errors->get('name')" />
                        </div>
                        <div>
                            <x-input-label value="Email" />
                            <x-text-input type="email" name="email" class="w-full" value="{{ old('email',$user->email) }}" required />
                            <x-input-error :messages="$errors->get('email')" />
                        </div>

                        <div>
                            <x-input-label value="Role" />
                            <select name="role" class="w-full border-gray-300 rounded-md" required>
                                @foreach(['admin'=>'Admin','verifikator'=>'Verifikator','mahasiswa'=>'Mahasiswa'] as $k=>$v)
                                    <option value="{{ $k }}" @selected(old('role',$user->role)==$k)>{{ $v }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('role')" />
                        </div>

                        <div>
                            <x-input-label value="NIM (Mahasiswa)" />
                            <x-text-input name="nim" class="w-full" value="{{ old('nim',$user->nim) }}" />
                            <x-input-error :messages="$errors->get('nim')" />
                        </div>

                        <div>
                            <x-input-label value="Angkatan" />
                            <x-text-input name="angkatan" class="w-full" value="{{ old('angkatan',$user->angkatan) }}" />
                            <x-input-error :messages="$errors->get('angkatan')" />
                        </div>

                        <div>
                            <x-input-label value="Prodi" />
                            <select name="prodi_id" class="w-full border-gray-300 rounded-md">
                                <option value="">-</option>
                                @foreach($prodis as $p)
                                    <option value="{{ $p->id }}" @selected(old('prodi_id',$user->prodi_id)==$p->id)>{{ $p->nama_prodi }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('prodi_id')" />
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label value="Password {{ $user->exists ? '(kosongkan jika tidak diubah)' : '' }}" />
                            <x-text-input type="password" name="password" class="w-full" />
                            <x-input-error :messages="$errors->get('password')" />
                        </div>
                    </div>

                    <div class="mt-6 flex gap-3">
                        <a href="{{ route('admin.users.index') }}" class="px-4 py-2 border rounded-md">Batal</a>
                        <button class="px-4 py-2 rounded-md bg-[#1b3985] text-white">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>


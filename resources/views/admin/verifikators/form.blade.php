<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">{{ $verifikator->exists ? 'Edit' : 'Tambah' }} Verifikator</h2>
    </x-slot>

    <div class="pt-8 pb-16">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            @if ($errors->any())
                <x-toast type="error" :message="$errors->first()" :auto-close="false" />
            @endif
            <div class="bg-white rounded-lg shadow-sm p-6">
                <form method="POST" action="{{ $verifikator->exists ? route('admin.verifikators.update', $verifikator) : route('admin.verifikators.store') }}">
                    @csrf
                    @if($verifikator->exists) @method('PUT') @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2" x-data="{ selectedAvatar: '{{ old('avatar', $verifikator->avatar ?? '') }}' }">
                            <div class="text-sm font-medium text-gray-700 mb-2">Avatar Profil</div>
                            <div class="flex items-center gap-4">
                                <img class="h-16 w-16 rounded-full object-cover" src="{{ $verifikator->avatar_url }}" alt="Avatar">
                                <div class="text-xs text-gray-600">Upload dinonaktifkan. Pilih salah satu avatar di bawah.</div>
                            </div>
                            @php
                                $avatarOptions = [
                                    'mahasiswa_male' => 'Leo',
                                    'mahasiswa_female' => 'Stella',
                                    'dosen' => 'Rysh',
                                    'verifikator' => 'Anya',
                                    'admin' => 'Zack',
                                ];
                            @endphp
                            <div class="mt-3 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
                                @foreach ($avatarOptions as $key => $label)
                                    @php $checked = old('avatar', $verifikator->avatar ?? null) === $key; @endphp
                                    <label class="cursor-pointer border rounded-lg p-3 flex flex-col items-center gap-2 hover:bg-gray-50 transition ring-offset-1"
                                           :class="selectedAvatar === '{{ $key }}' ? 'ring-2 ring-[#1b3985] border-[#1b3985] bg-white' : 'border-gray-200'">
                                        <img src="{{ asset('avatars/' . match($key){
                                            'mahasiswa_male' => 'student-male.svg',
                                            'mahasiswa_female' => 'student-female.svg',
                                            'dosen' => 'lecturer.svg',
                                            'verifikator' => 'verifikator.svg',
                                            'admin' => 'admin.svg',
                                            default => 'student-male.svg'
                                        }) }}" alt="{{ $label }}" class="h-12 w-12 rounded-full">
                                        <input type="radio" name="avatar" value="{{ $key }}" class="sr-only" @checked($checked) x-model="selectedAvatar">
                                        <div class="text-xs text-gray-700">{{ $label }}</div>
                                    </label>
                                @endforeach
                            </div>
                            <x-input-error :messages="$errors->get('avatar')" />
                        </div>
                        <div>
                            <x-input-label value="Nama" />
                            <x-text-input name="name" class="w-full" value="{{ old('name',$verifikator->name) }}" required />
                            <x-input-error :messages="$errors->get('name')" />
                        </div>
                        <div>
                            <x-input-label value="Email" />
                            <x-text-input type="email" name="email" class="w-full" value="{{ old('email',$verifikator->email) }}" required />
                            <x-input-error :messages="$errors->get('email')" />
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label value="Prodi (opsional)" />
                            <select name="prodi_id" class="w-full border-gray-300 rounded-md">
                                <option value="">-</option>
                                @foreach($prodis as $p)
                                    <option value="{{ $p->id }}" @selected(old('prodi_id',$verifikator->prodi_id)==$p->id)>{{ $p->nama_prodi }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('prodi_id')" />
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label value="Password {{ $verifikator->exists ? '(kosongkan jika tidak diubah)' : '' }}" />
                            <x-text-input type="password" name="password" class="w-full" />
                            <x-input-error :messages="$errors->get('password')" />
                        </div>
                    </div>

                    <div class="mt-6 flex gap-3">
                        <a href="{{ route('admin.verifikators.index') }}" class="px-4 py-2 border rounded-md">Batal</a>
                        <button class="px-4 py-2 rounded-md bg-[#1b3985] text-white">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    {{-- Header Navigation --}}
    <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">
                {{ $verifikator->exists ? 'Edit Data Verifikator' : 'Tambah Verifikator Baru' }}
            </h2>
            <p class="text-sm text-slate-500">Kelola akun dosen/staf untuk validasi portofolio.</p>
        </div>
        <a href="{{ route('admin.verifikators.index') }}" 
           class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition-all hover:bg-slate-50 hover:text-slate-900">
            <x-heroicon-m-arrow-left class="h-4 w-4" />
            Kembali
        </a>
    </div>

    <form method="POST" action="{{ $verifikator->exists ? route('admin.verifikators.update', $verifikator) : route('admin.verifikators.store') }}" 
          class="space-y-8 pb-20">
        @csrf
        @if($verifikator->exists) @method('PUT') @endif

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
            
            {{-- Kolom Kiri: Identitas Visual (Avatar) --}}
            <div class="lg:col-span-1">
                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm h-full" x-data="{ selectedAvatar: '{{ old('avatar', $verifikator->avatar ?? '') }}' }">
                    <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4">
                        <h3 class="font-bold text-slate-800 flex items-center gap-2">
                            <x-heroicon-o-face-smile class="h-5 w-5 text-[#1b3985]" />
                            Avatar Profil
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="mb-6 flex flex-col items-center text-center">
                            <div class="h-24 w-24 overflow-hidden rounded-full ring-4 ring-slate-50 shadow-md mb-3">
                                <img src="{{ $verifikator->avatar_url }}" alt="Current Avatar" class="h-full w-full object-cover">
                            </div>
                            <p class="text-xs text-slate-500">Tampilan saat ini</p>
                        </div>

                        @php
                            $avatarOptions = [
                                'dosen' => 'Rysh',
                                'verifikator' => 'Anya',
                                'admin' => 'Zack',
                                'mahasiswa_male' => 'Leo',
                                'mahasiswa_female' => 'Stella',
                            ];
                        @endphp
                        
                        <div class="grid grid-cols-3 gap-3">
                            @foreach ($avatarOptions as $key => $label)
                                <label class="group relative cursor-pointer rounded-xl border p-2 transition-all hover:shadow-md flex flex-col items-center gap-2"
                                       :class="selectedAvatar === '{{ $key }}' ? 'border-[#1b3985] bg-blue-50/30 ring-1 ring-[#1b3985]' : 'border-slate-200 hover:border-blue-300'">
                                    <input type="radio" name="avatar" value="{{ $key }}" class="sr-only" x-model="selectedAvatar">
                                    <img src="{{ asset('avatars/' . match($key){
                                        'mahasiswa_male' => 'student-male.svg',
                                        'mahasiswa_female' => 'student-female.svg',
                                        'dosen' => 'lecturer.svg',
                                        'verifikator' => 'verifikator.svg',
                                        'admin' => 'admin.svg',
                                        default => 'student-male.svg'
                                    }) }}" alt="{{ $label }}" class="h-10 w-10 transition-transform group-hover:scale-110">
                                    <span class="text-[10px] font-medium text-slate-600">{{ $label }}</span>
                                    
                                    <div x-show="selectedAvatar === '{{ $key }}'" class="absolute -right-1.5 -top-1.5 rounded-full bg-white text-[#1b3985] shadow-sm">
                                        <x-heroicon-s-check-circle class="h-5 w-5" />
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        <x-input-error :messages="$errors->get('avatar')" class="mt-4" />
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Informasi Akun & Prodi --}}
            <div class="lg:col-span-2 space-y-8">
                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4">
                        <h3 class="font-bold text-slate-800 flex items-center gap-2">
                            <x-heroicon-o-user-circle class="h-5 w-5 text-[#1b3985]" />
                            Informasi Akun
                        </h3>
                    </div>
                    <div class="p-6 sm:p-8">
                        <div class="grid grid-cols-1 gap-6">
                            {{-- Nama --}}
                            <div>
                                <x-input-label for="name" value="Nama Lengkap" />
                                <div class="relative mt-1">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <x-heroicon-o-user class="h-5 w-5 text-slate-400" />
                                    </div>
                                    <input type="text" name="name" id="name" value="{{ old('name', $verifikator->name) }}" required
                                           class="block w-full rounded-xl border-slate-300 pl-10 focus:border-[#1b3985] focus:ring-[#1b3985] sm:text-sm" 
                                           placeholder="Nama Dosen / Staff">
                                </div>
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            {{-- Email --}}
                            <div>
                                <x-input-label for="email" value="Alamat Email" />
                                <div class="relative mt-1">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <x-heroicon-o-envelope class="h-5 w-5 text-slate-400" />
                                    </div>
                                    <input type="email" name="email" id="email" value="{{ old('email', $verifikator->email) }}" required
                                           class="block w-full rounded-xl border-slate-300 pl-10 focus:border-[#1b3985] focus:ring-[#1b3985] sm:text-sm" 
                                           placeholder="dosen@unib.ac.id">
                                </div>
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            {{-- Prodi Assignment --}}
                            <div class="rounded-xl bg-blue-50/50 border border-blue-100 p-4">
                                <x-input-label for="prodi_id" value="Penugasan Program Studi" class="mb-1 text-blue-900" />
                                <p class="text-xs text-slate-500 mb-3">Verifikator ini akan memvalidasi portofolio mahasiswa dari prodi berikut.</p>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <x-heroicon-o-building-library class="h-5 w-5 text-blue-400" />
                                    </div>
                                    <select name="prodi_id" id="prodi_id" class="block w-full rounded-xl border-blue-200 pl-10 focus:border-[#1b3985] focus:ring-[#1b3985] sm:text-sm bg-white">
                                        <option value="">- Pilih Program Studi -</option>
                                        @foreach($prodis as $p)
                                            <option value="{{ $p->id }}" @selected(old('prodi_id', $verifikator->prodi_id) == $p->id)>{{ $p->nama_prodi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <x-input-error :messages="$errors->get('prodi_id')" class="mt-2" />
                            </div>

                            {{-- Password --}}
                            <div>
                                <x-input-label for="password" value="Password Akun" />
                                <div class="relative mt-1">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <x-heroicon-o-lock-closed class="h-5 w-5 text-slate-400" />
                                    </div>
                                    <input type="password" name="password" id="password" 
                                           class="block w-full rounded-xl border-slate-300 pl-10 focus:border-[#1b3985] focus:ring-[#1b3985] sm:text-sm"
                                           placeholder="••••••••">
                                </div>
                                @if($verifikator->exists)
                                    <p class="mt-2 text-xs text-slate-500 flex items-center gap-1">
                                        <x-heroicon-o-information-circle class="w-4 h-4" />
                                        Kosongkan jika tidak ingin mengubah password.
                                    </p>
                                @endif
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sticky Action Footer --}}
        <div class="fixed bottom-0 left-0 right-0 border-t border-slate-200 bg-white/80 p-4 backdrop-blur-md md:pl-64 z-40">
            <div class="mx-auto flex max-w-7xl items-center justify-end gap-4 px-4">
                <a href="{{ route('admin.verifikators.index') }}" class="rounded-xl px-6 py-2.5 text-sm font-semibold text-slate-600 transition-colors hover:bg-slate-100 hover:text-slate-900">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-[#1b3985] px-8 py-2.5 text-sm font-bold text-white shadow-lg shadow-blue-900/20 transition-all hover:bg-[#152c66] hover:shadow-blue-900/40 hover:-translate-y-0.5">
                    <x-heroicon-m-check class="h-5 w-5" />
                    Simpan Data
                </button>
            </div>
        </div>
    </form>
</x-app-layout>
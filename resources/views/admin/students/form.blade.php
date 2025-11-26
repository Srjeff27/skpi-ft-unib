<x-app-layout>
    {{-- Header --}}
    <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">
                {{ $student->exists ? 'Edit Data Mahasiswa' : 'Registrasi Mahasiswa Baru' }}
            </h2>
            <p class="text-sm text-slate-500">Lengkapi formulir di bawah ini dengan data yang valid.</p>
        </div>
        <a href="{{ route('admin.students.index') }}" 
           class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition-all hover:bg-slate-50 hover:text-slate-900">
            <x-heroicon-m-arrow-left class="h-4 w-4" />
            Kembali
        </a>
    </div>

    <form method="POST" action="{{ $student->exists ? route('admin.students.update', $student) : route('admin.students.store') }}" 
          enctype="multipart/form-data" class="space-y-8 pb-20">
        @csrf
        @if($student->exists) @method('PUT') @endif

        {{-- Section 1: Identitas Visual (Avatar) --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm" x-data="{ selectedAvatar: '{{ old('avatar', $student->avatar ?? '') }}' }">
            <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <x-heroicon-o-face-smile class="h-5 w-5 text-[#1b3985]" />
                    Identitas Visual
                </h3>
            </div>
            <div class="p-6 sm:p-8">
                <div class="mb-4 flex items-center gap-4">
                    <div class="h-16 w-16 shrink-0 overflow-hidden rounded-full ring-4 ring-slate-100">
                        <img src="{{ $student->avatar_url }}" alt="Current Avatar" class="h-full w-full object-cover">
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-700">Avatar Terpilih</p>
                        <p class="text-xs text-slate-500">Pilih karakter representasi di bawah ini.</p>
                    </div>
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
                
                <div class="grid grid-cols-3 gap-4 sm:grid-cols-5 lg:grid-cols-6">
                    @foreach ($avatarOptions as $key => $label)
                        <label class="group relative cursor-pointer rounded-xl border p-3 transition-all hover:shadow-md"
                               :class="selectedAvatar === '{{ $key }}' ? 'border-[#1b3985] bg-blue-50/30 ring-1 ring-[#1b3985]' : 'border-slate-200 hover:border-blue-300'">
                            <input type="radio" name="avatar" value="{{ $key }}" class="sr-only" x-model="selectedAvatar">
                            <div class="flex flex-col items-center gap-2">
                                <img src="{{ asset('avatars/' . match($key){
                                    'mahasiswa_male' => 'student-male.svg',
                                    'mahasiswa_female' => 'student-female.svg',
                                    'dosen' => 'lecturer.svg',
                                    'verifikator' => 'verifikator.svg',
                                    'admin' => 'admin.svg',
                                    default => 'student-male.svg'
                                }) }}" alt="{{ $label }}" class="h-12 w-12 transition-transform group-hover:scale-110">
                                <span class="text-xs font-medium text-slate-600 group-hover:text-[#1b3985]">{{ $label }}</span>
                            </div>
                            <div x-show="selectedAvatar === '{{ $key }}'" class="absolute -right-2 -top-2 rounded-full bg-white text-[#1b3985] shadow-sm">
                                <x-heroicon-s-check-circle class="h-6 w-6" />
                            </div>
                        </label>
                    @endforeach
                </div>
                <x-input-error :messages="$errors->get('avatar')" class="mt-2" />
            </div>
        </div>

        {{-- Section 2: Informasi Pribadi & Akademik --}}
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
            {{-- Kolom Kiri: Data Diri --}}
            <div class="lg:col-span-2 space-y-8">
                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4">
                        <h3 class="font-bold text-slate-800 flex items-center gap-2">
                            <x-heroicon-o-user class="h-5 w-5 text-[#1b3985]" />
                            Informasi Pribadi
                        </h3>
                    </div>
                    <div class="p-6 sm:p-8">
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div class="md:col-span-2">
                                <x-input-label for="name" value="Nama Lengkap" />
                                <div class="relative mt-1">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <x-heroicon-o-user class="h-5 w-5 text-slate-400" />
                                    </div>
                                    <input type="text" name="name" id="name" value="{{ old('name', $student->name) }}" required
                                           class="block w-full rounded-xl border-slate-300 pl-10 focus:border-[#1b3985] focus:ring-[#1b3985] sm:text-sm" 
                                           placeholder="Masukkan nama lengkap">
                                </div>
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="email" value="Alamat Email" />
                                <div class="relative mt-1">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <x-heroicon-o-envelope class="h-5 w-5 text-slate-400" />
                                    </div>
                                    <input type="email" name="email" id="email" value="{{ old('email', $student->email) }}" required
                                           class="block w-full rounded-xl border-slate-300 pl-10 focus:border-[#1b3985] focus:ring-[#1b3985] sm:text-sm" 
                                           placeholder="email@unib.ac.id">
                                </div>
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="nomor_hp" value="Nomor WhatsApp" />
                                <div class="relative mt-1">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <x-heroicon-o-phone class="h-5 w-5 text-slate-400" />
                                    </div>
                                    <input type="text" name="nomor_hp" id="nomor_hp" value="{{ old('nomor_hp', $student->nomor_hp) }}"
                                           class="block w-full rounded-xl border-slate-300 pl-10 focus:border-[#1b3985] focus:ring-[#1b3985] sm:text-sm" 
                                           placeholder="08xxxxxxxxxx">
                                </div>
                                <x-input-error :messages="$errors->get('nomor_hp')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="tempat_lahir" value="Tempat Lahir" />
                                <div class="relative mt-1">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <x-heroicon-o-map-pin class="h-5 w-5 text-slate-400" />
                                    </div>
                                    <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir', $student->tempat_lahir) }}"
                                           class="block w-full rounded-xl border-slate-300 pl-10 focus:border-[#1b3985] focus:ring-[#1b3985] sm:text-sm">
                                </div>
                            </div>

                            <div>
                                <x-input-label for="tanggal_lahir" value="Tanggal Lahir" />
                                <div class="relative mt-1">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <x-heroicon-o-calendar class="h-5 w-5 text-slate-400" />
                                    </div>
                                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', optional($student->tanggal_lahir)->format('Y-m-d')) }}"
                                           class="block w-full rounded-xl border-slate-300 pl-10 focus:border-[#1b3985] focus:ring-[#1b3985] sm:text-sm">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4">
                        <h3 class="font-bold text-slate-800 flex items-center gap-2">
                            <x-heroicon-o-academic-cap class="h-5 w-5 text-[#1b3985]" />
                            Data Akademik
                        </h3>
                    </div>
                    <div class="p-6 sm:p-8">
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div class="md:col-span-2">
                                <x-input-label for="nim" value="NPM (Nomor Pokok Mahasiswa)" />
                                <div class="relative mt-1">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <x-heroicon-o-identification class="h-5 w-5 text-slate-400" />
                                    </div>
                                    <input type="text" name="nim" id="nim" value="{{ old('nim', $student->nim) }}"
                                           class="block w-full rounded-xl border-slate-300 pl-10 focus:border-[#1b3985] focus:ring-[#1b3985] sm:text-sm font-mono" 
                                           placeholder="Contoh: G1A021001">
                                </div>
                                <x-input-error :messages="$errors->get('nim')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="prodi_id" value="Program Studi" />
                                <div class="relative mt-1">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <x-heroicon-o-building-library class="h-5 w-5 text-slate-400" />
                                    </div>
                                    <select name="prodi_id" id="prodi_id" class="block w-full rounded-xl border-slate-300 pl-10 focus:border-[#1b3985] focus:ring-[#1b3985] sm:text-sm">
                                        <option value="">- Pilih Program Studi -</option>
                                        @foreach($prodis as $p)
                                            <option value="{{ $p->id }}" @selected(old('prodi_id', $student->prodi_id) == $p->id)>{{ $p->nama_prodi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <x-input-error :messages="$errors->get('prodi_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="angkatan" value="Tahun Angkatan" />
                                <div class="relative mt-1">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <x-heroicon-o-clock class="h-5 w-5 text-slate-400" />
                                    </div>
                                    <input type="number" name="angkatan" id="angkatan" value="{{ old('angkatan', $student->angkatan) }}"
                                           class="block w-full rounded-xl border-slate-300 pl-10 focus:border-[#1b3985] focus:ring-[#1b3985] sm:text-sm" 
                                           placeholder="YYYY">
                                </div>
                                <x-input-error :messages="$errors->get('angkatan')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Keamanan & Kelulusan --}}
            <div class="space-y-8">
                {{-- Password --}}
                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4">
                        <h3 class="font-bold text-slate-800 flex items-center gap-2">
                            <x-heroicon-o-lock-closed class="h-5 w-5 text-[#1b3985]" />
                            Keamanan Akun
                        </h3>
                    </div>
                    <div class="p-6">
                        <x-input-label for="password" value="Password Baru" />
                        <div class="relative mt-1">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <x-heroicon-o-key class="h-5 w-5 text-slate-400" />
                            </div>
                            <input type="password" name="password" id="password" 
                                   class="block w-full rounded-xl border-slate-300 pl-10 focus:border-[#1b3985] focus:ring-[#1b3985] sm:text-sm"
                                   placeholder="••••••••">
                        </div>
                        @if($student->exists)
                            <p class="mt-2 text-xs text-slate-500">* Kosongkan jika tidak ingin mengubah password.</p>
                        @endif
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                </div>

                {{-- Data Kelulusan (Collapsible / Optional Look) --}}
                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 shadow-sm">
                    <div class="border-b border-slate-200/60 px-6 py-4">
                        <h3 class="font-bold text-slate-700 flex items-center gap-2">
                            <x-heroicon-o-clipboard-document-check class="h-5 w-5 text-slate-500" />
                            Data Kelulusan (Opsional)
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <x-input-label for="tanggal_lulus" value="Tanggal Lulus" />
                            <input type="date" name="tanggal_lulus" id="tanggal_lulus" value="{{ old('tanggal_lulus', optional($student->tanggal_lulus)->format('Y-m-d')) }}"
                                   class="mt-1 block w-full rounded-xl border-slate-300 bg-white focus:border-[#1b3985] focus:ring-[#1b3985] sm:text-sm">
                        </div>
                        <div>
                            <x-input-label for="nomor_ijazah" value="Nomor Ijazah" />
                            <input type="text" name="nomor_ijazah" id="nomor_ijazah" value="{{ old('nomor_ijazah', $student->nomor_ijazah) }}"
                                   class="mt-1 block w-full rounded-xl border-slate-300 bg-white focus:border-[#1b3985] focus:ring-[#1b3985] sm:text-sm">
                        </div>
                        <div>
                            <x-input-label for="nomor_skpi" value="Nomor SKPI" />
                            <input type="text" name="nomor_skpi" id="nomor_skpi" value="{{ old('nomor_skpi', $student->nomor_skpi) }}"
                                   class="mt-1 block w-full rounded-xl border-slate-300 bg-white focus:border-[#1b3985] focus:ring-[#1b3985] sm:text-sm">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="gelar_id" value="Gelar (ID)" />
                                <input type="text" name="gelar_id" id="gelar_id" value="{{ old('gelar_id', $student->gelar_id) }}"
                                       class="mt-1 block w-full rounded-xl border-slate-300 bg-white focus:border-[#1b3985] focus:ring-[#1b3985] sm:text-sm" placeholder="S.T.">
                            </div>
                            <div>
                                <x-input-label for="gelar_en" value="Gelar (EN)" />
                                <input type="text" name="gelar_en" id="gelar_en" value="{{ old('gelar_en', $student->gelar_en) }}"
                                       class="mt-1 block w-full rounded-xl border-slate-300 bg-white focus:border-[#1b3985] focus:ring-[#1b3985] sm:text-sm" placeholder="B.Eng">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sticky Action Footer --}}
        <div class="fixed bottom-0 left-0 right-0 border-t border-slate-200 bg-white/80 p-4 backdrop-blur-md md:pl-64">
            <div class="mx-auto flex max-w-7xl items-center justify-end gap-4 px-4">
                <a href="{{ route('admin.students.index') }}" class="rounded-xl px-6 py-2.5 text-sm font-semibold text-slate-600 transition-colors hover:bg-slate-100 hover:text-slate-900">
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
<section class="max-w-4xl mx-auto">
    {{-- Hidden Form untuk Verifikasi Email --}}
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">@csrf</form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        {{-- CARD 1: IDENTITAS & AVATAR --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 sm:p-8">
                
                {{-- Header Section --}}
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                    <div>
                        <h2 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                            <x-heroicon-o-face-smile class="w-6 h-6 text-[#1b3985]" />
                            Identitas Visual
                        </h2>
                        <p class="mt-1 text-sm text-slate-500">Personalisasi tampilan akun Anda.</p>
                    </div>
                    
                    {{-- Avatar Preview --}}
                    <div class="flex items-center gap-3 bg-blue-50/50 px-4 py-2 rounded-xl border border-blue-100">
                        <img src="{{ $user->avatar_url }}" alt="Current Avatar" 
                             class="h-10 w-10 rounded-full object-cover ring-2 ring-white shadow-sm">
                        <div class="text-xs">
                            <p class="font-bold text-[#1b3985]">Avatar Aktif</p>
                            <p class="text-blue-600/70">{{ $user->name }}</p>
                        </div>
                    </div>
                </div>

                {{-- Avatar Selector Grid --}}
                <div x-data="{ selected: '{{ old('avatar', $user->avatar ?? '') }}' }" class="mb-8">
                    <label class="block text-sm font-bold text-slate-700 mb-4">Pilih Karakter Profil</label>
                    
                    @php
                        $avatars = [
                            'mahasiswa_male' => ['label' => 'Leo', 'file' => 'student-male.svg'],
                            'mahasiswa_female' => ['label' => 'Stella', 'file' => 'student-female.svg'],
                            'dosen' => ['label' => 'Rysh', 'file' => 'lecturer.svg'],
                            'verifikator' => ['label' => 'Anya', 'file' => 'verifikator.svg'],
                            'admin' => ['label' => 'Zack', 'file' => 'admin.svg'],
                        ];
                    @endphp

                    <div class="grid grid-cols-3 sm:grid-cols-5 gap-4">
                        @foreach ($avatars as $key => $data)
                            <label class="group relative cursor-pointer">
                                <input type="radio" name="avatar" value="{{ $key }}" class="sr-only" x-model="selected">
                                
                                <div class="rounded-2xl border-2 p-3 flex flex-col items-center gap-3 transition-all duration-300"
                                     :class="selected === '{{ $key }}' 
                                        ? 'border-[#1b3985] bg-blue-50/40 ring-2 ring-[#1b3985]/20 ring-offset-2' 
                                        : 'border-slate-100 hover:border-slate-300 hover:bg-slate-50'">
                                    
                                    <img src="{{ asset('avatars/' . $data['file']) }}" 
                                         alt="{{ $data['label'] }}"
                                         class="h-14 w-14 transition-transform duration-300 group-hover:scale-110"
                                         :class="selected !== '{{ $key }}' ? 'grayscale opacity-70 group-hover:grayscale-0 group-hover:opacity-100' : ''">
                                    
                                    <span class="text-xs font-bold transition-colors"
                                          :class="selected === '{{ $key }}' ? 'text-[#1b3985]' : 'text-slate-400 group-hover:text-slate-600'">
                                          {{ $data['label'] }}
                                    </span>
                                </div>

                                <div x-show="selected === '{{ $key }}'" 
                                     x-transition.scale 
                                     class="absolute -top-2 -right-2 bg-white rounded-full text-[#1b3985] shadow-sm">
                                    <x-heroicon-s-check-circle class="w-6 h-6" />
                                </div>
                            </label>
                        @endforeach
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
                </div>

                {{-- Personal Info Inputs --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t border-slate-100">
                    {{-- Nama Lengkap --}}
                    <div>
                        <x-input-label for="name" value="Nama Lengkap" class="mb-1.5" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <x-heroicon-o-user class="h-5 w-5 text-slate-400" />
                            </div>
                            <x-text-input id="name" name="name" type="text" 
                                class="pl-10 block w-full rounded-xl border-slate-300 focus:border-[#1b3985] focus:ring-[#1b3985]" 
                                :value="old('name', $user->name)" required autocomplete="name" />
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    {{-- Email --}}
                    <div>
                        <x-input-label for="email" value="Alamat Email" class="mb-1.5" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <x-heroicon-o-envelope class="h-5 w-5 text-slate-400" />
                            </div>
                            <x-text-input id="email" name="email" type="email" 
                                class="pl-10 block w-full rounded-xl border-slate-300 focus:border-[#1b3985] focus:ring-[#1b3985]" 
                                :value="old('email', $user->email)" required autocomplete="username" />
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />

                        {{-- Email Verification Alert --}}
                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                            <div class="mt-3 p-3 rounded-lg bg-amber-50 border border-amber-100 flex gap-3 items-start">
                                <x-heroicon-s-exclamation-triangle class="w-5 h-5 text-amber-500 shrink-0" />
                                <div class="text-sm text-amber-800">
                                    <p class="font-medium">Email belum diverifikasi.</p>
                                    <button form="send-verification" class="text-amber-700 underline hover:text-amber-900 mt-1">
                                        Kirim ulang tautan verifikasi.
                                    </button>
                                </div>
                            </div>
                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 text-sm text-emerald-600 font-bold">
                                    &check; Tautan verifikasi baru telah dikirim.
                                </p>
                            @endif
                        @endif
                    </div>

                    {{-- Prodi Readonly (Non-Mahasiswa) --}}
                    @if ((auth()->user()->role ?? null) === 'verifikator')
                        <div class="col-span-1 md:col-span-2">
                            <x-input-label value="Afiliasi Program Studi" class="mb-1.5" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <x-heroicon-o-building-library class="h-5 w-5 text-slate-400" />
                                </div>
                                <input type="text" disabled 
                                    class="pl-10 block w-full rounded-xl border-slate-200 bg-slate-50 text-slate-500 cursor-not-allowed"
                                    value="{{ optional($user->prodi)->nama_prodi ?? 'Tidak ada data' }}">
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- CARD 2: DATA AKADEMIK (MAHASISWA ONLY) --}}
        @if ((auth()->user()->role ?? null) === 'mahasiswa')
            <div class="bg-slate-50 rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 sm:p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2 bg-white rounded-lg border border-slate-200 shadow-sm text-[#1b3985]">
                            <x-heroicon-o-academic-cap class="w-6 h-6" />
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-slate-800">Data Akademik</h2>
                            <p class="text-sm text-slate-500">Informasi pendidikan dan kontak darurat.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- NPM --}}
                        <div class="col-span-1 md:col-span-2">
                            <x-input-label for="nim" value="NPM (Nomor Pokok Mahasiswa)" class="mb-1.5" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <x-heroicon-o-identification class="h-5 w-5 text-slate-400" />
                                </div>
                                <x-text-input id="nim" name="nim" type="text" 
                                    class="pl-10 block w-full rounded-xl border-slate-300 focus:border-[#1b3985] focus:ring-[#1b3985] bg-white" 
                                    :value="old('nim', $user->nim)" />
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('nim')" />
                        </div>

                        {{-- Tempat Lahir --}}
                        <div>
                            <x-input-label for="tempat_lahir" value="Tempat Lahir" class="mb-1.5" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <x-heroicon-o-map-pin class="h-5 w-5 text-slate-400" />
                                </div>
                                <x-text-input id="tempat_lahir" name="tempat_lahir" type="text" 
                                    class="pl-10 block w-full rounded-xl border-slate-300 focus:border-[#1b3985] focus:ring-[#1b3985]" 
                                    :value="old('tempat_lahir', $user->tempat_lahir)" />
                            </div>
                        </div>

                        {{-- Tanggal Lahir --}}
                        <div>
                            <x-input-label for="tanggal_lahir" value="Tanggal Lahir" class="mb-1.5" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <x-heroicon-o-calendar-days class="h-5 w-5 text-slate-400" />
                                </div>
                                <x-text-input id="tanggal_lahir" name="tanggal_lahir" type="date" 
                                    class="pl-10 block w-full rounded-xl border-slate-300 focus:border-[#1b3985] focus:ring-[#1b3985]" 
                                    :value="old('tanggal_lahir', optional($user->tanggal_lahir)->format('Y-m-d'))" />
                            </div>
                        </div>

                        {{-- WhatsApp --}}
                        <div>
                            <x-input-label for="nomor_hp" value="Nomor WhatsApp" class="mb-1.5" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <x-heroicon-o-phone class="h-5 w-5 text-slate-400" />
                                </div>
                                <x-text-input id="nomor_hp" name="nomor_hp" type="tel" 
                                    class="pl-10 block w-full rounded-xl border-slate-300 focus:border-[#1b3985] focus:ring-[#1b3985]" 
                                    :value="old('nomor_hp', $user->nomor_hp)" placeholder="08xxxxxxxxxx" />
                            </div>
                        </div>

                        {{-- Angkatan --}}
                        <div>
                            <x-input-label for="angkatan" value="Tahun Angkatan" class="mb-1.5" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <x-heroicon-o-clock class="h-5 w-5 text-slate-400" />
                                </div>
                                <x-text-input id="angkatan" name="angkatan" type="number" min="2000" max="{{ date('Y') + 1 }}"
                                    class="pl-10 block w-full rounded-xl border-slate-300 focus:border-[#1b3985] focus:ring-[#1b3985]" 
                                    :value="old('angkatan', $user->angkatan)" />
                            </div>
                        </div>

                        {{-- Program Studi --}}
                        <div class="col-span-1 md:col-span-2">
                            <x-input-label for="prodi_id" value="Program Studi" class="mb-1.5" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <x-heroicon-o-building-library class="h-5 w-5 text-slate-400" />
                                </div>
                                <select id="prodi_id" name="prodi_id"
                                    class="pl-10 block w-full rounded-xl border-slate-300 shadow-sm focus:border-[#1b3985] focus:ring-[#1b3985] bg-white py-2.5">
                                    <option value="" disabled selected>- Pilih Program Studi -</option>
                                    @foreach ($prodis as $prodi)
                                        <option value="{{ $prodi->id }}" @selected(old('prodi_id', $user->prodi_id) == $prodi->id)>
                                            {{ $prodi->nama_prodi }} ({{ $prodi->jenjang }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- ACTION BUTTON --}}
        <div class="flex items-center justify-end gap-4 pt-4">
            @if (session('status') === 'profile-updated')
                <div x-data="{ show: true }" x-show="show" x-transition.opacity.duration.500ms x-init="setTimeout(() => show = false, 3000)"
                     class="flex items-center gap-1 text-sm font-semibold text-emerald-600 bg-emerald-50 px-3 py-1 rounded-lg border border-emerald-100">
                    <x-heroicon-s-check-circle class="w-4 h-4" />
                    <span>Perubahan Disimpan</span>
                </div>
            @endif

            <x-primary-button class="px-8 py-3 bg-[#1b3985] hover:bg-[#152e6b] shadow-lg shadow-blue-900/20 rounded-xl">
                {{ __('Simpan Semua Perubahan') }}
            </x-primary-button>
        </div>
    </form>
</section>
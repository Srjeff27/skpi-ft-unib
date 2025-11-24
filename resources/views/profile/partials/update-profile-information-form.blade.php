<section class="max-w-5xl mx-auto">
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">@csrf</form>

    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-200 overflow-hidden">
        <form method="post" action="{{ route('profile.update') }}" class="divide-y divide-gray-100">
            @csrf
            @method('patch')

            {{-- BAGIAN 1: INFORMASI UTAMA & AVATAR --}}
            <div class="p-6 sm:p-10 space-y-8">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-100 pb-6">
                    <div>
                        <h2 class="text-xl font-bold text-[#1b3985] flex items-center gap-2">
                            <x-heroicon-o-user class="w-6 h-6" />
                            Informasi Profil
                        </h2>
                        <p class="mt-1 text-sm text-slate-500">Kelola identitas dan preferensi tampilan akun Anda.</p>
                    </div>
                    <div class="flex items-center gap-3 bg-blue-50 px-4 py-2 rounded-full">
                        <img src="{{ $user->avatar_url }}" alt="Avatar" class="h-10 w-10 rounded-full object-cover ring-2 ring-white">
                        <span class="text-xs font-medium text-blue-800">Avatar Aktif</span>
                    </div>
                </div>

                {{-- Pilihan Avatar --}}
                <div x-data="{ selectedAvatar: '{{ old('avatar', $user->avatar ?? '') }}' }">
                    <span class="block text-sm font-medium text-gray-700 mb-3">Pilih Karakter</span>
                    @php
                        $avatarOptions = [
                            'mahasiswa_male' => 'Leo', 'mahasiswa_female' => 'Stella',
                            'dosen' => 'Rysh', 'verifikator' => 'Anya', 'admin' => 'Zack',
                        ];
                    @endphp
                    <div class="grid grid-cols-3 sm:grid-cols-5 gap-4">
                        @foreach ($avatarOptions as $key => $label)
                            <label class="group relative cursor-pointer rounded-xl border p-2 flex flex-col items-center justify-center gap-2 transition-all duration-200 hover:bg-gray-50 hover:border-blue-200"
                                   :class="selectedAvatar === '{{ $key }}' ? 'ring-2 ring-[#1b3985] border-transparent bg-blue-50/30' : 'border-gray-200'">
                                <img src="{{ asset('avatars/' . match($key){
                                    'mahasiswa_male' => 'student-male.svg', 'mahasiswa_female' => 'student-female.svg',
                                    'dosen' => 'lecturer.svg', 'verifikator' => 'verifikator.svg', 'admin' => 'admin.svg',
                                    default => 'student-male.svg'
                                }) }}" alt="{{ $label }}" class="h-12 w-12 sm:h-16 sm:w-16 transition-transform group-hover:scale-110">
                                <input type="radio" name="avatar" value="{{ $key }}" class="sr-only" x-model="selectedAvatar">
                                <span class="text-xs font-semibold text-gray-600 group-hover:text-[#1b3985]">{{ $label }}</span>
                                
                                <div x-show="selectedAvatar === '{{ $key }}'" class="absolute top-1 right-1 text-[#1b3985]">
                                    <x-heroicon-s-check-circle class="w-5 h-5" />
                                </div>
                            </label>
                        @endforeach
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
                </div>

                {{-- Input Nama & Email --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-1">
                        <x-input-label for="name" value="Nama Lengkap" />
                        <div class="relative mt-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <x-heroicon-o-identification class="h-5 w-5 text-gray-400" />
                            </div>
                            <x-text-input id="name" name="name" type="text" class="pl-10 block w-full" :value="old('name', $user->name)" required autocomplete="name" />
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div class="col-span-1">
                        <x-input-label for="email" value="Alamat Email" />
                        <div class="relative mt-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <x-heroicon-o-envelope class="h-5 w-5 text-gray-400" />
                            </div>
                            <x-text-input id="email" name="email" type="email" class="pl-10 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />

                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                            <div class="mt-2 flex items-center gap-2 text-sm text-amber-600 bg-amber-50 p-2 rounded-md">
                                <x-heroicon-o-exclamation-triangle class="w-5 h-5" />
                                <div>
                                    <span>Email belum diverifikasi.</span>
                                    <button form="send-verification" class="underline font-semibold hover:text-amber-800">Kirim ulang.</button>
                                </div>
                            </div>
                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 text-sm text-green-600 font-medium">Tautan verifikasi baru telah dikirim.</p>
                            @endif
                        @endif
                    </div>

                    @if ((auth()->user()->role ?? null) === 'verifikator')
                        <div class="col-span-1 md:col-span-2">
                            <x-input-label value="Program Studi (Read Only)" />
                            <div class="mt-1 flex items-center gap-2 px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-gray-500 text-sm">
                                <x-heroicon-o-building-library class="w-5 h-5" />
                                {{ optional($user->prodi)->nama_prodi ?? '-' }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- BAGIAN 2: DATA AKADEMIK MAHASISWA --}}
            @if ((auth()->user()->role ?? null) === 'mahasiswa')
                <div class="p-6 sm:p-10 bg-slate-50/50 space-y-8">
                    <div class="border-l-4 border-[#1b3985] pl-4">
                        <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            Data Akademik
                        </h2>
                        <p class="mt-1 text-sm text-slate-500">Informasi terikat dengan database universitas.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- NPM --}}
                        <div class="col-span-1 md:col-span-2">
                            <x-input-label for="nim" value="NPM (Nomor Pokok Mahasiswa)" />
                            <x-text-input id="nim" name="nim" type="text" class="mt-1 block w-full bg-white" :value="old('nim', $user->nim)" :disabled="auth()->user()->role !== 'admin'" />
                            <x-input-error class="mt-2" :messages="$errors->get('nim')" />
                        </div>

                        {{-- Tempat Tanggal Lahir --}}
                        <div>
                            <x-input-label for="tempat_lahir" value="Tempat Lahir" />
                            <x-text-input id="tempat_lahir" name="tempat_lahir" type="text" class="mt-1 block w-full" :value="old('tempat_lahir', $user->tempat_lahir)" />
                        </div>
                        <div>
                            <x-input-label for="tanggal_lahir" value="Tanggal Lahir" />
                            <x-text-input id="tanggal_lahir" name="tanggal_lahir" type="date" class="mt-1 block w-full" :value="old('tanggal_lahir', optional($user->tanggal_lahir)->format('Y-m-d'))" />
                        </div>

                        {{-- Kontak & Angkatan --}}
                        <div>
                            <x-input-label for="nomor_hp" value="Nomor WhatsApp" />
                            <div class="relative mt-1">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">+62</span>
                                </div>
                                <x-text-input id="nomor_hp" name="nomor_hp" type="tel" class="pl-12 block w-full" :value="old('nomor_hp', $user->nomor_hp)" placeholder="812xxxx" />
                            </div>
                        </div>
                        <div>
                            <x-input-label for="angkatan" value="Tahun Angkatan" />
                            <x-text-input id="angkatan" name="angkatan" type="number" min="2000" max="{{ date('Y') + 1 }}" class="mt-1 block w-full" :value="old('angkatan', $user->angkatan)" />
                        </div>

                        {{-- Prodi --}}
                        <div class="col-span-1 md:col-span-2">
                            <x-input-label for="prodi_id" value="Program Studi" />
                            <select id="prodi_id" name="prodi_id" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#1b3985] focus:ring-[#1b3985] bg-white py-2.5">
                                <option value="" disabled>- Pilih Program Studi -</option>
                                @foreach ($prodis as $prodi)
                                    <option value="{{ $prodi->id }}" @selected(old('prodi_id', $user->prodi_id) == $prodi->id)>
                                        {{ $prodi->nama_prodi }} ({{ $prodi->jenjang }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            @endif

            {{-- FOOTER ACTION --}}
            <div class="px-6 sm:px-10 py-4 bg-gray-50 flex items-center justify-between">
                <div class="text-sm text-gray-500 italic">
                    Pastikan data yang Anda masukkan valid.
                </div>
                <div class="flex items-center gap-4">
                    @if (session('status') === 'profile-updated')
                        <span x-data="{ show: true }" x-show="show" x-transition.opacity.duration.1000ms x-init="setTimeout(() => show = false, 3000)" class="text-sm text-emerald-600 font-bold flex items-center gap-1">
                            <x-heroicon-s-check class="w-4 h-4" />
                            Tersimpan
                        </span>
                    @endif
                    <x-primary-button class="px-6 py-2.5 bg-[#1b3985] hover:bg-[#152e6b]">
                        {{ __('Simpan Perubahan') }}
                    </x-primary-button>
                </div>
            </div>
        </form>
    </div>
</section>
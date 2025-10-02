<form id="send-verification" method="post" action="{{ route('verification.send') }}">@csrf</form>

<form method="post" action="{{ route('profile.update') }}" class="space-y-8" enctype="multipart/form-data">
    @csrf
    @method('patch')

    {{-- KARTU 1: INFORMASI PROFIL --}}
    <div class="bg-white sm:rounded-lg">
        <header>
            <h2 class="text-lg font-bold text-gray-800">Informasi Profil</h2>
            <p class="mt-1 text-sm text-gray-500">Perbarui informasi profil dan alamat email akun Anda.</p>
        </header>

        <div class="mt-6 space-y-6">
            {{-- Foto Profil --}}
            <div x-data="{ photoName: null, photoPreview: null }">
                <x-input-label for="photo" value="Foto Profil" />
                <div class="mt-2 flex items-center gap-5">
                    <div class="flex-shrink-0">
                        <img x-show="!photoPreview"
                            src="{{ $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=1b3985&color=fff' }}"
                            alt="Foto Profil" class="h-20 w-20 rounded-full object-cover">
                        <div x-show="photoPreview" class="h-20 w-20 rounded-full bg-cover bg-center"
                            :style="'background-image: url(\'' + photoPreview + '\');'" x-cloak></div>
                    </div>
                    <div>
                        <input id="photo" name="photo" type="file" accept="image/*" class="hidden"
                            x-ref="photo"
                            @change="
                            photoName = $refs.photo.files[0].name;
                            const reader = new FileReader();
                            reader.onload = (e) => { photoPreview = e.target.result; };
                            reader.readAsDataURL($refs.photo.files[0]);
                        ">
                        <x-secondary-button type="button" @click.prevent="$refs.photo.click()">Ganti
                            Foto</x-secondary-button>
                        <p class="text-xs text-gray-500 mt-2">JPG, PNG, atau WEBP. Maks 2MB.</p>
                    </div>
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('photo')" />
            </div>
            {{-- Nama --}}
            <div>
                <x-input-label for="name" value="Nama Lengkap" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
                    required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>
            {{-- Email --}}
            <div>
                <x-input-label for="email" value="Alamat Email" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)"
                    required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                    <div class="mt-2 text-sm text-gray-600">
                        Email Anda belum terverifikasi.
                        <button form="send-verification" class="underline hover:text-gray-900">
                            Kirim ulang email verifikasi.
                        </button>
                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-1 font-semibold text-green-600">Tautan verifikasi baru telah dikirim.</p>
                        @endif
                    </div>
                @endif
            </div>

            @if ((auth()->user()->role ?? null) === 'verifikator')
                <div>
                    <x-input-label value="Program Studi" />
                    <x-text-input type="text" class="mt-1 block w-full bg-gray-50" :value="optional($user->prodi)->nama_prodi ?? '-'" disabled />
                </div>
            @endif
        </div>
    </div>

    @if ((auth()->user()->role ?? null) === 'mahasiswa')
        {{-- KARTU 2: DATA AKADEMIK --}}
        <div class="bg-white sm:rounded-lg pt-8 mt-8 border-t">
            <header>
                <h2 class="text-lg font-bold text-gray-800">Data Akademik</h2>
                <p class="mt-1 text-sm text-gray-500">Informasi ini terkait dengan data Anda sebagai mahasiswa.</p>
            </header>
            <div class="mt-6 space-y-6">
                <div>
                    <x-input-label for="nim" value="NPM (Nomor Pokok Mahasiswa)" />
                    <x-text-input id="nim" name="nim" type="text" class="mt-1 block w-full"
                        :value="old('nim', $user->nim)" :disabled="auth()->user()->role !== 'admin'" />
                    <x-input-error class="mt-2" :messages="$errors->get('nim')" />
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="tempat_lahir" value="Tempat Lahir" />
                        <x-text-input id="tempat_lahir" name="tempat_lahir" type="text" class="mt-1 block w-full"
                            :value="old('tempat_lahir', $user->tempat_lahir)" />
                    </div>
                    <div>
                        <x-input-label for="tanggal_lahir" value="Tanggal Lahir" />
                        <x-text-input id="tanggal_lahir" name="tanggal_lahir" type="date" class="mt-1 block w-full"
                            :value="old('tanggal_lahir', $user->tanggal_lahir)" />
                    </div>
                </div>
                <div>
                    <x-input-label for="nomor_hp" value="Nomor HP" />
                    <x-text-input id="nomor_hp" name="nomor_hp" type="tel" class="mt-1 block w-full"
                        :value="old('nomor_hp', $user->nomor_hp)" />
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="angkatan" value="Tahun Masuk" />
                        <x-text-input id="angkatan" name="angkatan" type="number" min="1990"
                            max="{{ date('Y') + 1 }}" class="mt-1 block w-full" :value="old('angkatan', $user->angkatan)" />
                    </div>
                    <div>
                        <x-input-label for="prodi_id" value="Program Studi" />
                        <select id="prodi_id" name="prodi_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
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
        </div>

        {{-- KARTU 3: DATA KELULUSAN (ADMIN ONLY) --}}
        <div class="bg-white sm:rounded-lg pt-8 mt-8 border-t">
            <header>
                <h2 class="text-lg font-bold text-gray-800">Data Kelulusan</h2>
                <p class="mt-1 text-sm text-gray-500">Bagian ini hanya dapat diisi atau diubah oleh Administrator.</p>
            </header>
            <div class="mt-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="tanggal_lulus" value="Tanggal Lulus" />
                        <x-text-input id="tanggal_lulus" name="tanggal_lulus" type="date"
                            class="mt-1 block w-full" :value="old('tanggal_lulus', $user->tanggal_lulus)" :disabled="auth()->user()->role !== 'admin'" />
                    </div>
                    <div>
                        <x-input-label for="nomor_ijazah" value="Nomor Ijazah" />
                        <x-text-input id="nomor_ijazah" name="nomor_ijazah" type="text" class="mt-1 block w-full"
                            :value="old('nomor_ijazah', $user->nomor_ijazah)" :disabled="auth()->user()->role !== 'admin'" />
                    </div>
                    <div>
                        <x-input-label for="nomor_skpi" value="Nomor SKPI" />
                        <x-text-input id="nomor_skpi" name="nomor_skpi" type="text" class="mt-1 block w-full"
                            :value="old('nomor_skpi', $user->nomor_skpi)" :disabled="auth()->user()->role !== 'admin'" />
                    </div>
                    <div>
                        <x-input-label for="gelar_id" value="Gelar (ID)" />
                        <x-text-input id="gelar_id" name="gelar_id" type="text" class="mt-1 block w-full"
                            :value="old('gelar_id', $user->gelar_id)" :disabled="auth()->user()->role !== 'admin'" placeholder="S.T." />
                    </div>
                </div>
                <div>
                    <x-input-label for="gelar_en" value="Gelar (EN)" />
                    <x-text-input id="gelar_en" name="gelar_en" type="text" class="mt-1 block w-full"
                        :value="old('gelar_en', $user->gelar_en)" :disabled="auth()->user()->role !== 'admin'" placeholder="B.Eng." />
                </div>
            </div>
        </div>
    @endif

    {{-- FOOTER AKSI --}}
    <div class="flex items-center justify-end gap-4 pt-6 mt-6 border-t">
        @if (session('status') === 'profile-updated')
            <p x-data="{ show: true }" x-show="show" x-transition.opacity.duration.500ms x-init="setTimeout(() => show = false, 3000)"
                class="flex items-center gap-2 text-sm text-green-600 font-semibold" x-cloak>
                <x-heroicon-s-check-circle class="w-5 h-5" />
                {{ __('Tersimpan.') }}
            </p>
        @endif
        <x-primary-button>
            <x-heroicon-o-check-circle class="w-5 h-5 mr-2" />
            {{ __('Simpan Perubahan') }}
        </x-primary-button>
    </div>
</form>

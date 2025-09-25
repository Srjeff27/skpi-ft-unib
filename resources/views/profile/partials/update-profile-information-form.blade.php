<section x-data="{ photoName: null, photoPreview: null }">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informasi Profil') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Perbarui informasi profil dan alamat email akun Anda.') }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        {{-- Foto Profil --}}
        <div>
            <x-input-label for="photo" :value="__('Foto Profil')" />
            <div class="mt-2 flex flex-col sm:flex-row items-start sm:items-center gap-4">
                {{-- Image Preview --}}
                <div class="flex-shrink-0">
                    <img x-show="!photoPreview"
                        src="{{ $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=1b3985&color=fff' }}"
                        alt="Foto Profil" class="h-20 w-20 rounded-full object-cover" />
                    <span x-show="photoPreview" class="block h-20 w-20 rounded-full bg-cover bg-no-repeat bg-center"
                        :style="'background-image: url(\'' + photoPreview + '\');'"></span>
                </div>
                {{-- Tombol Upload Kustom --}}
                <div class="flex-grow">
                    <input id="photo" name="photo" type="file" accept="image/*" class="hidden" x-ref="photo"
                        @change="
                                photoName = $refs.photo.files[0].name;
                                const reader = new FileReader();
                                reader.onload = (e) => {
                                    photoPreview = e.target.result;
                                };
                                reader.readAsDataURL($refs.photo.files[0]);
                           " />
                    <x-secondary-button type="button" @click.prevent="$refs.photo.click()">
                        {{ __('Pilih Foto Baru') }}
                    </x-secondary-button>
                    <div x-show="photoName" class="text-sm text-gray-500 mt-2" x-text="photoName"></div>
                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, WEBP. Maks 2MB.</p>
                </div>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('photo')" />
        </div>

        {{-- Nama --}}
        <div>
            <x-input-label for="name" :value="__('Nama')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- Email --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)"
                required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Alamat email Anda belum terverifikasi.') }}
                        <button form="send-verification"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- NPM --}}
        <div>
            <x-input-label for="nim" :value="__('NPM')" />
            {{-- Dibuat readonly untuk mahasiswa, hanya bisa diubah oleh admin --}}
            <x-text-input id="nim" name="nim" type="text" class="mt-1 block w-full" :value="old('nim', $user->nim)" :disabled="auth()->user()->role !== 'admin'"
                autocomplete="off" />
            <x-input-error class="mt-2" :messages="$errors->get('nim')" />
        </div>

        {{-- Tempat & Tanggal Lahir --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="tempat_lahir" :value="__('Tempat Lahir')" />
                <x-text-input id="tempat_lahir" name="tempat_lahir" type="text" class="mt-1 block w-full" :value="old('tempat_lahir', $user->tempat_lahir)" autocomplete="off" />
                <x-input-error class="mt-2" :messages="$errors->get('tempat_lahir')" />
            </div>
            <div>
                <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
                <x-text-input id="tanggal_lahir" name="tanggal_lahir" type="date" class="mt-1 block w-full" :value="old('tanggal_lahir', $user->tanggal_lahir)" autocomplete="off" />
                <x-input-error class="mt-2" :messages="$errors->get('tanggal_lahir')" />
            </div>
        </div>

        {{-- Nomor HP --}}
        <div>
            <x-input-label for="nomor_hp" :value="__('Nomor HP')" />
            <x-text-input id="nomor_hp" name="nomor_hp" type="tel" class="mt-1 block w-full" :value="old('nomor_hp', $user->nomor_hp)" autocomplete="tel" />
            <x-input-error class="mt-2" :messages="$errors->get('nomor_hp')" />
        </div>

        {{-- Tahun Masuk --}}
        <div>
            {{-- Diubah dari Angkatan menjadi Tahun Masuk --}}
            <x-input-label for="angkatan" :value="__('Tahun Masuk')" />
            <x-text-input id="angkatan" name="angkatan" type="number" min="1900" max="{{ date('Y') + 1 }}"
                class="mt-1 block w-full" :value="old('angkatan', $user->angkatan)" autocomplete="off" />
            <x-input-error class="mt-2" :messages="$errors->get('angkatan')" />
        </div>

        {{-- Program Studi --}}
        <div>
            <x-input-label for="prodi_id" :value="__('Program Studi')" />
            <select id="prodi_id" name="prodi_id"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">- Pilih Program Studi -</option>
                @foreach ($prodis as $prodi)
                    <option value="{{ $prodi->id }}"
                        {{ (string) old('prodi_id', $user->prodi_id) === (string) $prodi->id ? 'selected' : '' }}>
                        {{ $prodi->nama_prodi }} ({{ $prodi->jenjang }})
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('prodi_id')" />
        </div>

        {{-- Bagian Khusus Admin --}}
        <div class="pt-4 mt-4 border-t border-gray-200">
            <h3 class="text-base font-medium text-gray-900">Data Kelulusan</h3>
            <p class="mt-1 text-sm text-gray-600">
                @if (auth()->user()->role === 'admin')
                    Bagian ini hanya dapat diisi dan diubah oleh Admin.
                @else
                    Bagian ini hanya dapat diisi oleh Admin.
                @endif
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="tanggal_lulus" :value="__('Tanggal Lulus')" />
                <x-text-input id="tanggal_lulus" name="tanggal_lulus" type="date" class="mt-1 block w-full" :value="old('tanggal_lulus', $user->tanggal_lulus)" :disabled="auth()->user()->role !== 'admin'" />
                <x-input-error class="mt-2" :messages="$errors->get('tanggal_lulus')" />
            </div>
            <div>
                <x-input-label for="nomor_ijazah" :value="__('Nomor Ijazah')" />
                <x-text-input id="nomor_ijazah" name="nomor_ijazah" type="text" class="mt-1 block w-full" :value="old('nomor_ijazah', $user->nomor_ijazah)" :disabled="auth()->user()->role !== 'admin'" />
                <x-input-error class="mt-2" :messages="$errors->get('nomor_ijazah')" />
            </div>
            <div>
                <x-input-label for="nomor_skpi" :value="__('Nomor SKPI')" />
                <x-text-input id="nomor_skpi" name="nomor_skpi" type="text" class="mt-1 block w-full" :value="old('nomor_skpi', $user->nomor_skpi)" :disabled="auth()->user()->role !== 'admin'" />
                <x-input-error class="mt-2" :messages="$errors->get('nomor_skpi')" />
            </div>
            <div>
                <x-input-label for="gelar_id" :value="__('Gelar (ID)')" />
                <x-text-input id="gelar_id" name="gelar_id" type="text" class="mt-1 block w-full" :value="old('gelar_id', $user->gelar_id)" :disabled="auth()->user()->role !== 'admin'" />
                <x-input-error class="mt-2" :messages="$errors->get('gelar_id')" />
            </div>
        </div>
        <x-input-label for="gelar_en" :value="__('Gelar (EN)')" />
        <x-text-input id="gelar_en" name="gelar_en" type="text" class="mt-1 block w-full" :value="old('gelar_en', $user->gelar_en)" :disabled="auth()->user()->role !== 'admin'" />
        <x-input-error class="mt-2" :messages="$errors->get('gelar_en')" />

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 font-medium">{{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>

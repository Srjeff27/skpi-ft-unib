<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informasi Profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-900">
            {{ __("Perbarui informasi profil akun Anda.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="photo" :value="__('Foto Profil')" />
            <div class="mt-1 flex items-center gap-4">
                <img src="{{ $user->profile_photo_path ? asset('storage/'.$user->profile_photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=1b3985&color=fff' }}" alt="Foto Profil" class="h-16 w-16 rounded-full object-cover" />
                <input id="photo" name="photo" type="file" accept="image/*" class="block text-sm text-gray-700" />
            </div>
            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, WEBP. Maks 2MB.</p>
            <x-input-error class="mt-2" :messages="$errors->get('photo')" />
        </div>
        <div>
            <x-input-label for="name" :value="__('Nama')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="nim" :value="__('NPM')" />
            <x-text-input id="nim" name="nim" type="text" class="mt-1 block w-full" :value="old('nim', $user->nim)" autocomplete="off" />
            <x-input-error class="mt-2" :messages="$errors->get('nim')" />
        </div>

        <div>
            <x-input-label for="angkatan" :value="__('Angkatan')" />
            <x-text-input id="angkatan" name="angkatan" type="number" min="1900" max="2100" class="mt-1 block w-full" :value="old('angkatan', $user->angkatan)" autocomplete="off" />
            <x-input-error class="mt-2" :messages="$errors->get('angkatan')" />
        </div>

        <div>
            <x-input-label for="prodi_id" :value="__('Program Studi')" />
            <select id="prodi_id" name="prodi_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">- Pilih Program Studi -</option>
                @foreach($prodis as $prodi)
                    <option value="{{ $prodi->id }}" {{ (string) old('prodi_id', $user->prodi_id) === (string) $prodi->id ? 'selected' : '' }}>
                        {{ $prodi->nama_prodi }} ({{ $prodi->jenjang }})
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('prodi_id')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Simpan') }}</p>
            @endif
        </div>
    </form>
</section>

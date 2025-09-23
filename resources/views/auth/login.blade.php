<x-guest-layout>
    <!-- Header -->
    <div class="text-center mb-6">
        <a href="/" class="inline-flex items-center justify-center">
            <span class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-[#fa7516]">
                <img src="{{ asset('images/logo-ft.png') }}" alt="Logo FT UNIB" class="h-10 w-10">
            </span>
        </a>
        <h1 class="mt-3 text-2xl font-semibold text-black">Masuk Mahasiswa</h1>
        <p class="mt-1 text-sm text-gray-600">Gunakan akun mahasiswa untuk melanjutkan</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-[#1b3985]" />
            <x-text-input id="email" class="mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nama@unib.ac.id" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-[#1b3985]" />

            <div class="relative">
                <x-text-input id="password" class="mt-1 w-full pr-12"
                                type="password"
                                name="password"
                                required autocomplete="current-password"
                                placeholder="Masukkan password" />

                <button type="button" id="toggle-password" aria-label="Tampilkan password"
                        class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-gray-700"
                        tabindex="-1">
                    <!-- eye icon -->
                    <svg id="icon-eye" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M2.25 12s3.75-7.5 9.75-7.5S21.75 12 21.75 12 18 19.5 12 19.5 2.25 12 2.25 12Z"/>
                        <path d="M12 15.75a3.75 3.75 0 1 0 0-7.5 3.75 3.75 0 0 0 0 7.5Z"/>
                    </svg>
                    <!-- eye-off icon -->
                    <svg id="icon-eye-off" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M3 3l18 18" />
                        <path d="M10.584 6.084A9.76 9.76 0 0 1 12 6c6 0 9.75 6 9.75 6a17.6 17.6 0 0 1-3.174 4.02M6.75 7.98C4.62 9.36 3 12 3 12s3.75 7.5 9.75 7.5c1.04 0 2.02-.16 2.933-.46"/>
                        <path d="M9.53 9.53a3.75 3.75 0 0 0 4.94 4.94"/>
                    </svg>
                </button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember + Forgot -->
        <div class="flex items-center justify-start">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded bg-white border-gray-300 text-[#fa7516] shadow-sm focus:ring-[#fa7516]" name="remember">
                <span class="ms-2 text-sm text-gray-700">{{ __('Ingat saya') }}</span>
            </label>
        </div>

        <!-- Actions -->
        <div class="space-y-3">
            <button type="submit" class="w-full inline-flex items-center justify-center rounded-md bg-[#fa7516] px-4 py-2.5 text-white font-medium shadow hover:bg-[#e5670c] focus:outline-none focus:ring-2 focus:ring-[#fa7516] focus:ring-offset-2">Masuk</button>
            <a href="/" class="w-full inline-flex items-center justify-center rounded-md border border-[#1b3985] px-4 py-2 text-[#1b3985] hover:bg-blue-50">
                Kembali ke Beranda
            </a>
        </div>
    </form>

    <script>
      (function(){
        const input = document.getElementById('password');
        const btn = document.getElementById('toggle-password');
        if(!input || !btn) return;
        const eye = document.getElementById('icon-eye');
        const eyeOff = document.getElementById('icon-eye-off');
        btn.addEventListener('click', () => {
          const isPwd = input.getAttribute('type') === 'password';
          input.setAttribute('type', isPwd ? 'text' : 'password');
          eye.classList.toggle('hidden', !isPwd);
          eyeOff.classList.toggle('hidden', isPwd);
          btn.setAttribute('aria-label', isPwd ? 'Sembunyikan password' : 'Tampilkan password');
        });
      })();
    </script>
</x-guest-layout>

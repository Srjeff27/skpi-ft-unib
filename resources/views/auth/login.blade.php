<x-guest-layout>
    <div class="text-center mb-8">
        <a href="/" class="inline-block relative group">
            <div class="absolute inset-0 bg-orange-200 rounded-full blur opacity-50 group-hover:opacity-75 transition duration-200"></div>
            <span class="relative inline-flex items-center justify-center h-20 w-20 rounded-full bg-gradient-to-br from-[#fa7516] to-[#e5670c] shadow-lg transform group-hover:scale-105 transition duration-200">
                <img src="{{ asset('images/logo-ft.png') }}" alt="Logo FT UNIB" class="h-12 w-12 drop-shadow-md">
            </span>
        </a>
        <h2 class="mt-6 text-3xl font-bold text-[#1b3985] tracking-tight">Portal Mahasiswa</h2>
        <p class="mt-2 text-sm text-gray-500">Silakan masuk untuk mengakses layanan akademik</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="flex flex-col space-y-4">
        <a href="{{ route('google.redirect') }}"
           class="relative w-full inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm font-semibold text-gray-700 shadow-sm transition-all duration-200 hover:bg-gray-50 hover:shadow-md hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200">
            <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"/><path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"/><path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.222,0-9.657-3.356-11.303-8h-8.05C7.341,36.66,15.025,44,24,44z"/><path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571l6.19,5.238C42.022,35.244,44,30.036,44,24C44,22.659,43.862,21.35,43.611,20.083z"/></svg>
            <span class="tracking-wide">Masuk dengan Google</span>
        </a>
    </div>

    <div class="relative my-7">
        <div class="absolute inset-0 flex items-center" aria-hidden="true">
            <div class="w-full border-t border-gray-200"></div>
        </div>
        <div class="relative flex justify-center">
            <span class="bg-white px-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Atau Email</span>
        </div>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Alamat Email')" class="text-[#1b3985] font-semibold mb-1.5" />
            <div class="relative rounded-md shadow-sm">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                    </svg>
                </div>
                <x-text-input id="email" class="block w-full rounded-xl border-gray-300 pl-10 focus:border-[#fa7516] focus:ring-[#fa7516] sm:text-sm py-2.5 transition-colors" 
                    type="email" name="email" :value="old('email')" required autofocus autocomplete="username" 
                    placeholder="npm@unib.ac.id" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Kata Sandi')" class="text-[#1b3985] font-semibold mb-1.5" />
            <div class="relative rounded-md shadow-sm">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                </div>
                <x-text-input id="password" class="block w-full rounded-xl border-gray-300 pl-10 pr-12 focus:border-[#fa7516] focus:ring-[#fa7516] sm:text-sm py-2.5 transition-colors" 
                    type="password" name="password" required autocomplete="current-password" 
                    placeholder="••••••••" />
                
                <button type="button" id="toggle-password" aria-label="Tampilkan password"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 transition-colors focus:outline-none" tabindex="-1">
                    <svg id="icon-eye" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <svg id="icon-eye-off" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-[#fa7516] shadow-sm focus:ring-[#fa7516] transition cursor-pointer"
                    name="remember">
                <span class="ms-2 text-sm text-gray-600 group-hover:text-gray-900 transition-colors">{{ __('Ingat saya') }}</span>
            </label>
            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-[#1b3985] hover:text-[#fa7516] transition-colors" href="{{ route('password.request') }}">
                    {{ __('Lupa password?') }}
                </a>
            @endif
        </div>

        <div class="pt-4 flex flex-col gap-3">
            <button type="submit"
                class="w-full inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-[#fa7516] to-[#e5670c] px-4 py-3 text-white font-bold tracking-wide shadow-lg shadow-orange-200 transition-all duration-200 hover:shadow-orange-300 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-[#fa7516] focus:ring-offset-2">
                Masuk Sekarang
            </button>
            
            <a href="{{ route('register') }}"
                class="w-full inline-flex items-center justify-center rounded-xl border border-transparent bg-blue-50 px-4 py-3 font-semibold text-[#1b3985] hover:bg-blue-100 transition-colors">
                Belum punya akun? Daftar
            </a>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('password');
            const btn = document.getElementById('toggle-password');
            
            if (input && btn) {
                const eye = document.getElementById('icon-eye');
                const eyeOff = document.getElementById('icon-eye-off');
                
                btn.addEventListener('click', () => {
                    const isPwd = input.getAttribute('type') === 'password';
                    input.setAttribute('type', isPwd ? 'text' : 'password');
                    
                    if(isPwd) {
                        eye.classList.add('hidden');
                        eyeOff.classList.remove('hidden');
                    } else {
                        eye.classList.remove('hidden');
                        eyeOff.classList.add('hidden');
                    }
                    
                    btn.setAttribute('aria-label', isPwd ? 'Sembunyikan password' : 'Tampilkan password');
                });
            }
        });
    </script>
</x-guest-layout>
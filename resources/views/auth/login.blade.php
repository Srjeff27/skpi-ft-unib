<x-guest-layout>
    <div class="text-center mb-8 space-y-3">
        <a href="/" class="inline-block relative group">
            <div class="absolute inset-0 bg-orange-200 rounded-full blur opacity-50 group-hover:opacity-75 transition duration-200"></div>
            <span class="relative inline-flex items-center justify-center h-20 w-20 rounded-full bg-gradient-to-br from-[#fa7516] to-[#e5670c] shadow-lg transform group-hover:scale-105 transition duration-200">
                <img src="{{ asset('images/logo-ft.png') }}" alt="Logo FT UNIB" class="h-12 w-12 drop-shadow-md">
            </span>
        </a>
        <div class="space-y-1">
            <h2 class="text-3xl font-bold text-[#1b3985] tracking-tight">Portal Mahasiswa</h2>
            <p class="text-sm text-gray-500">Masuk untuk mengelola portofolio, memantau verifikasi SKPI, dan akses layanan akademik.</p>
        </div>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    @php
        $isMaintenance = (bool) \App\Models\Setting::get('maintenance', 0);
    @endphp

    @if ($isMaintenance)
        <div class="rounded-lg border border-amber-200 bg-amber-50 p-4 text-center text-sm text-amber-800">
            <p>Sistem dalam mode perbaikan. Login untuk mahasiswa dinonaktifkan sementara.</p>
        </div>
    @else
        <div class="flex flex-col space-y-4">
            <a href="{{ route('google.redirect') }}"
               class="relative w-full inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm font-semibold text-gray-700 shadow-sm transition-all duration-200 hover:bg-gray-50 hover:shadow-md hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200">
                <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"/><path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"/><path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.222,0-9.657-3.356-11.303-8h-8.05C7.341,36.66,15.025,44,24,44z"/><path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571l6.19,5.238C42.022,35.244,44,30.036,44,24C44,22.659,43.862,21.35,43.611,20.083z"/></svg>
                <span class="tracking-wide">Masuk dengan Google</span>
            </a>
        </div>
    @endif

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
                    <x-heroicon-o-envelope class="h-5 w-5 text-gray-400" />
                </div>
                <x-text-input id="email" class="block w-full rounded-xl border-gray-300 pl-10 focus:border-[#fa7516] focus:ring-[#fa7516] sm:text-sm py-2.5 transition-colors" 
                    type="email" name="email" :value="old('email')" required autofocus autocomplete="username" 
                    placeholder="nama@unib.ac.id" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Kata Sandi')" class="text-[#1b3985] font-semibold mb-1.5" />
            <div class="relative rounded-md shadow-sm">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <x-heroicon-o-lock-closed class="h-5 w-5 text-gray-400" />
                </div>
                <x-text-input id="password" class="block w-full rounded-xl border-gray-300 pl-10 focus:border-[#fa7516] focus:ring-[#fa7516] sm:text-sm py-2.5 transition-colors" 
                    type="password" name="password" required autocomplete="current-password" 
                    placeholder="••••••••" />
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
</x-guest-layout>

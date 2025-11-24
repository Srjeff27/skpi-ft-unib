<x-guest-layout>
    <div class="text-center mb-8">
        <a href="/" class="inline-block relative group">
            <div class="absolute inset-0 bg-orange-200 rounded-full blur opacity-50 group-hover:opacity-75 transition duration-200"></div>
            <span class="relative inline-flex items-center justify-center h-20 w-20 rounded-full bg-gradient-to-br from-[#fa7516] to-[#e5670c] shadow-lg transform group-hover:scale-105 transition duration-200">
                <img src="{{ asset('images/logo-ft.png') }}" alt="Logo FT UNIB" class="h-12 w-12 drop-shadow-md">
            </span>
        </a>
        <h2 class="mt-6 text-3xl font-bold text-[#1b3985] tracking-tight">Buat Akun Baru</h2>
        <p class="mt-2 text-sm text-gray-500">Pendaftaran hanya dapat dilakukan melalui akun Google.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="flex flex-col space-y-4 pt-4">
        <a href="{{ route('google.redirect') }}"
           class="relative w-full inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm font-semibold text-gray-700 shadow-sm transition-all duration-200 hover:bg-gray-50 hover:shadow-md hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200">
            <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"/><path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"/><path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.222,0-9.657-3.356-11.303-8h-8.05C7.341,36.66,15.025,44,24,44z"/><path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571l6.19,5.238C42.022,35.244,44,30.036,44,24C44,22.659,43.862,21.35,43.611,20.083z"/></svg>
            <span class="tracking-wide">Daftar dengan Google</span>
        </a>
    </div>

    <div class="relative my-7">
        <div class="absolute inset-0 flex items-center" aria-hidden="true">
            <div class="w-full border-t border-gray-200"></div>
        </div>
        <div class="relative flex justify-center">
            <span class="bg-white px-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Atau</span>
        </div>
    </div>

    <div class="text-center">
        <a href="{{ route('login') }}"
            class="w-full inline-flex items-center justify-center rounded-xl border border-transparent bg-blue-50 px-4 py-3 font-semibold text-[#1b3985] hover:bg-blue-100 transition-colors">
            Sudah punya akun? Masuk
        </a>
    </div>
</x-guest-layout>

<x-guest-layout>
    <div class="text-center mb-6">
        <a href="/" class="inline-flex items-center justify-center">
            <span class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-[#1b3985]">
                <img src="{{ asset('images/logo-ft.png') }}" alt="Logo FT UNIB" class="h-10 w-10">
            </span>
        </a>
        <h1 class="mt-3 text-2xl font-semibold text-black">Masuk Admin</h1>
        <p class="mt-1 text-sm text-gray-600">Gunakan akun admin untuk melanjutkan</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('admin.login') }}" class="space-y-5">
        @csrf
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-[#1b3985]" />
            <x-text-input id="email" class="mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-[#1b3985]" />
            <x-text-input id="password" class="mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <div class="flex items-center justify-start">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded bg-white border-gray-300 text-[#1b3985] shadow-sm focus:ring-[#1b3985]" name="remember">
                <span class="ms-2 text-sm text-gray-700">{{ __('Ingat saya') }}</span>
            </label>
        </div>
        <div class="pt-2 flex flex-col sm:flex-row-reverse gap-3">
            <button type="submit" class="w-full inline-flex items-center justify-center rounded-md bg-[#1b3985] px-4 py-2.5 text-white font-medium shadow-sm hover:bg-[#172e6a]">Masuk</button>
            <a href="/" class="w-full inline-flex items-center justify-center rounded-md border border-[#1b3985] px-4 py-2 font-medium text-[#1b3985] hover:bg-blue-50">Kembali ke Beranda</a>
        </div>
    </form>
</x-guest-layout>


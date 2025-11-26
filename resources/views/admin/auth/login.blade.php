<x-guest-layout>
    <div class="text-center mb-8 space-y-4">
        <a href="/" class="inline-block relative group">
            <div class="absolute inset-0 bg-blue-200 rounded-full blur opacity-40 group-hover:opacity-60 transition duration-200"></div>
            <span class="relative inline-flex items-center justify-center h-20 w-20 rounded-full bg-gradient-to-br from-[#0A2E73] to-[#1b3985] shadow-lg ring-4 ring-white">
                <img src="{{ asset('images/logo-ft.png') }}" alt="Logo FT UNIB" class="h-12 w-12 drop-shadow" />
            </span>
        </a>
        <div class="space-y-1">
            <h1 class="text-3xl font-extrabold text-[#0A2E73] tracking-tight">Masuk Admin</h1>
            <p class="text-sm text-gray-500">Gunakan akun admin untuk melanjutkan</p>
        </div>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('admin.login') }}" class="space-y-6">
        @csrf
        <div>
            <label for="email" class="block text-sm font-semibold text-[#0A2E73] mb-1.5">Email</label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <x-heroicon-o-envelope class="h-5 w-5 text-gray-400" />
                </div>
                <input id="email" name="email" type="email" autocomplete="username" required autofocus
                    value="{{ old('email') }}"
                    class="block w-full rounded-xl border-gray-200 bg-white/80 pl-10 pr-3 py-2.5 text-gray-800 shadow-sm focus:border-[#0A2E73] focus:ring-[#0A2E73] transition" placeholder="admin@unib.ac.id">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div x-data="{ show: false }">
            <label for="password" class="block text-sm font-semibold text-[#0A2E73] mb-1.5">Password</label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <x-heroicon-o-lock-closed class="h-5 w-5 text-gray-400" />
                </div>
                <input id="password" name="password" x-bind:type="show ? 'text' : 'password'" autocomplete="current-password" required
                    class="block w-full rounded-xl border-gray-200 bg-white/80 pl-10 pr-10 py-2.5 text-gray-800 shadow-sm focus:border-[#0A2E73] focus:ring-[#0A2E73] transition" placeholder="••••••••">
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-[#0A2E73] transition">
                    <x-heroicon-o-eye class="h-5 w-5" x-show="!show" />
                    <x-heroicon-o-eye-slash class="h-5 w-5" x-show="show" />
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-[#0A2E73] shadow-sm focus:ring-[#0A2E73]" name="remember">
                <span class="ms-2 text-sm text-gray-600">Ingat saya</span>
            </label>
        </div>

        <div class="pt-2 grid grid-cols-1 sm:grid-cols-2 gap-3">
            <a href="/" class="inline-flex items-center justify-center rounded-xl border border-[#0A2E73] px-4 py-3 text-sm font-semibold text-[#0A2E73] hover:bg-blue-50 transition">
                Kembali ke Beranda
            </a>
            <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-[#0A2E73] to-[#1b3985] px-4 py-3 text-sm font-bold text-white shadow-lg shadow-blue-200 hover:shadow-blue-300 transition hover:-translate-y-0.5">
                Masuk
            </button>
        </div>
    </form>
</x-guest-layout>

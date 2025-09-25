<div class="fi-login-header text-center mb-6">
    <a href="/" class="inline-flex items-center justify-center">
        <span class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-[#fa7516] shadow-lg shadow-orange-200">
            <img src="{{ asset('images/logo-ft.png') }}" alt="Logo FT UNIB" class="h-10 w-10">
        </span>
    </a>

    <h1 class="mt-3 text-2xl font-semibold text-black">
        {{ filament()->getId() === 'admin' ? 'Masuk Admin' : 'Masuk Verifikator' }}
    </h1>
    <p class="mt-1 text-sm text-gray-600">
        {{ filament()->getId() === 'admin' ? 'Gunakan akun admin untuk melanjutkan' : 'Gunakan akun verifikator untuk melanjutkan' }}
    </p>
</div>

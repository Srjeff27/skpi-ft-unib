<div class="text-center mb-4">
    <h1 class="mt-1 text-2xl font-bold text-black">
        {{ filament()->getId() === 'admin' ? 'Masuk Admin' : 'Masuk Verifikator' }}
    </h1>
    <p class="mt-1 text-sm text-gray-600">
        {{ filament()->getId() === 'admin' ? 'Gunakan akun admin untuk melanjutkan' : 'Gunakan akun verifikator untuk melanjutkan' }}
    </p>
</div>

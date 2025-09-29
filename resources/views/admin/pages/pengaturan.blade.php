<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">Keamanan & Pengaturan</h2>
        <p class="text-sm text-gray-500">Role & permission, log aktivitas, template SKPI, batas waktu.</p>
    </x-slot>

    <div class="pt-8 pb-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm p-6 text-gray-700 space-y-3">
                <p>Halaman ini placeholder. Implementasi lanjutan: manajemen role/permission, konfigurasi template SKPI, batas waktu pengisian, tautan ke log aktivitas.</p>
                <a href="{{ route('admin.activity_logs.index') }}" class="text-[#1b3985] underline">Lihat Log Aktivitas</a>
            </div>
        </div>
    </div>
</x-app-layout>


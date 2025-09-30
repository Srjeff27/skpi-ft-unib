<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            @php
                $hour = now()->timezone(config('app.timezone'))->format('H');
                $greet =
                    $hour < 11
                        ? 'Selamat Pagi'
                        : ($hour < 15
                            ? 'Selamat Siang'
                            : ($hour < 18
                                ? 'Selamat Sore'
                                : 'Selamat Malam'));
                $name = auth()->user()?->name ?? 'Pengguna';
            @endphp
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">{{ $greet }}, {{ $name }}!</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola informasi akun dan keamanan Anda.</p>
        </div>
    </x-slot>

    <div class="pt-6 pb-24 sm:pt-8 sm:pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Kartu Informasi Profil --}}
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl">
                <div class="p-6 sm:p-8">
                    {{-- DIUBAH: Wrapper max-w-xl dihapus agar konten memenuhi kartu --}}
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Kartu Perbarui Password --}}
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl">
                <div class="p-6 sm:p-8">
                    {{-- DIUBAH: Wrapper max-w-xl dihapus agar konten memenuhi kartu --}}
                    @include('profile.partials.update-password-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

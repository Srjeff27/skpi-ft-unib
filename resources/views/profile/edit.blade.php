<x-app-layout>
    <x-slot name="header">
        @php
            $hour = now()->timezone(config('app.timezone'))->format('H');
            $greet =
                $hour > 3 && $hour < 11
                    ? 'Selamat Pagi'
                    : ($hour > 11 && $hour < 15
                        ? 'Selamat Siang'
                        : ($hour > 15 && $hour < 18
                            ? 'Selamat Sore'
                            : 'Selamat Malam'));
            $name = auth()->user()?->name ?? 'Pengguna';
        @endphp
        {{-- Menggunakan text-gray-900 untuk kontras yang lebih baik daripada text-black murni --}}
        <h2 class="font-semibold text-xl text-gray-900 leading-tight">{{ $greet }}, {{ $name }}</h2>
        <p class="text-sm text-gray-500">Profil</p>
    </x-slot>

    {{-- DIUBAH: pt-12 untuk padding atas, pb-24 untuk mobile, dan md:pb-12 untuk desktop --}}
    <div class="pt-12 pb-24 md:pb-12">
        {{-- DIUBAH: Ditambahkan px-4 untuk padding horizontal di mobile --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- DIUBAH: sm:rounded-lg menjadi rounded-lg agar sudut melengkung di semua ukuran layar --}}
            <div class="p-4 sm:p-8 bg-white shadow rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- DIUBAH: sm:rounded-lg menjadi rounded-lg --}}
            <div class="p-4 sm:p-8 bg-white shadow rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

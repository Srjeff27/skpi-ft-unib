<x-app-layout>
    <x-slot name="header">
        @php
            $hour = now()->timezone(config('app.timezone'))->format('H');
            $greet = $hour < 11 ? 'Selamat Pagi' : ($hour < 15 ? 'Selamat Siang' : ($hour < 18 ? 'Selamat Sore' : 'Selamat Malam'));
            $name = auth()->user()?->name ?? 'Pengguna';
        @endphp
        <h2 class="font-semibold text-xl text-gray-900 leading-tight">{{ $greet }}, {{ $name }}</h2>
        <p class="text-sm text-gray-500">Profil</p>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            
        </div>
    </div>
</x-app-layout>

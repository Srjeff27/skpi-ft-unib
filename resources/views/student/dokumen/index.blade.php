<x-app-layout>
    <x-slot name="header">
        @php
            $hour = now()->timezone(config('app.timezone'))->format('H');
            $greet = $hour < 11 ? 'Selamat Pagi' : ($hour < 15 ? 'Selamat Siang' : ($hour < 18 ? 'Selamat Sore' : 'Selamat Malam'));
            $name = auth()->user()?->name ?? 'Pengguna';
        @endphp
        <h2 class="font-semibold text-xl text-black leading-tight">{{ $greet }}, {{ $name }}</h2>
        <p class="text-sm text-gray-500">Dokumen SKPI</p>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-700">
                    <p>Halaman dokumen SKPI akan menampilkan berkas SKPI final/preview setelah diverifikasi. (Admin)</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

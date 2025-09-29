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
        <h2 class="font-semibold text-xl text-black leading-tight">{{ $greet }}, {{ $name }}</h2>
        <p class="text-sm text-gray-500">Dokumen SKPI</p>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-700">
                    <div class="text-sm text-gray-500 mb-2">Preview SKPI</div>
                    <div class="aspect-[3/4] w-full border rounded-md overflow-hidden bg-gray-50">
                        <iframe src="{{ route('student.skpi.download') }}" class="w-full h-[80vh]" title="Preview SKPI"></iframe>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <form method="POST" action="{{ route('student.skpi.apply') }}" onsubmit="return confirm('Ajukan SKPI sekarang?')">
                    @csrf
                    <button class="inline-flex items-center rounded-md bg-[#1b3985] text-white px-4 py-2 text-sm">Ajukan SKPI</button>
                </form>
                <a href="{{ route('student.skpi.download') }}" target="_blank" class="inline-flex items-center rounded-md border border-[#1b3985] text-[#1b3985] px-4 py-2 text-sm hover:bg-blue-50">Buka di Tab Baru</a>
            </div>
        </div>
    </div>
</x-app-layout>

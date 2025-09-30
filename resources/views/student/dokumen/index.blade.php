<x-app-layout>
    <x-slot name="header">
        <div class="max-w-5xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            @php
                $hour = now()->timezone(config('app.timezone'))->format('H');
                $greet =
                    $hour >= 4 && $hour < 11
                        ? 'Selamat Pagi'
                        : ($hour >= 11 && $hour < 15
                            ? 'Selamat Siang'
                            : ($hour >= 15 && $hour < 18
                                ? 'Selamat Sore'
                                : 'Selamat Malam'));
                $name = auth()->user()?->name ?? 'Pengguna';
            @endphp
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $greet }}, {{ $name }}!</h2>
            <p class="text-sm text-gray-500 mt-1">Lihat preview Surat Keterangan Pendamping Ijazah (SKPI) Anda di bawah
                ini.</p>
        </div>
    </x-slot>


    <div class="pt-6 pb-24 sm:pb-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6 px-4">

            {{-- KARTU PREVIEW DOKUMEN --}}
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl">
                <div class="p-4 sm:p-6 text-gray-700">
                    <div class="text-sm font-medium text-gray-500 mb-2">Preview SKPI</div>
                    <div class="max-w-xl mx-auto aspect-[1/1.414] w-full border rounded-lg overflow-hidden bg-gray-100">
                        <iframe src="{{ route('student.skpi.download') }}" class="w-full h-full border-0"
                            title="Preview SKPI"></iframe>
                    </div>
                </div>
            </div>

            {{-- TOMBOL AKSI --}}
            <div class="flex flex-col sm:flex-row items-center gap-3">
                <form method="POST" action="{{ route('student.skpi.apply') }}"
                    onsubmit="return confirm('Anda yakin ingin mengajukan SKPI sekarang? Pastikan semua data sudah benar.')"
                    class="w-full sm:w-auto">
                    @csrf
                    <button
                        class="w-full sm:w-auto inline-flex items-center justify-center rounded-md bg-[#1b3985] hover:bg-blue-800 text-white px-4 py-2 text-sm font-semibold shadow-sm transition-colors">
                        <x-heroicon-o-paper-airplane class="w-5 h-5 mr-2" />
                        Ajukan SKPI
                    </button>
                </form>
                <a href="{{ route('student.skpi.download') }}" target="_blank"
                    class="w-full sm:w-auto inline-flex items-center justify-center rounded-md border border-gray-300 bg-white text-gray-700 px-4 py-2 text-sm font-semibold shadow-sm hover:bg-gray-50 transition-colors">
                    <x-heroicon-o-arrow-top-right-on-square class="w-5 h-5 mr-2" />
                    Buka di Tab Baru
                </a>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    {{-- HEADER HALAMAN --}}
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Notifikasi
            </h2>

            <div class="mt-3 sm:mt-0 flex items-center gap-2 flex-wrap max-[350px]:flex-col max-[350px]:items-stretch">
                {{-- Tombol Aksi (Hanya tampil jika ada notifikasi) --}}
                @if ($notifications->count() > 0)
                    <form method="POST" action="{{ route('student.notifications.read_all') }}">
                        @csrf
                        <button
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-md bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 max-[350px]:w-full">
                            <x-heroicon-o-check-circle class="w-5 h-5" />
                            Tandai semua sudah dibaca
                        </button>
                    </form>
                    <form method="POST" action="{{ route('student.notifications.delete_all') }}" onsubmit="return confirm('Hapus semua notifikasi?')">
                        @csrf
                        <button
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-md bg-red-600 hover:bg-red-700 text-white text-sm font-semibold shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 max-[350px]:w-full">
                            <x-heroicon-o-trash class="w-5 h-5" />
                            Hapus semua
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </x-slot>

    {{-- DIUBAH: Padding bawah untuk mobile diperbesar agar tidak tertutup nav bar --}}
    <div class="pt-6 pb-24 sm:pt-8 sm:pb-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- CONTAINER DAFTAR NOTIFIKASI --}}
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="divide-y divide-gray-200">
                    @forelse($notifications as $n)
                        @php
                            $data = $n->data;
                            // Logika ikon dan warna yang konsisten dengan dropdown
                            $icon = 'heroicon-o-bell';
                            $color = 'text-gray-400 bg-gray-100';
                            if (Str::contains(strtolower($data['title'] ?? ''), 'ditolak')) {
                                $icon = 'heroicon-o-x-circle';
                                $color = 'text-red-600 bg-red-100';
                            } elseif (Str::contains(strtolower($data['title'] ?? ''), 'perbaikan')) {
                                $icon = 'heroicon-o-pencil-square';
                                $color = 'text-amber-600 bg-amber-100';
                            } elseif (
                                Str::contains(strtolower($data['title'] ?? ''), ['diterima', 'disetujui', 'verified'])
                            ) {
                                $icon = 'heroicon-o-check-circle';
                                $color = 'text-green-600 bg-green-100';
                            }
                        @endphp

                        {{-- ITEM NOTIFIKASI --}}
                        <div
                            class="p-4 sm:p-5 flex items-start gap-4 transition-colors duration-150 {{ is_null($n->read_at) ? 'bg-blue-50' : 'hover:bg-gray-50' }}">

                            {{-- Ikon Notifikasi --}}
                            <div
                                class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center {{ $color }}">
                                <x-dynamic-component :component="$icon" class="w-6 h-6" />
                            </div>

                            {{-- Konten Utama Notifikasi --}}
                            <div class="flex-grow flex flex-col sm:flex-row sm:justify-between sm:items-start gap-2">

                                {{-- Kiri: Judul dan Pesan --}}
                                <div class="flex-grow text-sm sm:text-base">
                                    <p class="font-bold text-gray-900">{{ $data['title'] ?? 'Notifikasi' }}</p>
                                    @if (!empty($data['judul_kegiatan']))
                                        <p class="text-gray-700 mt-0.5">{{ $data['judul_kegiatan'] }}</p>
                                    @endif
                                    @if (!empty($data['message']))
                                        <p class="text-xs sm:text-sm text-gray-500 mt-1">{{ $data['message'] }}</p>
                                    @endif
                                </div>

                                {{-- Kanan: Waktu dan Tombol Aksi --}}
                                <div class="flex-shrink-0 sm:text-right mt-2 sm:mt-0">
                                    <p class="text-xs text-gray-400 mb-2">
                                        {{ optional($n->created_at)->diffForHumans() }}</p>

                                    {{-- Tombol Aksi (Tandai dibaca/belum dibaca) --}}
                                    @if (is_null($n->read_at))
                                        <form method="POST" action="{{ route('student.notifications.read', $n->id) }}">
                                            @csrf
                                            <button class="text-xs font-semibold text-blue-600 hover:underline">Tandai
                                                dibaca</button>
                                        </form>
                                    @else
                                        <form method="POST"
                                            action="{{ route('student.notifications.unread', $n->id) }}">
                                            @csrf
                                            <button
                                                class="text-xs font-semibold text-gray-500 hover:underline">Tandai
                                                belum dibaca</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        {{-- TAMPILAN KOSONG --}}
                        <div class="text-center p-12 sm:p-16">
                            <div class="mx-auto w-16 h-16 flex items-center justify-center bg-gray-100 rounded-full">
                                <x-heroicon-o-bell-slash class="w-8 h-8 text-gray-400" />
                            </div>
                            <h3 class="mt-4 text-lg font-semibold text-gray-800">Tidak Ada Notifikasi</h3>
                            <p class="mt-1 text-sm text-gray-500">Semua notifikasi Anda akan muncul di sini.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- PAGINASI --}}
            @if ($notifications->hasPages())
                <div class="mt-8">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

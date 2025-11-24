<x-app-layout>
    <div class="min-h-screen bg-gray-50/50 pb-20">
        {{-- HEADER SECTION --}}
        <div class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-20">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">
                            Notifikasi
                        </h2>
                        <p class="text-sm text-gray-500 mt-1">
                            Pantau status pengajuan dan informasi akademik terbaru.
                        </p>
                    </div>

                    @if ($notifications->count() > 0)
                        <div class="flex items-center gap-3">
                            <form method="POST" action="{{ route('student.notifications.read_all') }}">
                                @csrf
                                <button type="submit" 
                                    class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all w-full sm:w-auto shadow-sm">
                                    <x-heroicon-o-check-circle class="w-4 h-4 text-gray-500" />
                                    <span>Baca Semua</span>
                                </button>
                            </form>
                            
                            <form method="POST" action="{{ route('student.notifications.delete_all') }}" onsubmit="return confirm('Hapus semua notifikasi?')">
                                @csrf
                                <button type="submit" 
                                    class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-white border border-red-200 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all w-full sm:w-auto shadow-sm">
                                    <x-heroicon-o-trash class="w-4 h-4" />
                                    <span class="hidden sm:inline">Hapus Semua</span>
                                    <span class="sm:hidden">Hapus</span>
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- CONTENT SECTION --}}
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="divide-y divide-gray-100">
                    @forelse($notifications as $n)
                        @php
                            $data = $n->data;
                            $titleLower = strtolower($data['title'] ?? '');
                            $isUnread = is_null($n->read_at);

                            // Logika Tampilan Berdasarkan Konteks
                            if (Str::contains($titleLower, ['ditolak', 'gagal', 'rejected'])) {
                                $icon = 'heroicon-o-x-circle';
                                $iconColor = 'text-rose-600 bg-rose-50';
                                $borderColor = 'border-rose-500';
                            } elseif (Str::contains($titleLower, ['perbaikan', 'revisi', 'revision'])) {
                                $icon = 'heroicon-o-pencil-square';
                                $iconColor = 'text-amber-600 bg-amber-50';
                                $borderColor = 'border-amber-500';
                            } elseif (Str::contains($titleLower, ['diterima', 'disetujui', 'verified', 'selesai'])) {
                                $icon = 'heroicon-o-check-badge';
                                $iconColor = 'text-emerald-600 bg-emerald-50';
                                $borderColor = 'border-emerald-500';
                            } else {
                                $icon = 'heroicon-o-bell';
                                $iconColor = 'text-indigo-600 bg-indigo-50';
                                $borderColor = 'border-indigo-500';
                            }
                        @endphp

                        <div class="group relative p-5 sm:p-6 transition-all duration-200 hover:bg-gray-50 flex gap-4 {{ $isUnread ? 'bg-indigo-50/30' : 'bg-white' }}">
                            
                            {{-- Indikator Belum Dibaca (Garis Kiri) --}}
                            @if($isUnread)
                                <div class="absolute left-0 top-0 bottom-0 w-1 {{ $borderColor }}"></div>
                            @endif

                            {{-- Ikon --}}
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center {{ $iconColor }}">
                                    <x-dynamic-component :component="$icon" class="w-6 h-6" />
                                </div>
                            </div>

                            {{-- Konten Teks --}}
                            <div class="flex-grow min-w-0">
                                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-1">
                                    <h3 class="text-base font-semibold text-gray-900 pr-4 leading-snug">
                                        {{ $data['title'] ?? 'Pemberitahuan Sistem' }}
                                        @if($isUnread)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 ml-2 sm:hidden">
                                                Baru
                                            </span>
                                        @endif
                                    </h3>
                                    <span class="text-xs font-medium text-gray-400 whitespace-nowrap flex-shrink-0 mt-1 sm:mt-0">
                                        {{ optional($n->created_at)->diffForHumans() }}
                                    </span>
                                </div>

                                @if (!empty($data['judul_kegiatan']))
                                    <p class="mt-1 text-sm font-medium text-gray-700">
                                        {{ $data['judul_kegiatan'] }}
                                    </p>
                                @endif

                                @if (!empty($data['message']))
                                    <p class="mt-1 text-sm text-gray-500 leading-relaxed line-clamp-2 group-hover:line-clamp-none transition-all">
                                        {{ $data['message'] }}
                                    </p>
                                @endif

                                {{-- Aksi Item --}}
                                <div class="mt-3 flex items-center gap-4">
                                    @if ($isUnread)
                                        <form method="POST" action="{{ route('student.notifications.read', $n->id) }}">
                                            @csrf
                                            <button type="submit" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 hover:underline transition-colors flex items-center gap-1">
                                                Tandai sudah dibaca
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('student.notifications.unread', $n->id) }}">
                                            @csrf
                                            <button type="submit" class="text-xs font-medium text-gray-400 hover:text-gray-600 hover:underline transition-colors">
                                                Tandai belum dibaca
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-16 px-4 text-center">
                            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                <x-heroicon-o-bell-slash class="w-10 h-10 text-gray-300" />
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Tidak ada notifikasi</h3>
                            <p class="text-gray-500 max-w-sm mt-1">
                                Belum ada pemberitahuan baru. Aktivitas terbaru Anda akan muncul di sini.
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>

            @if ($notifications->hasPages())
                <div class="mt-6">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
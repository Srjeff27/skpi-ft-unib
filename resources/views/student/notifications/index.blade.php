<x-app-layout>
    <div class="min-h-screen bg-slate-50/50">
        
        {{-- Header Section --}}
        <div class="sticky top-0 z-30 bg-white/80 backdrop-blur-xl border-b border-slate-200 supports-[backdrop-filter]:bg-white/60">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="py-5 md:flex md:items-center md:justify-between gap-4">
                    <div class="min-w-0 flex-1">
                        <h2 class="text-2xl font-bold leading-7 text-slate-900 sm:truncate sm:text-3xl sm:tracking-tight">
                            Pusat Notifikasi
                        </h2>
                        <p class="mt-1 text-sm text-slate-500">
                            Pantau status validasi dan informasi akademik terbaru Anda.
                        </p>
                    </div>
                    
                    @if ($notifications->count() > 0)
                        <div class="mt-4 flex flex-col sm:flex-row sm:items-center gap-3 md:mt-0 md:ml-4">
                            <form method="POST" action="{{ route('student.notifications.read_all') }}">
                                @csrf
                                <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-lg bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 transition-all">
                                    <x-heroicon-m-check-circle class="-ml-0.5 h-4 w-4 text-slate-400" />
                                    Tandai Semua Dibaca
                                </button>
                            </form>
                            
                            <form method="POST" action="{{ route('student.notifications.delete_all') }}" onsubmit="return confirm('Yakin ingin menghapus semua riwayat notifikasi?');">
                                @csrf
                                <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-lg bg-rose-50 px-4 py-2 text-sm font-semibold text-rose-700 shadow-sm ring-1 ring-inset ring-rose-200 hover:bg-rose-100 transition-all">
                                    <x-heroicon-m-trash class="-ml-0.5 h-4 w-4 text-rose-500" />
                                    Bersihkan
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Content Section --}}
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                @forelse($notifications as $n)
                    @php
                        $data = $n->data;
                        $title = $data['title'] ?? 'Info Sistem';
                        $titleLower = strtolower($title);
                        $isUnread = is_null($n->read_at);

                        // Logic Penentuan Style Berdasarkan Konteks
                        if (Str::contains($titleLower, ['ditolak', 'gagal', 'rejected'])) {
                            $theme = ['icon' => 'heroicon-m-x-circle', 'color' => 'text-rose-600', 'bg' => 'bg-rose-100', 'border' => 'border-rose-500'];
                        } elseif (Str::contains($titleLower, ['perbaikan', 'revisi', 'revision'])) {
                            $theme = ['icon' => 'heroicon-m-pencil-square', 'color' => 'text-amber-600', 'bg' => 'bg-amber-100', 'border' => 'border-amber-500'];
                        } elseif (Str::contains($titleLower, ['diterima', 'disetujui', 'verified', 'sukses'])) {
                            $theme = ['icon' => 'heroicon-m-check-badge', 'color' => 'text-emerald-600', 'bg' => 'bg-emerald-100', 'border' => 'border-emerald-500'];
                        } else {
                            $theme = ['icon' => 'heroicon-m-bell', 'color' => 'text-[#1b3985]', 'bg' => 'bg-blue-100', 'border' => 'border-[#1b3985]'];
                        }
                    @endphp

                    <div class="group relative flex gap-4 p-5 sm:p-6 transition-colors hover:bg-slate-50 border-b border-slate-100 last:border-0 {{ $isUnread ? 'bg-blue-50/30' : '' }}">
                        
                        {{-- Unread Indicator Strip --}}
                        @if($isUnread)
                            <div class="absolute left-0 top-0 bottom-0 w-1 {{ $theme['border'] }}"></div>
                        @endif

                        {{-- Icon --}}
                        <div class="flex-shrink-0 mt-1">
                            <span class="inline-flex items-center justify-center h-10 w-10 rounded-full {{ $theme['bg'] }}">
                                <x-dynamic-component :component="$theme['icon']" class="h-6 w-6 {{ $theme['color'] }}" />
                            </span>
                        </div>

                        {{-- Main Content --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-x-2">
                                <div class="space-y-1">
                                    <p class="text-sm font-semibold text-slate-900 flex items-center gap-2">
                                        {{ $title }}
                                        @if($isUnread)
                                            <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">Baru</span>
                                        @endif
                                    </p>
                                    @if(isset($data['judul_kegiatan']))
                                        <p class="text-sm font-medium text-slate-700">{{ $data['judul_kegiatan'] }}</p>
                                    @endif
                                </div>
                                <time datetime="{{ $n->created_at }}" class="flex-shrink-0 whitespace-nowrap text-xs text-slate-500">
                                    {{ $n->created_at->diffForHumans() }}
                                </time>
                            </div>

                            <div class="mt-2 text-sm text-slate-600 leading-relaxed">
                                {{ $data['message'] ?? '' }}
                            </div>

                            {{-- Rejection/Revision Reason Box --}}
                            @if (!empty($data['reason']))
                                <div class="mt-3 rounded-lg bg-slate-50 p-3 ring-1 ring-inset ring-slate-200">
                                    <div class="flex gap-2">
                                        <x-heroicon-m-chat-bubble-left-right class="h-5 w-5 text-slate-400 flex-shrink-0" />
                                        <div class="text-xs sm:text-sm text-slate-700">
                                            <span class="font-bold text-slate-900">Catatan:</span> {{ $data['reason'] }}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- Actions --}}
                            <div class="mt-3 flex items-center gap-4 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                @if($isUnread)
                                    <form method="POST" action="{{ route('student.notifications.read', $n->id) }}">
                                        @csrf
                                        <button type="submit" class="text-xs font-medium text-[#1b3985] hover:text-blue-800 flex items-center gap-1">
                                            <x-heroicon-s-check class="w-3 h-3" /> Tandai dibaca
                                        </button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('student.notifications.destroy', $n->id) }}" onsubmit="return confirm('Hapus notifikasi ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-medium text-slate-400 hover:text-rose-600 flex items-center gap-1">
                                        <x-heroicon-s-trash class="w-3 h-3" /> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- Empty State --}}
                    <div class="flex flex-col items-center justify-center py-16 px-6 text-center">
                        <div class="rounded-full bg-slate-50 p-4 mb-4 ring-1 ring-slate-100">
                            <x-heroicon-o-bell-slash class="h-8 w-8 text-slate-400" />
                        </div>
                        <h3 class="text-base font-semibold text-slate-900">Tidak ada notifikasi</h3>
                        <p class="mt-1 text-sm text-slate-500 max-w-sm">
                            Anda sudah melihat semua pembaruan. Notifikasi baru tentang status portofolio atau SKPI akan muncul di sini.
                        </p>
                    </div>
                @endforelse
            </div>

            @if ($notifications->hasPages())
                <div class="mt-6">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
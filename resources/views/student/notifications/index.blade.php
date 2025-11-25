<x-app-layout>
    <div class="min-h-screen bg-gray-50 font-sans">
        
        {{-- HEADER SECTION --}}
        <div class="sticky top-0 z-30 bg-white/80 backdrop-blur-md border-b border-gray-200 shadow-sm transition-all duration-300">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="py-4 md:py-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 tracking-tight flex items-center gap-2">
                            <x-heroicon-o-bell class="w-7 h-7 text-indigo-600"/>
                            Notifikasi
                        </h1>
                        <p class="text-sm text-gray-500 mt-1 ml-9">
                            Pusat informasi dan status pengajuan akademik Anda.
                        </p>
                    </div>

                    @if ($notifications->count() > 0)
                        <div class="flex flex-col sm:flex-row gap-3 ml-9 md:ml-0">
                            <form method="POST" action="{{ route('student.notifications.read_all') }}">
                                @csrf
                                <button type="submit" 
                                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-indigo-600 hover:border-indigo-200 transition-all focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1 shadow-sm">
                                    <x-heroicon-o-check-circle class="w-4 h-4" />
                                    <span>Tandai Semua Dibaca</span>
                                </button>
                            </form>
                            
                            <form method="POST" action="{{ route('student.notifications.delete_all') }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus semua notifikasi?')">
                                @csrf
                                <button type="submit" 
                                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2 bg-white border border-red-200 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 hover:border-red-300 transition-all focus:ring-2 focus:ring-red-500 focus:ring-offset-1 shadow-sm">
                                    <x-heroicon-o-trash class="w-4 h-4" />
                                    <span>Bersihkan</span>
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- CONTENT SECTION --}}
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden ring-1 ring-black/5">
                <div class="divide-y divide-gray-100">
                    @forelse($notifications as $n)
                        @php
                            $data = $n->data;
                            $titleLower = strtolower($data['title'] ?? '');
                            $isUnread = is_null($n->read_at);

                            // Logic Styling
                            if (Str::contains($titleLower, ['ditolak', 'gagal', 'rejected'])) {
                                $style = [
                                    'icon' => 'heroicon-o-x-circle',
                                    'bg_icon' => 'bg-rose-100',
                                    'text_icon' => 'text-rose-600',
                                    'border' => 'border-l-rose-500',
                                    'bg_hover' => 'hover:bg-rose-50/50'
                                ];
                            } elseif (Str::contains($titleLower, ['perbaikan', 'revisi', 'revision'])) {
                                $style = [
                                    'icon' => 'heroicon-o-pencil-square',
                                    'bg_icon' => 'bg-amber-100',
                                    'text_icon' => 'text-amber-600',
                                    'border' => 'border-l-amber-500',
                                    'bg_hover' => 'hover:bg-amber-50/50'
                                ];
                            } elseif (Str::contains($titleLower, ['diterima', 'disetujui', 'verified', 'selesai'])) {
                                $style = [
                                    'icon' => 'heroicon-o-check-badge',
                                    'bg_icon' => 'bg-emerald-100',
                                    'text_icon' => 'text-emerald-600',
                                    'border' => 'border-l-emerald-500',
                                    'bg_hover' => 'hover:bg-emerald-50/50'
                                ];
                            } else {
                                $style = [
                                    'icon' => 'heroicon-o-information-circle',
                                    'bg_icon' => 'bg-indigo-100',
                                    'text_icon' => 'text-indigo-600',
                                    'border' => 'border-l-indigo-500',
                                    'bg_hover' => 'hover:bg-gray-50'
                                ];
                            }
                        @endphp

                        <div class="relative group p-5 sm:p-6 transition-all duration-200 {{ $style['bg_hover'] }} {{ $isUnread ? 'bg-indigo-50/40' : 'bg-white' }}">
                            
                            {{-- Unread Indicator Strip --}}
                            @if($isUnread)
                                <div class="absolute left-0 top-0 bottom-0 w-1 {{ $style['border'] }}"></div>
                            @endif

                            <div class="flex gap-4 sm:gap-6 items-start">
                                {{-- Icon Box --}}
                                <div class="flex-shrink-0 mt-1">
                                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl flex items-center justify-center {{ $style['bg_icon'] }} {{ $style['text_icon'] }} shadow-sm">
                                        <x-dynamic-component :component="$style['icon']" class="w-5 h-5 sm:w-6 sm:h-6" />
                                    </div>
                                </div>

                                {{-- Main Content --}}
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-1 mb-1">
                                        <div class="flex items-center gap-2">
                                            <h3 class="text-base font-semibold text-gray-900 leading-snug">
                                                {{ $data['title'] ?? 'Pemberitahuan Sistem' }}
                                            </h3>
                                            @if($isUnread)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide bg-blue-100 text-blue-700">
                                                    Baru
                                                </span>
                                            @endif
                                        </div>
                                        <span class="text-xs text-gray-400 whitespace-nowrap flex-shrink-0 flex items-center gap-1">
                                            <x-heroicon-o-clock class="w-3 h-3" />
                                            {{ optional($n->created_at)->diffForHumans() }}
                                        </span>
                                    </div>

                                    @if (!empty($data['judul_kegiatan']))
                                        <p class="text-sm font-medium text-gray-800 mb-1">
                                            {{ $data['judul_kegiatan'] }}
                                        </p>
                                    @endif

                                    @if (!empty($data['message']))
                                        <p class="text-sm text-gray-600 leading-relaxed">
                                            {{ $data['message'] }}
                                        </p>
                                    @endif

                                    {{-- Reason Box (Conditional) --}}
                                    @if (!empty($data['reason']))
                                        <div class="mt-3 bg-red-50 border border-red-100 rounded-lg p-3 sm:p-4">
                                            <div class="flex gap-2">
                                                <x-heroicon-s-exclamation-circle class="w-5 h-5 text-red-500 flex-shrink-0" />
                                                <div>
                                                    <p class="text-xs font-bold text-red-800 uppercase tracking-wide mb-1">Catatan / Alasan:</p>
                                                    <p class="text-sm text-red-700 leading-relaxed">{{ $data['reason'] }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Actions --}}
                                    <div class="mt-3 flex items-center justify-end sm:justify-start gap-4 opacity-100 sm:opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        @if ($isUnread)
                                            <form method="POST" action="{{ route('student.notifications.read', $n->id) }}">
                                                @csrf
                                                <button type="submit" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 hover:underline flex items-center gap-1 transition-colors">
                                                    <x-heroicon-s-eye class="w-3 h-3" />
                                                    Tandai dibaca
                                                </button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('student.notifications.unread', $n->id) }}">
                                                @csrf
                                                <button type="submit" class="text-xs font-medium text-gray-400 hover:text-gray-600 hover:underline flex items-center gap-1 transition-colors">
                                                    <x-heroicon-s-eye-slash class="w-3 h-3" />
                                                    Tandai belum dibaca
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        {{-- Empty State --}}
                        <div class="flex flex-col items-center justify-center py-20 px-4 text-center">
                            <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mb-6 shadow-inner">
                                <x-heroicon-o-bell-slash class="w-12 h-12 text-gray-300" />
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">Semua Bersih!</h3>
                            <p class="text-gray-500 max-w-sm mt-2 text-sm leading-relaxed">
                                Tidak ada notifikasi baru saat ini. Silakan periksa kembali nanti untuk pembaruan status akademik Anda.
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Pagination --}}
            @if ($notifications->hasPages())
                <div class="mt-8">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
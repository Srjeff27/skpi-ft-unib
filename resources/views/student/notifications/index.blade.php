<x-app-layout>
    <div class="min-h-screen bg-gradient-to-b from-slate-50 via-white to-slate-50">
        <div class="sticky top-0 z-30 bg-white/70 backdrop-blur-md border-b border-slate-200 shadow-sm">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-10">
                <div class="flex flex-col gap-4 py-4 md:flex-row md:items-center md:justify-between">
                    <div class="flex flex-col gap-1">
                        <div class="inline-flex items-center gap-2">
                            <span class="inline-flex items-center justify-center rounded-xl bg-blue-50 text-blue-600 w-10 h-10">
                                <x-heroicon-o-bell class="w-6 h-6" />
                            </span>
                            <div>
                                <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Pusat Informasi</p>
                                <h1 class="text-2xl font-bold text-slate-900 leading-tight">Notifikasi</h1>
                            </div>
                        </div>
                        <p class="text-sm text-slate-500 md:ml-12">Pantau pembaruan status dan informasi akademik Anda.</p>
                    </div>

                    @if ($notifications->count() > 0)
                        <div class="flex flex-col gap-3 sm:flex-row">
                            <form method="POST" action="{{ route('student.notifications.read_all') }}" class="w-full sm:w-auto">
                                @csrf
                                <button type="submit"
                                    class="w-full inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:-translate-y-0.5 hover:border-blue-200 hover:text-blue-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500/70 focus:ring-offset-2">
                                    <x-heroicon-o-check-circle class="w-5 h-5" />
                                    Tandai Semua Dibaca
                                </button>
                            </form>

                            <form method="POST" action="{{ route('student.notifications.delete_all') }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus semua notifikasi?')" class="w-full sm:w-auto">
                                @csrf
                                <button type="submit"
                                    class="w-full inline-flex items-center justify-center gap-2 rounded-xl border border-rose-200 bg-rose-50 px-4 py-2.5 text-sm font-semibold text-rose-700 shadow-sm transition hover:-translate-y-0.5 hover:border-rose-300 hover:bg-rose-100 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-rose-500/70 focus:ring-offset-2">
                                    <x-heroicon-o-trash class="w-5 h-5" />
                                    Bersihkan
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-10 py-8">
            <div class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white/90 shadow-xl shadow-slate-100 ring-1 ring-slate-100">
                <div class="divide-y divide-slate-100">
                    @forelse($notifications as $n)
                        @php
                            $data = $n->data;
                            $titleLower = strtolower($data['title'] ?? '');
                            $isUnread = is_null($n->read_at);

                            if (Str::contains($titleLower, ['ditolak', 'gagal', 'rejected'])) {
                                $style = [
                                    'icon' => 'heroicon-o-x-circle',
                                    'bg_icon' => 'bg-rose-50',
                                    'text_icon' => 'text-rose-600',
                                    'border' => 'border-l-rose-500',
                                    'bg_hover' => 'hover:bg-rose-50/70'
                                ];
                            } elseif (Str::contains($titleLower, ['perbaikan', 'revisi', 'revision'])) {
                                $style = [
                                    'icon' => 'heroicon-o-pencil-square',
                                    'bg_icon' => 'bg-amber-50',
                                    'text_icon' => 'text-amber-600',
                                    'border' => 'border-l-amber-500',
                                    'bg_hover' => 'hover:bg-amber-50/70'
                                ];
                            } elseif (Str::contains($titleLower, ['diterima', 'disetujui', 'verified', 'selesai'])) {
                                $style = [
                                    'icon' => 'heroicon-o-check-badge',
                                    'bg_icon' => 'bg-emerald-50',
                                    'text_icon' => 'text-emerald-600',
                                    'border' => 'border-l-emerald-500',
                                    'bg_hover' => 'hover:bg-emerald-50/70'
                                ];
                            } else {
                                $style = [
                                    'icon' => 'heroicon-o-information-circle',
                                    'bg_icon' => 'bg-blue-50',
                                    'text_icon' => 'text-blue-600',
                                    'border' => 'border-l-blue-500',
                                    'bg_hover' => 'hover:bg-blue-50/60'
                                ];
                            }
                        @endphp

                        <div class="relative group p-5 sm:p-6 transition-all duration-200 {{ $style['bg_hover'] }} {{ $isUnread ? 'bg-gradient-to-r from-blue-50/70 via-white to-white' : 'bg-white' }}">
                            @if($isUnread)
                                <div class="absolute left-0 top-0 bottom-0 w-1 {{ $style['border'] }}"></div>
                            @endif

                            <div class="flex items-start gap-4 sm:gap-6">
                                <div class="flex-shrink-0 mt-1">
                                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center {{ $style['bg_icon'] }} {{ $style['text_icon'] }} shadow-sm ring-1 ring-inset ring-white">
                                        <x-dynamic-component :component="$style['icon']" class="w-6 h-6" />
                                    </div>
                                </div>

                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-col gap-1 sm:flex-row sm:items-start sm:justify-between">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <h3 class="text-base sm:text-lg font-semibold text-slate-900 leading-snug">
                                                {{ $data['title'] ?? 'Pemberitahuan Sistem' }}
                                            </h3>
                                            @if($isUnread)
                                                <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-1 text-[11px] font-semibold uppercase tracking-wide text-blue-700">
                                                    Baru
                                                </span>
                                            @endif
                                        </div>
                                        <span class="flex items-center gap-1 text-xs text-slate-400 whitespace-nowrap sm:text-sm">
                                            <x-heroicon-o-clock class="w-4 h-4" />
                                            {{ optional($n->created_at)->diffForHumans() }}
                                        </span>
                                    </div>

                                    @if (!empty($data['judul_kegiatan']))
                                        <p class="mt-1 text-sm font-semibold text-slate-800">
                                            {{ $data['judul_kegiatan'] }}
                                        </p>
                                    @endif

                                    @if (!empty($data['message']))
                                        <p class="mt-1 text-sm text-slate-600 leading-relaxed">
                                            {{ $data['message'] }}
                                        </p>
                                    @endif

                                    @if (!empty($data['reason']))
                                        <div class="mt-3 rounded-xl border border-rose-100 bg-rose-50/60 p-3 sm:p-4">
                                            <div class="flex gap-3">
                                                <x-heroicon-s-exclamation-circle class="w-5 h-5 text-rose-500 flex-shrink-0" />
                                                <div class="text-sm text-rose-700 leading-relaxed">
                                                    <p class="text-xs font-semibold uppercase tracking-wide text-rose-600 mb-1">Catatan / Alasan</p>
                                                    <p>{{ $data['reason'] }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="mt-4 flex flex-wrap items-center gap-3 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity">
                                        @if ($isUnread)
                                            <form method="POST" action="{{ route('student.notifications.read', $n->id) }}">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center gap-1 text-xs font-semibold text-blue-600 hover:text-blue-800 transition">
                                                    <x-heroicon-s-eye class="w-4 h-4" />
                                                    Tandai dibaca
                                                </button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('student.notifications.unread', $n->id) }}">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center gap-1 text-xs font-semibold text-slate-400 hover:text-slate-600 transition">
                                                    <x-heroicon-s-eye-slash class="w-4 h-4" />
                                                    Tandai belum dibaca
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-16 px-4 text-center bg-gradient-to-b from-slate-50 to-white">
                            <div class="relative mb-6">
                                <div class="w-28 h-28 rounded-full bg-white shadow-inner shadow-slate-100 border border-slate-100 flex items-center justify-center">
                                    <x-heroicon-o-bell-slash class="w-12 h-12 text-slate-300" />
                                </div>
                                <div class="absolute -inset-2 rounded-full bg-blue-50/40 blur-xl"></div>
                            </div>
                            <h3 class="text-lg sm:text-xl font-bold text-slate-900">Semua Bersih!</h3>
                            <p class="mt-2 max-w-xl text-sm text-slate-500 leading-relaxed">
                                Tidak ada notifikasi baru saat ini. Silakan periksa kembali nanti untuk pembaruan status akademik Anda.
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>

            @if ($notifications->hasPages())
                <div class="mt-8">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

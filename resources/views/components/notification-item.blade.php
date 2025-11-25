@props(['notification'])

@switch($notification->type)
    @case('App\Notifications\PortfolioStatusNotification')
        @php
            $notificationData = $notification->data;
            $portfolio = \App\Models\Portfolio::find($notificationData['portfolio_id'] ?? null);

            $statusConfig = [
                'verified' => [
                    'icon' => 'heroicon-s-check-circle',
                    'color' => 'text-emerald-500',
                    'bg' => 'bg-emerald-50',
                    'label' => 'disetujui',
                ],
                'rejected' => [
                    'icon' => 'heroicon-s-x-circle',
                    'color' => 'text-rose-500',
                    'bg' => 'bg-rose-50',
                    'label' => 'ditolak',
                ],
                'requires_revision' => [
                    'icon' => 'heroicon-s-exclamation-circle',
                    'color' => 'text-amber-500',
                    'bg' => 'bg-amber-50',
                    'label' => 'memerlukan perbaikan',
                ],
                'default' => [
                    'icon' => 'heroicon-s-information-circle',
                    'color' => 'text-gray-500',
                    'bg' => 'bg-gray-50',
                    'label' => 'diperbarui',
                ],
            ];
            $config = $statusConfig[$notificationData['status']] ?? $statusConfig['default'];
            $statusLabel = $config['label'];
            $href = $portfolio ? route('student.portfolios.edit', $portfolio->id) : '#';
        @endphp
        <a href="{{ $href }}" class="block p-3.5 transition-colors hover:bg-gray-50/50">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center {{ $config['bg'] }}">
                    <x-dynamic-component :component="$config['icon']" class="w-6 h-6 {{ $config['color'] }}" />
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-800 leading-snug">{{ $notificationData['title'] }}</p>
                    @if ($portfolio)
                        <p class="text-sm text-gray-500 mt-1 leading-snug">
                            Portofolio "{{ Str::limit($portfolio->nama_dokumen_id, 30) }}" telah {{ $statusLabel }}.
                        </p>
                    @else
                        <p class="text-sm text-gray-500 mt-1 leading-snug">Portofolio terkait telah dihapus.</p>
                    @endif
                    <p class="text-xs text-gray-400 mt-2">
                        {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                    </p>
                </div>
                @if (!$notification->read_at)
                    <div class="w-2.5 h-2.5 rounded-full bg-[#1b3985] mt-1 flex-shrink-0"></div>
                @endif
            </div>
        </a>
    @break

    @case('App\Notifications\AnnouncementNotification')
        @php
            $notificationData = $notification->data;
        @endphp
        <a href="{{ route('student.announcements.index') }}" class="block p-3.5 transition-colors hover:bg-gray-50/50">
            <div class="flex items-start gap-3">
                <div
                    class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center bg-blue-50 text-blue-500">
                    <x-heroicon-s-megaphone class="w-6 h-6" />
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-800 leading-snug">{{ $notificationData['title'] }}</p>
                    <p class="text-sm text-gray-500 mt-1 leading-snug">
                        {{ Str::limit($notificationData['message'], 60) }}</p>
                    <p class="text-xs text-gray-400 mt-2">
                        {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                    </p>
                </div>
                @if (!$notification->read_at)
                    <div class="w-2.5 h-2.5 rounded-full bg-[#1b3985] mt-1 flex-shrink-0"></div>
                @endif
            </div>
        </a>
    @break

    @default
        <div class="p-3.5">
            <p class="text-sm text-gray-600">Notifikasi tidak dikenal.</p>
        </div>
@endswitch

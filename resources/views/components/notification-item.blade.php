@props(['notification'])

@php
    $notificationData = $notification->data;
    $portfolio = \App\Models\Portfolio::find($notificationData['portfolio_id']);
    
    $statusConfig = [
        'verified' => [
            'icon' => 'heroicon-s-check-circle',
            'color' => 'text-emerald-500',
            'bg' => 'bg-emerald-50',
        ],
        'rejected' => [
            'icon' => 'heroicon-s-x-circle',
            'color' => 'text-rose-500',
            'bg' => 'bg-rose-50',
        ],
        'requires_revision' => [
            'icon' => 'heroicon-s-exclamation-circle',
            'color' => 'text-amber-500',
            'bg' => 'bg-amber-50',
        ],
        'default' => [
            'icon' => 'heroicon-s-information-circle',
            'color' => 'text-gray-500',
            'bg' => 'bg-gray-50',
        ],
    ];
    
    $config = $statusConfig[$notificationData['status']] ?? $statusConfig['default'];
@endphp

<a href="{{ route('student.portfolios.edit', $notificationData['portfolio_id']) }}"
    class="block p-3.5 transition-colors hover:bg-gray-50/50">
    <div class="flex items-start gap-3">
        {{-- Icon --}}
        <div
            class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center {{ $config['bg'] }}">
            <x-dynamic-component :component="$config['icon']" class="w-6 h-6 {{ $config['color'] }}" />
        </div>

        {{-- Content --}}
        <div class="flex-1 min-w-0">
            <p class="text-sm font-semibold text-gray-800 leading-snug">
                {{ $notificationData['title'] }}
            </p>
            <p class="text-sm text-gray-500 mt-1 leading-snug">
                Portofolio "{{ Str::limit($portfolio->nama_dokumen_id, 30) }}" telah
                {{ $notificationData['status_label'] }}.
            </p>
            <p class="text-xs text-gray-400 mt-2">
                {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
            </p>
        </div>

        {{-- Unread Indicator --}}
        @if (!$notification->read_at)
            <div class="w-2.5 h-2.5 rounded-full bg-blue-500 mt-1 flex-shrink-0"></div>
        @endif
    </div>
</a>

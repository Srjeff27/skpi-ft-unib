@props([
    'type' => 'info', // success|error|info|warning
    'title' => null,
    'message' => '',
    'okText' => 'Ok',
    'duration' => 3500,
    'autoClose' => true,
])

@php
    $theme = match($type) {
        'success' => [
            'ring' => 'border-green-500 text-green-600',
            'title' => 'text-green-700',
            'button' => 'bg-green-600 hover:bg-green-700 focus:ring-green-500',
        ],
        'error' => [
            'ring' => 'border-red-500 text-red-600',
            'title' => 'text-red-700',
            'button' => 'bg-red-600 hover:bg-red-700 focus:ring-red-500',
        ],
        'warning' => [
            'ring' => 'border-amber-500 text-amber-600',
            'title' => 'text-amber-700',
            'button' => 'bg-amber-600 hover:bg-amber-700 focus:ring-amber-500',
        ],
        default => [
            'ring' => 'border-blue-500 text-blue-600',
            'title' => 'text-blue-700',
            'button' => 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500',
        ],
    };

    $computedTitle = $title ?? match($type) {
        'success' => 'Berhasil!',
        'error' => 'Gagal!',
        'warning' => 'Perhatian',
        default => 'Informasi',
    };
@endphp

<div x-data="{ show: true }"
     x-init="{{ $autoClose ? "setTimeout(() => show = false, $duration)" : '' }}"
     x-show="show"
     x-transition.opacity
     class="fixed inset-0 z-50 flex items-center justify-center p-4">
    <!-- Overlay -->
    <div class="absolute inset-0 bg-gray-800/70" @click="show = false"></div>

    <!-- Card -->
    <div x-show="show" x-transition
         class="relative bg-white rounded-2xl shadow-xl w-full max-w-sm text-center p-6 sm:p-8">
        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-white border-2 {{ $theme['ring'] }}">
            @if($type === 'success')
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-9 h-9">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
            @elseif($type === 'error')
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-9 h-9">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            @else
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-9 h-9">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01" />
                </svg>
            @endif
        </div>

        <h3 class="mt-5 text-xl font-extrabold {{ $theme['title'] }}">{{ $computedTitle }}</h3>
        @if($message)
            <p class="mt-2 text-gray-600 leading-relaxed">{{ $message }}</p>
        @endif

        <div class="mt-6">
            <button @click="show = false"
                    class="inline-flex items-center justify-center rounded-md px-4 py-2 text-white font-semibold shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 {{ $theme['button'] }}">
                {{ $okText }}
            </button>
        </div>
    </div>
</div>

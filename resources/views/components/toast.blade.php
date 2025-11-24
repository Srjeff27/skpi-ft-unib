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
            'title' => 'text-green-800',
            'button' => 'bg-green-600 hover:bg-green-700 focus:ring-green-500',
            'gradient' => 'from-emerald-500 to-green-600',
        ],
        'error' => [
            'ring' => 'border-red-500 text-red-600',
            'title' => 'text-red-800',
            'button' => 'bg-red-600 hover:bg-red-700 focus:ring-red-500',
            'gradient' => 'from-rose-500 to-red-600',
        ],
        'warning' => [
            'ring' => 'border-amber-500 text-amber-600',
            'title' => 'text-amber-800',
            'button' => 'bg-amber-600 hover:bg-amber-700 focus:ring-amber-500',
            'gradient' => 'from-amber-400 to-orange-500',
        ],
        default => [
            'ring' => 'border-blue-500 text-blue-600',
            'title' => 'text-blue-800',
            'button' => 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500',
            'gradient' => 'from-sky-500 to-blue-600',
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
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="show = false"></div>

    <div x-show="show" x-transition
         class="relative w-full max-w-md overflow-hidden rounded-2xl bg-white shadow-2xl ring-1 ring-black/5">
        <div class="absolute inset-x-0 top-0 h-1.5 bg-gradient-to-r {{ $theme['gradient'] }}"></div>

        <div class="flex items-start gap-4 p-6 sm:p-7">
            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-slate-50 {{ $theme['ring'] }} shadow-inner">
                @if($type === 'success')
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                @elseif($type === 'error')
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                @elseif($type === 'warning')
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L2.34 18c-.77 1.333.192 3 1.732 3z" /></svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M4.929 4.929a10 10 0 1114.142 14.142A10 10 0 014.929 4.93z" /></svg>
                @endif
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-bold {{ $theme['title'] }}">{{ $computedTitle }}</h3>
                @if($message)
                    <p class="mt-1.5 text-sm leading-relaxed text-slate-600">{{ $message }}</p>
                @endif
                <div class="mt-4 flex flex-wrap gap-2">
                    <button @click="show = false"
                            class="inline-flex items-center justify-center rounded-lg px-4 py-2 text-sm font-semibold text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 {{ $theme['button'] }}">
                        {{ $okText }}
                    </button>
                    <button @click="show = false"
                            class="inline-flex items-center justify-center rounded-lg px-3 py-2 text-sm font-semibold text-slate-500 hover:text-slate-700">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

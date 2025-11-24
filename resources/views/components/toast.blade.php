@props([
    'type' => 'info',
    'title' => null,
    'message' => '',
    'okText' => 'Mengerti',
    'duration' => 4000,
    'autoClose' => true,
])

@php
    $config = match($type) {
        'success' => [
            'icon' => 'heroicon-o-check-circle',
            'text' => 'text-emerald-700',
            'bg_icon' => 'bg-emerald-50',
            'border' => 'border-emerald-500',
            'btn' => 'bg-emerald-600 hover:bg-emerald-700 focus:ring-emerald-500',
        ],
        'error' => [
            'icon' => 'heroicon-o-x-circle',
            'text' => 'text-rose-700',
            'bg_icon' => 'bg-rose-50',
            'border' => 'border-rose-500',
            'btn' => 'bg-rose-600 hover:bg-rose-700 focus:ring-rose-500',
        ],
        'warning' => [
            'icon' => 'heroicon-o-exclamation-triangle',
            'text' => 'text-amber-700',
            'bg_icon' => 'bg-amber-50',
            'border' => 'border-amber-500',
            'btn' => 'bg-amber-600 hover:bg-amber-700 focus:ring-amber-500',
        ],
        default => [
            'icon' => 'heroicon-o-information-circle',
            'text' => 'text-blue-700',
            'bg_icon' => 'bg-blue-50',
            'border' => 'border-blue-500',
            'btn' => 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500',
        ],
    };

    $finalTitle = $title ?? match($type) {
        'success' => 'Operasi Berhasil',
        'error' => 'Terjadi Kesalahan',
        'warning' => 'Peringatan Sistem',
        default => 'Informasi',
    };
@endphp

<div x-data="{ show: true }"
     x-init="{{ $autoClose ? "setTimeout(() => show = false, $duration)" : '' }}"
     x-show="show"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
     class="fixed inset-0 z-50 flex items-end justify-center px-4 py-6 sm:items-center sm:p-0"
     style="display: none;">

    <div class="fixed inset-0 transition-opacity bg-gray-900/40 backdrop-blur-[2px]" @click="show = false"></div>

    <div class="relative w-full max-w-md overflow-hidden bg-white shadow-xl rounded-[5px] ring-1 ring-black/5 border-l-[6px] {{ $config['border'] }}">
        
        <div class="p-5 sm:p-6 flex items-start gap-4">
            <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-[5px] {{ $config['bg_icon'] }} {{ $config['text'] }}">
                <x-dynamic-component :component="$config['icon']" class="w-6 h-6" />
            </div>

            <div class="flex-1 w-0 pt-0.5">
                <h3 class="text-base font-bold text-gray-900 leading-none mb-1">
                    {{ $finalTitle }}
                </h3>
                @if($message)
                    <p class="text-sm text-gray-600 leading-relaxed">
                        {{ $message }}
                    </p>
                @endif
            </div>

            <button @click="show = false" class="flex-shrink-0 text-gray-400 hover:text-gray-600 transition-colors focus:outline-none">
                <x-heroicon-m-x-mark class="w-5 h-5" />
            </button>
        </div>

        <div class="bg-gray-50 px-5 py-3 flex flex-row-reverse gap-2">
            <button @click="show = false"
                    class="inline-flex w-full sm:w-auto justify-center items-center px-4 py-2 text-sm font-semibold text-white shadow-sm rounded-[5px] focus:outline-none focus:ring-2 focus:ring-offset-1 transition-colors {{ $config['btn'] }}">
                {{ $okText }}
            </button>
            <button @click="show = false"
                    class="inline-flex w-full sm:w-auto justify-center items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-[5px] shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-indigo-500 transition-colors">
                Tutup
            </button>
        </div>
    </div>
</div>
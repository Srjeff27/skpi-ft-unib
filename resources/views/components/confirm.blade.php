@props([
    'action',
    'method' => 'POST',
    'type' => 'error', // success|error|warning|info
    'title' => 'Konfirmasi',
    'message' => 'Apakah Anda yakin?',
    'confirmText' => 'Ok',
    'cancelText' => 'Batal',
])

@php
    $theme = match($type) {
        'success' => [
            'ring' => 'border-green-500 text-green-600',
            'title' => 'text-green-700',
            'button' => 'bg-green-600 hover:bg-green-700 focus:ring-green-500',
        ],
        'warning' => [
            'ring' => 'border-amber-500 text-amber-600',
            'title' => 'text-amber-700',
            'button' => 'bg-amber-600 hover:bg-amber-700 focus:ring-amber-500',
        ],
        'info' => [
            'ring' => 'border-blue-500 text-blue-600',
            'title' => 'text-blue-700',
            'button' => 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500',
        ],
        default => [
            'ring' => 'border-red-500 text-red-600',
            'title' => 'text-red-700',
            'button' => 'bg-red-600 hover:bg-red-700 focus:ring-red-500',
        ],
    };
@endphp

<div x-data="{ show: false }" class="inline">
    <div x-on:click="show = true">
        {{ $trigger ?? 'Buka' }}
    </div>

    <div x-show="show" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-gray-800/70" @click="show = false"></div>
        <div x-show="show" x-transition class="relative bg-white rounded-2xl shadow-xl w-full max-w-sm text-center p-6 sm:p-8">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-white border-2 {{ $theme['ring'] }}">
                @if($type === 'success')
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-9 h-9">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                @elseif($type === 'info')
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-9 h-9">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01" />
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-9 h-9">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                @endif
            </div>

            <h3 class="mt-5 text-xl font-extrabold {{ $theme['title'] }}">{{ $title }}</h3>
            <p class="mt-2 text-gray-600 leading-relaxed">{{ $message }}</p>

            <div class="mt-6 flex items-center justify-center gap-3">
                <button type="button" @click="show = false"
                        class="inline-flex items-center justify-center rounded-md px-4 py-2 text-gray-700 font-semibold bg-gray-100 hover:bg-gray-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400">
                    {{ $cancelText }}
                </button>

                <button type="button"
                        @click="
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = '{{ $action }}';
                            form.style.display = 'none';
                            const token = document.querySelector('meta[name=\'csrf-token\']')?.getAttribute('content');
                            if (token) {
                                const i = document.createElement('input');
                                i.type = 'hidden'; i.name = '_token'; i.value = token; form.appendChild(i);
                            }
                            const method = '{{ strtoupper($method) }}';
                            if (method !== 'POST') {
                                const m = document.createElement('input');
                                m.type = 'hidden'; m.name = '_method'; m.value = method; form.appendChild(m);
                            }
                            document.body.appendChild(form);
                            form.submit();
                        "
                        class="inline-flex items-center justify-center rounded-md px-4 py-2 text-white font-semibold shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 {{ $theme['button'] }}">
                    {{ $confirmText }}
                </button>
            </div>
        </div>
    </div>
</div>

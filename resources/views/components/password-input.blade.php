@props([
    'name',
    'id',
    'label',
    'messages' => [],
])

{{-- Komponen ini mengisolasi state show/hide untuk setiap input --}}
<div x-data="{ show: false }">
    <x-input-label :for="$id" :value="$label" />

    <div class="relative mt-1">
        <x-text-input
            :id="$id"
            :name="$name"
            ::type="show ? 'text' : 'password'"
            {{ $attributes->merge(['class' => 'pr-10']) }}
        />

        {{-- Tombol untuk toggle show/hide password --}}
        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
            <template x-if="!show">
                <x-heroicon-o-eye class="h-5 w-5" />
            </template>
            <template x-if="show">
                <x-heroicon-o-eye-slash class="h-5 w-5" />
            </template>
        </button>
    </div>

    <x-input-error :messages="$messages" class="mt-2" />
</div>

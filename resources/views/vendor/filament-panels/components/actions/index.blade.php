@php
    // Wrap default actions then append a secondary link to home
@endphp

<div {{ $attributes->class(['fi-actions']) }}>
    {{ $slot }}

    <a href="/" class="mt-3 inline-flex w-full items-center justify-center rounded-md border border-[#1b3985] px-4 py-2 text-[#1b3985] hover:bg-blue-50">
        Kembali ke Beranda
    </a>
</div>


@php
    use Filament\Support\Enums\Width;

    $livewire ??= null;

    $renderHookScopes = $livewire?->getRenderHookScopes();
    $maxContentWidth ??= (filament()->getSimplePageMaxContentWidth() ?? Width::Large);

    if (is_string($maxContentWidth)) {
        $maxContentWidth = Width::tryFrom($maxContentWidth) ?? $maxContentWidth;
    }
@endphp

@push('styles')
    <style>
        /* Minimal, clean login look aligned with mahasiswa */
        .fi-simple-layout { min-height: 100vh; background: #1b3985; }
        .fi-simple-main-ctn { display: flex; align-items: center; justify-content: center; padding: 1rem; }
        .fi-simple-main { width: 100%; max-width: 28rem; }
        .fi-simple-page-content { background: #ffffff; border: none; border-radius: 1rem; padding: 1.25rem; box-shadow: none; }
        .fi-simple-header { text-align: center; margin-top: .25rem; }
        .fi-simple-header .fi-logo { display:inline-flex; align-items:center; justify-content:center; border-radius:9999px; background:#fa7516; padding:.5rem; height:4rem !important; width:4rem !important; margin:0 auto; }
        .fi-simple-header-heading { margin-top: .75rem; font-weight: 600; color: #0f172a; font-size: 1.25rem; }
        .fi-simple-header-subheading { color: #4b5563; font-size: .875rem; }
        .fi-simple-page-content .fi-fo-field-label-content { color: #1b3985; }
    </style>
@endpush

<x-filament-panels::layout.base :livewire="$livewire">
    @props([
        'after' => null,
        'heading' => null,
        'subheading' => null,
    ])

    <div class="fi-simple-layout">
        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::SIMPLE_LAYOUT_START, scopes: $renderHookScopes) }}

        @if (($hasTopbar ?? true) && filament()->auth()->check())
            <div class="fi-simple-layout-header">
                @if (filament()->hasDatabaseNotifications())
                    @livewire(Filament\Livewire\DatabaseNotifications::class, [
                        'lazy' => filament()->hasLazyLoadedDatabaseNotifications(),
                    ])
                @endif

                @if (filament()->hasUserMenu())
                    @livewire(Filament\Livewire\SimpleUserMenu::class)
                @endif
            </div>
        @endif

        <div class="fi-simple-main-ctn">
            <main
                @class([
                    'fi-simple-main',
                    ($maxContentWidth instanceof Width) ? "fi-width-{$maxContentWidth->value}" : $maxContentWidth,
                ])
            >
                <div class="fi-simple-page-content">
                    {{ $slot }}
                </div>
            </main>
        </div>

        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::FOOTER, scopes: $renderHookScopes) }}

        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::SIMPLE_LAYOUT_END, scopes: $renderHookScopes) }}
    </div>
</x-filament-panels::layout.base>

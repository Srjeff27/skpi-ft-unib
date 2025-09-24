<?php

namespace App\Filament\Auth;

use Filament\Auth\Pages\Login as BaseLogin;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Html;

class VerifikatorLogin extends BaseLogin
{
    public function getTitle(): string | Htmlable
    {
        return new HtmlString('Masuk Verifikator');
    }

    public function getHeading(): string | Htmlable
    {
        return new HtmlString('Masuk Verifikator');
    }

    public function getSubheading(): string | Htmlable | null
    {
        return new HtmlString('Gunakan akun verifikator untuk melanjutkan');
    }

    public function getFormContentComponent(): Component
    {
        $form = parent::getFormContentComponent();

        return Group::make([
            $form,
            Html::make(new HtmlString(
                '<div class="mt-3">'
                . '<a href="/" class="inline-flex w-full items-center justify-center rounded-md border border-blue-900 px-4 py-2 text-blue-900 hover:bg-blue-50">'
                . 'Kembali ke Beranda'
                . '</a>'
                . '</div>'
            ))->visible(fn (): bool => blank($this->userUndertakingMultiFactorAuthentication)),
        ]);
    }
}

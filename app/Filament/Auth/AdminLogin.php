<?php

namespace App\Filament\Auth;

use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Facades\Filament;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Html;

class AdminLogin extends BaseLogin
{
    public function getTitle(): string | Htmlable
    {
        return new HtmlString('Masuk Admin');
    }

    public function getHeading(): string | Htmlable
    {
        return new HtmlString('Masuk Admin');
    }

    public function getSubheading(): string | Htmlable | null
    {
        return new HtmlString('Gunakan akun admin untuk melanjutkan');
    }

    public function getFormContentComponent(): Component
    {
        $form = parent::getFormContentComponent();

        return Group::make([
            Html::make(function () {
                $background = asset('images/background-ft.jpg');

                return new HtmlString(<<<HTML
                    <style>
                        body {
                            min-height: 100vh;
                            background-image: linear-gradient(rgba(4, 26, 82, 0.7), rgba(5, 17, 47, 0.7)), url('{$background}');
                            background-size: cover;
                            background-position: center;
                            background-repeat: no-repeat;
                        }

                        body .fi-simple-layout,
                        body .fi-auth-simple,
                        body .fi-auth-body,
                        body .fi-simple-body {
                            min-height: 100vh;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            padding: 1.5rem;
                        }

                        body .fi-simple-main,
                        body .fi-auth-main {
                            width: 100%;
                            max-width: 28rem;
                        }

                        body .fi-auth-card,
                        body .fi-simple-card,
                        body .fi-simple-section,
                        body .fi-auth-section,
                        body .fi-login-card {
                            width: 100%;
                            background-color: #ffffff;
                            border-radius: 1.5rem;
                            border: 1px solid rgba(226, 232, 240, 0.9);
                            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.16);
                            padding: 2.25rem 2rem 2.5rem;
                        }

                        body .fi-form-fieldset,
                        body form[data-livewire-id] {
                            gap: 1.25rem !important;
                        }

                        body .fi-form-field-wrapper-label {
                            color: #1b3985 !important;
                            font-weight: 600 !important;
                        }

                        body input[type="email"],
                        body input[type="password"],
                        body input[type="text"] {
                            border-radius: 0.75rem !important;
                            border: 1px solid rgba(209, 213, 219, 0.9) !important;
                            padding: 0.65rem 1rem !important;
                        }

                        body .fi-login-submit {
                            background-color: #fa7516 !important;
                            border-radius: 0.75rem !important;
                        }

                        body .fi-login-back {
                            border-radius: 0.75rem !important;
                        }
                    </style>
                HTML);
            }),
            $form,
        ]);
    }
}

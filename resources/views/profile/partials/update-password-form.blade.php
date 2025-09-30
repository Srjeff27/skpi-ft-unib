<section class="space-y-6">
    <header>
        <h2 class="text-lg font-bold text-gray-800">
            Perbarui Password Akun
        </h2>
        <p class="mt-1 text-sm text-gray-500">
            Pastikan akun Anda menggunakan kata sandi yang panjang dan acak untuk menjaga keamanan.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        {{-- Menggunakan komponen password-input yang baru --}}
        <div>
            <x-password-input
                name="current_password"
                id="update_password_current_password"
                label="Password Saat Ini"
                autocomplete="current-password"
                class="mt-1 block w-full"
                :messages="$errors->updatePassword->get('current_password')" />
        </div>

        <div>
            <x-password-input
                name="password"
                id="update_password_password"
                label="Password Baru"
                autocomplete="new-password"
                class="mt-1 block w-full"
                :messages="$errors->updatePassword->get('password')" />
        </div>

        <div>
            <x-password-input
                name="password_confirmation"
                id="update_password_password_confirmation"
                label="Konfirmasi Password Baru"
                autocomplete="new-password"
                class="mt-1 block w-full"
                :messages="$errors->updatePassword->get('password_confirmation')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>
                <x-heroicon-o-check-circle class="w-5 h-5 mr-2" />
                {{ __('Simpan') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition.opacity.duration.500ms
                    x-init="setTimeout(() => show = false, 3000)"
                    class="flex items-center gap-2 text-sm text-green-600 font-semibold"
                >
                    <x-heroicon-s-check-circle class="w-5 h-5" />
                    {{ __('Tersimpan.') }}
                </p>
            @endif
        </div>
    </form>
</section>

<section class="max-w-5xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-200 overflow-hidden">
        <div class="p-6 sm:p-10 border-b border-gray-100">
            <h2 class="text-xl font-bold text-[#1b3985] flex items-center gap-2">
                <x-heroicon-o-lock-closed class="w-6 h-6" />
                Keamanan Akun
            </h2>
            <p class="mt-1 text-sm text-slate-500">Perbarui kata sandi secara berkala untuk menjaga keamanan data akademik Anda.</p>
        </div>

        <form method="post" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            <div class="p-6 sm:p-10 space-y-6">
                <div class="grid grid-cols-1 gap-6 max-w-2xl">
                    <div>
                        <x-password-input
                            name="current_password"
                            id="update_password_current_password"
                            label="Password Saat Ini"
                            autocomplete="current-password"
                            class="block w-full"
                            :messages="$errors->updatePassword->get('current_password')" 
                        />
                    </div>

                    <div>
                        <x-password-input
                            name="password"
                            id="update_password_password"
                            label="Password Baru"
                            autocomplete="new-password"
                            class="block w-full"
                            :messages="$errors->updatePassword->get('password')" 
                        />
                    </div>

                    <div>
                        <x-password-input
                            name="password_confirmation"
                            id="update_password_password_confirmation"
                            label="Konfirmasi Password Baru"
                            autocomplete="new-password"
                            class="block w-full"
                            :messages="$errors->updatePassword->get('password_confirmation')" 
                        />
                    </div>
                </div>
            </div>

            <div class="px-6 sm:px-10 py-4 bg-gray-50 flex items-center justify-between border-t border-gray-100">
                <div class="text-xs text-gray-500 italic hidden sm:block">
                    Gunakan kombinasi huruf, angka, dan simbol.
                </div>
                
                <div class="flex items-center gap-4 w-full sm:w-auto justify-end">
                    @if (session('status') === 'password-updated')
                        <span x-data="{ show: true }" 
                              x-show="show" 
                              x-transition.opacity.duration.1000ms 
                              x-init="setTimeout(() => show = false, 3000)" 
                              class="text-sm text-emerald-600 font-bold flex items-center gap-1"
                        >
                            <x-heroicon-s-check-circle class="w-5 h-5" />
                            Berhasil Diubah
                        </span>
                    @endif

                    <x-primary-button class="px-6 py-2.5 bg-[#1b3985] hover:bg-[#152e6b]">
                        {{ __('Simpan Password') }}
                    </x-primary-button>
                </div>
            </div>
        </form>
    </div>
</section>
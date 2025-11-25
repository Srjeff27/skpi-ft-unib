<section class="max-w-5xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        {{-- Header Section --}}
        <div class="p-6 sm:p-8 border-b border-slate-100 flex items-start gap-4">
            <div class="flex-shrink-0 p-3 bg-blue-50 rounded-xl text-[#1b3985]">
                <x-heroicon-o-shield-check class="w-6 h-6" />
            </div>
            <div>
                <h2 class="text-lg font-bold text-slate-800">Keamanan & Kata Sandi</h2>
                <p class="mt-1 text-sm text-slate-500 max-w-2xl leading-relaxed">
                    Pastikan akun Anda menggunakan kata sandi yang kuat dan unik untuk melindungi data akademik.
                </p>
            </div>
        </div>

        <form method="post" action="{{ route('password.update') }}" class="p-6 sm:p-8">
            @csrf
            @method('put')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">
                {{-- Kolom Kiri: Form Input --}}
                <div class="lg:col-span-2 space-y-5">
                    
                    {{-- Password Saat Ini --}}
                    <div x-data="{ show: false }">
                        <x-input-label for="update_password_current_password" value="Password Saat Ini" class="mb-1.5" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <x-heroicon-o-key class="h-5 w-5 text-slate-400" />
                            </div>
                            <x-text-input 
                                id="update_password_current_password" 
                                name="current_password" 
                                ::type="show ? 'text' : 'password'"
                                class="pl-10 pr-10 block w-full rounded-xl border-slate-300 focus:border-[#1b3985] focus:ring-[#1b3985]" 
                                autocomplete="current-password" 
                            />
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                                <x-heroicon-o-eye x-show="!show" class="h-5 w-5" />
                                <x-heroicon-o-eye-slash x-show="show" class="h-5 w-5" style="display: none;" />
                            </button>
                        </div>
                        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                    </div>

                    {{-- Password Baru --}}
                    <div x-data="{ show: false }">
                        <x-input-label for="update_password_password" value="Password Baru" class="mb-1.5" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <x-heroicon-o-lock-closed class="h-5 w-5 text-slate-400" />
                            </div>
                            <x-text-input 
                                id="update_password_password" 
                                name="password" 
                                ::type="show ? 'text' : 'password'"
                                class="pl-10 pr-10 block w-full rounded-xl border-slate-300 focus:border-[#1b3985] focus:ring-[#1b3985]" 
                                autocomplete="new-password" 
                            />
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                                <x-heroicon-o-eye x-show="!show" class="h-5 w-5" />
                                <x-heroicon-o-eye-slash x-show="show" class="h-5 w-5" style="display: none;" />
                            </button>
                        </div>
                        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div x-data="{ show: false }">
                        <x-input-label for="update_password_password_confirmation" value="Konfirmasi Password Baru" class="mb-1.5" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <x-heroicon-o-check-badge class="h-5 w-5 text-slate-400" />
                            </div>
                            <x-text-input 
                                id="update_password_password_confirmation" 
                                name="password_confirmation" 
                                ::type="show ? 'text' : 'password'"
                                class="pl-10 pr-10 block w-full rounded-xl border-slate-300 focus:border-[#1b3985] focus:ring-[#1b3985]" 
                                autocomplete="new-password" 
                            />
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                                <x-heroicon-o-eye x-show="!show" class="h-5 w-5" />
                                <x-heroicon-o-eye-slash x-show="show" class="h-5 w-5" style="display: none;" />
                            </button>
                        </div>
                        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                    </div>
                </div>

                {{-- Kolom Kanan: Password Checklist --}}
                <div class="lg:col-span-1">
                    <div class="bg-slate-50 rounded-xl p-5 border border-slate-100">
                        <h4 class="text-sm font-bold text-slate-700 mb-3 flex items-center gap-2">
                            <x-heroicon-o-information-circle class="w-4 h-4 text-[#1b3985]" />
                            Kriteria Keamanan
                        </h4>
                        <ul class="space-y-2 text-xs text-slate-500">
                            <li class="flex items-center gap-2">
                                <div class="w-1.5 h-1.5 rounded-full bg-slate-400"></div>
                                Minimal 8 karakter
                            </li>
                            <li class="flex items-center gap-2">
                                <div class="w-1.5 h-1.5 rounded-full bg-slate-400"></div>
                                Kombinasi huruf besar & kecil
                            </li>
                            <li class="flex items-center gap-2">
                                <div class="w-1.5 h-1.5 rounded-full bg-slate-400"></div>
                                Mengandung minimal 1 angka
                            </li>
                            <li class="flex items-center gap-2">
                                <div class="w-1.5 h-1.5 rounded-full bg-slate-400"></div>
                                Mengandung simbol (opsional)
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Footer Action --}}
            <div class="flex items-center justify-end gap-4 mt-8 pt-6 border-t border-slate-100">
                @if (session('status') === 'password-updated')
                    <div x-data="{ show: true }" x-show="show" x-transition.opacity.duration.500ms x-init="setTimeout(() => show = false, 3000)"
                        class="flex items-center gap-1.5 text-sm font-semibold text-emerald-600 bg-emerald-50 px-3 py-1.5 rounded-lg border border-emerald-100">
                        <x-heroicon-s-check-circle class="w-4 h-4" />
                        <span>Password Berhasil Diubah</span>
                    </div>
                @endif

                <x-primary-button class="px-8 py-3 bg-[#1b3985] hover:bg-[#152e6b] shadow-lg shadow-blue-900/20 rounded-xl">
                    {{ __('Simpan Password Baru') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</section>
<x-guest-layout>
    <div class="text-center mb-8 space-y-3">
        <a href="/" class="inline-block relative group">
            <div class="absolute inset-0 bg-orange-200 rounded-full blur opacity-50 group-hover:opacity-75 transition duration-200"></div>
            <span class="relative inline-flex items-center justify-center h-20 w-20 rounded-full bg-gradient-to-br from-[#fa7516] to-[#e5670c] shadow-lg transform group-hover:scale-105 transition duration-200">
                <img src="{{ asset('images/logo-ft.png') }}" alt="Logo FT UNIB" class="h-12 w-12 drop-shadow-md">
            </span>
        </a>
        <div class="space-y-1">
            <h2 class="text-3xl font-bold text-[#1b3985] tracking-tight">Registrasi Akun</h2>
            <p class="text-sm text-gray-500">Isi data diri Anda dengan benar untuk membuat akun baru.</p>
        </div>
    </div>

    @php
        $isMaintenance = (bool) \App\Models\Setting::get('maintenance', 0);
    @endphp

    @if ($isMaintenance)
        <div class="rounded-lg border border-amber-200 bg-amber-50 p-4 text-center text-sm text-amber-800">
            <p>Pendaftaran sementara dinonaktifkan karena sistem dalam mode pemeliharaan.</p>
        </div>
    @else
        <div class="flex flex-col space-y-4">
            <a href="{{ route('google.redirect') }}"
               class="relative w-full inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm font-semibold text-gray-700 shadow-sm transition-all duration-200 hover:bg-gray-50 hover:shadow-md hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200">
                <svg class="mr-3 h-5 w-5" viewBox="0 0 24 24">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                <span class="tracking-wide">Daftar dengan Google</span>
            </a>
        </div>
    @endif

    <div class="relative my-7">
        <div class="absolute inset-0 flex items-center" aria-hidden="true">
            <div class="w-full border-t border-gray-200"></div>
        </div>
        <div class="relative flex justify-center">
            <span class="bg-white px-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Atau Daftar Manual</span>
        </div>
    </div>

    <form method="POST" action="{{ route('register.store') }}" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <x-input-label for="name" value="Nama Lengkap" class="text-[#1b3985] font-semibold mb-1.5" />
                <div class="relative rounded-md shadow-sm">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" /></svg>
                    </div>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                        class="block w-full rounded-xl border-gray-300 pl-10 focus:border-[#fa7516] focus:ring-[#fa7516] sm:text-sm py-2.5 transition-colors placeholder:text-slate-400"
                        placeholder="Sesuai KTM">
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="npm" value="NPM" class="text-[#1b3985] font-semibold mb-1.5" />
                <div class="relative rounded-md shadow-sm">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 2a1 1 0 00-1 1v1a1 1 0 002 0V3a1 1 0 00-1-1zM4 4h3a3 3 0 006 0h3a2 2 0 012 2v9a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2zm2.5 7a1.5 1.5 0 100-3 1.5 1.5 0 000 3zm2.45 4a2.5 2.5 0 10-4.9 0h4.9zM12 9a1 1 0 100 2h3a1 1 0 100-2h-3zm-1 4a1 1 0 011-1h2a1 1 0 110 2h-2a1 1 0 01-1-1z" clip-rule="evenodd" /></svg>
                    </div>
                    <input id="npm" name="npm" type="text" value="{{ old('npm') }}" required
                        class="block w-full rounded-xl border-gray-300 pl-10 focus:border-[#fa7516] focus:ring-[#fa7516] sm:text-sm py-2.5 transition-colors placeholder:text-slate-400 uppercase font-semibold"
                        placeholder="G1F...">
                </div>
                <x-input-error :messages="$errors->get('npm')" class="mt-2" />
            </div>
        </div>

        <div>
            <x-input-label for="prodi_id" value="Program Studi" class="text-[#1b3985] font-semibold mb-1.5" />
            <div class="relative rounded-md shadow-sm">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"><path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM12 18a1 1 0 100-2 1 1 0 000 2z" /></svg>
                </div>
                <select id="prodi_id" name="prodi_id"
                    class="block w-full rounded-xl border-gray-300 pl-10 focus:border-[#fa7516] focus:ring-[#fa7516] sm:text-sm py-2.5 transition-colors bg-white cursor-pointer">
                    <option value="">Pilih Program Studi</option>
                    @foreach($prodis ?? [] as $prodi)
                        <option value="{{ $prodi->id }}" {{ old('prodi_id') == $prodi->id ? 'selected' : '' }}>{{ $prodi->nama_prodi }}</option>
                    @endforeach
                </select>
            </div>
            <x-input-error :messages="$errors->get('prodi_id')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" value="Alamat Email" class="text-[#1b3985] font-semibold mb-1.5" />
            <div class="relative rounded-md shadow-sm">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" /><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" /></svg>
                </div>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required
                    class="block w-full rounded-xl border-gray-300 pl-10 focus:border-[#fa7516] focus:ring-[#fa7516] sm:text-sm py-2.5 transition-colors placeholder:text-slate-400"
                    placeholder="nama@unib.ac.id">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <x-input-label for="password" value="Kata Sandi" class="text-[#1b3985] font-semibold mb-1.5" />
                <div class="relative rounded-md shadow-sm">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" /></svg>
                    </div>
                    <input id="password" name="password" type="password" required autocomplete="new-password"
                        class="block w-full rounded-xl border-gray-300 pl-10 pr-12 focus:border-[#fa7516] focus:ring-[#fa7516] sm:text-sm py-2.5 transition-colors placeholder:text-slate-400"
                        placeholder="••••••••">
                    <button type="button" onclick="togglePassword('password', 'icon-pass')"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                        <svg id="icon-pass" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password_confirmation" value="Ulangi Sandi" class="text-[#1b3985] font-semibold mb-1.5" />
                <div class="relative rounded-md shadow-sm">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" /></svg>
                    </div>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                        class="block w-full rounded-xl border-gray-300 pl-10 pr-12 focus:border-[#fa7516] focus:ring-[#fa7516] sm:text-sm py-2.5 transition-colors placeholder:text-slate-400"
                        placeholder="••••••••">
                    <button type="button" onclick="togglePassword('password_confirmation', 'icon-confirm')"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                        <svg id="icon-confirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="pt-2 flex flex-col gap-3">
            <button type="submit"
                class="w-full inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-[#fa7516] to-[#e5670c] px-4 py-3 text-white font-bold tracking-wide shadow-lg shadow-orange-200 transition-all duration-200 hover:shadow-orange-300 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-[#fa7516] focus:ring-offset-2">
                Daftar Sekarang
            </button>
            
            <a href="{{ route('login') }}"
                class="w-full inline-flex items-center justify-center rounded-xl border border-transparent bg-blue-50 px-4 py-3 font-semibold text-[#1b3985] hover:bg-blue-100 transition-colors">
                Sudah punya akun? Masuk
            </a>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const npmInput = document.getElementById('npm');
            const prodiSelect = document.getElementById('prodi_id');
            
            if (npmInput && prodiSelect) {
                const prodiMap = {
                    'G1A': 'Informatika',
                    'G1B': 'Teknik Sipil',
                    'G1C': 'Teknik Mesin',
                    'G1D': 'Teknik Elektro',
                    'G1E': 'Arsitektur',
                    'G1F': 'Sistem Informasi',
                };

                npmInput.addEventListener('input', (e) => {
                    const value = e.target.value.trim().toUpperCase();
                    if (value.length >= 3) {
                        const code = value.substring(0, 3);
                        const targetName = prodiMap[code];
                        if (targetName) {
                            for (let option of prodiSelect.options) {
                                if (option.text.toLowerCase().includes(targetName.toLowerCase())) {
                                    prodiSelect.value = option.value;
                                    prodiSelect.classList.add('ring-2', 'ring-[#fa7516]');
                                    setTimeout(() => prodiSelect.classList.remove('ring-2', 'ring-[#fa7516]'), 500);
                                    break;
                                }
                            }
                        }
                    } else if (value.length === 0) {
                        prodiSelect.value = "";
                    }
                });
            }
        });

        window.togglePassword = function(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            
            if (input.type === "password") {
                input.type = "text";
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />';
            } else {
                input.type = "password";
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
            }
        };
    </script>
</x-guest-layout>

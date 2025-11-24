<x-app-layout>
    @php
        $showAcademicReminder = session('academic_incomplete') || (auth()->user()?->role === 'mahasiswa' && !auth()->user()?->isAcademicProfileComplete());
    @endphp
    <div x-data="{ tab: window.location.hash ? window.location.hash.substring(1) : 'profile' }" class="space-y-6">
        <div class="relative rounded-xl bg-gradient-to-r from-[#1b3985] to-[#2b50a8] p-6 overflow-hidden">
            <div class="relative z-10 space-y-2">
                <h1 class="text-2xl font-bold text-white">Pengaturan Akun</h1>
                <p class="text-blue-200 max-w-md">Kelola informasi profil, preferensi, dan keamanan akun Anda.</p>
            </div>
            <div class="absolute -bottom-12 -right-12 w-40 h-40 rounded-full bg-blue-800 opacity-50"></div>
            <div class="absolute -bottom-4 -right-4 w-24 h-24 rounded-full bg-blue-700 opacity-50"></div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                    <nav class="space-y-1">
                        <a @click.prevent="tab = 'profile'; window.location.hash = 'profile'" href="#"
                           class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors"
                           :class="tab === 'profile' ? 'bg-blue-50 text-[#1b3985]' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" /></svg>
                            Profil
                        </a>
                        <a @click.prevent="tab = 'graduation'; window.location.hash = 'graduation'" href="#"
                           class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors"
                           :class="tab === 'graduation' ? 'bg-blue-50 text-[#1b3985]' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'">
                            <x-heroicon-o-academic-cap class="h-5 w-5 mr-3" />
                            Data Kelulusan
                        </a>
                        <a @click.prevent="tab = 'password'; window.location.hash = 'password'" href="#"
                           class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors"
                           :class="tab === 'password' ? 'bg-blue-50 text-[#1b3985]' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 1.944A11.954 11.954 0 012.166 5.02.998.998 0 001.993 6.01c.312.42.65.826.994 1.212.345.386.708.756 1.09 1.107A11.958 11.958 0 0110 18.056a11.958 11.958 0 01-6.907-2.728.998.998 0 00-1.414 1.414 13.955 13.955 0 0016.64 0 .998.998 0 00-1.414-1.414A11.958 11.958 0 0110 18.056zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" /></svg>
                            Ubah Password
                        </a>
                        <a @click.prevent="tab = 'delete'; window.location.hash = 'delete'" href="#"
                           class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors"
                           :class="tab === 'delete' ? 'bg-red-50 text-red-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                            Hapus Akun
                        </a>
                    </nav>
                </div>
            </div>

            <div class="lg:col-span-3">
                @if ($showAcademicReminder)
                    <div class="mb-4 rounded-xl border border-amber-200 bg-amber-50 text-amber-800 p-4 flex items-start gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-white text-amber-500 border border-amber-100">
                            <x-heroicon-o-exclamation-triangle class="w-5 h-5" />
                        </div>
                        <div class="space-y-1">
                            <p class="font-semibold">Lengkapi Data Akademik Anda</p>
                            <p class="text-sm">Beberapa data akademik masih kosong. Silakan isi di tab Profil sebelum mengakses portofolio atau fitur lain.</p>
                        </div>
                    </div>
                @endif

                <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                    <div x-show="tab === 'profile'" x-cloak>
                        @include('profile.partials.update-profile-information-form')
                    </div>
                    <div x-show="tab === 'graduation'" x-cloak>
                        @include('profile.partials.graduation-information')
                    </div>
                    <div x-show="tab === 'password'" x-cloak>
                        @include('profile.partials.update-password-form')
                    </div>
                    <div x-show="tab === 'delete'" x-cloak>
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

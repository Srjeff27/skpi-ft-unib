<x-app-layout>
    @php
        $user = auth()->user();
        $isAcademicIncomplete = session('academic_incomplete') || ($user?->role === 'mahasiswa' && !$user?->isAcademicProfileComplete());
    @endphp

    <div x-data="{ 
            tab: window.location.hash ? window.location.hash.substring(1) : 'profile',
            updateHash(newTab) {
                this.tab = newTab;
                window.location.hash = newTab;
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        }" 
        class="min-h-screen pb-20 space-y-8">
        
        {{-- 1. Header Section --}}
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900 via-[#1b3985] to-[#2b50a8] shadow-xl">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 h-64 w-64 rounded-full bg-white/5 blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 h-40 w-40 rounded-full bg-blue-400/10 blur-2xl pointer-events-none"></div>

            <div class="relative z-10 p-8 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="flex items-center gap-6">
                    <div class="hidden md:flex h-20 w-20 shrink-0 items-center justify-center rounded-2xl bg-white/10 backdrop-blur-sm border border-white/20 shadow-inner text-white text-2xl font-bold">
                        {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                    </div>
                    <div class="space-y-2">
                        <h1 class="text-3xl font-bold text-white tracking-tight">Pengaturan Akun</h1>
                        <p class="text-blue-100/90 text-sm md:text-base max-w-xl leading-relaxed">
                            Kelola informasi pribadi, data akademik, dan keamanan akun Anda di sini.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            {{-- 2. Sidebar Navigation (Vertical on Desktop, Horizontal Scroll on Mobile) --}}
            <div class="lg:col-span-3 lg:sticky lg:top-24 z-10">
                <nav class="flex flex-wrap gap-3 sm:gap-2 overflow-x-auto sm:overflow-visible pb-4 lg:flex-col lg:pb-0 no-scrollbar" aria-label="Tabs">
                    
                    {{-- Tab: Profil --}}
                    <button @click.prevent="updateHash('profile')"
                        :class="tab === 'profile' 
                            ? 'bg-white text-[#1b3985] shadow-md ring-1 ring-slate-200' 
                            : 'text-slate-500 hover:text-slate-700 hover:bg-white/60'"
                        class="flex-shrink-0 group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 w-full sm:w-auto min-w-[160px] lg:min-w-0">
                        <span :class="tab === 'profile' ? 'bg-blue-50 text-[#1b3985]' : 'bg-slate-100 text-slate-400 group-hover:text-slate-600'"
                              class="mr-3 flex-shrink-0 h-8 w-8 flex items-center justify-center rounded-lg transition-colors">
                            <x-heroicon-o-user class="h-5 w-5" />
                        </span>
                        <span class="whitespace-nowrap">Profil Umum</span>
                    </button>

                    {{-- Tab: Data Kelulusan (Only for Mahasiswa) --}}
                    @if($user->role === 'mahasiswa')
                    <button @click.prevent="updateHash('graduation')"
                        :class="tab === 'graduation' 
                            ? 'bg-white text-[#1b3985] shadow-md ring-1 ring-slate-200' 
                            : 'text-slate-500 hover:text-slate-700 hover:bg-white/60'"
                        class="flex-shrink-0 group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 w-full sm:w-auto min-w-[160px] lg:min-w-0">
                        <span :class="tab === 'graduation' ? 'bg-blue-50 text-[#1b3985]' : 'bg-slate-100 text-slate-400 group-hover:text-slate-600'"
                              class="mr-3 flex-shrink-0 h-8 w-8 flex items-center justify-center rounded-lg transition-colors">
                            <x-heroicon-o-academic-cap class="h-5 w-5" />
                        </span>
                        <span class="whitespace-nowrap">Data Akademik</span>
                        @if($isAcademicIncomplete)
                            <span class="ml-auto flex h-2 w-2 rounded-full bg-amber-500"></span>
                        @endif
                    </button>
                    @endif

                    {{-- Tab: Password --}}
                    <button @click.prevent="updateHash('password')"
                        :class="tab === 'password' 
                            ? 'bg-white text-[#1b3985] shadow-md ring-1 ring-slate-200' 
                            : 'text-slate-500 hover:text-slate-700 hover:bg-white/60'"
                        class="flex-shrink-0 group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 w-full sm:w-auto min-w-[160px] lg:min-w-0">
                        <span :class="tab === 'password' ? 'bg-blue-50 text-[#1b3985]' : 'bg-slate-100 text-slate-400 group-hover:text-slate-600'"
                              class="mr-3 flex-shrink-0 h-8 w-8 flex items-center justify-center rounded-lg transition-colors">
                            <x-heroicon-o-lock-closed class="h-5 w-5" />
                        </span>
                        <span class="whitespace-nowrap">Keamanan</span>
                    </button>

                    {{-- Tab: Hapus Akun --}}
                    <button @click.prevent="updateHash('delete')"
                        :class="tab === 'delete' 
                            ? 'bg-white text-rose-600 shadow-md ring-1 ring-rose-100' 
                            : 'text-slate-500 hover:text-rose-600 hover:bg-rose-50/50'"
                        class="flex-shrink-0 group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 w-full sm:w-auto min-w-[160px] lg:min-w-0 mt-auto lg:mt-4">
                        <span :class="tab === 'delete' ? 'bg-rose-50 text-rose-600' : 'bg-slate-100 text-slate-400 group-hover:bg-rose-100 group-hover:text-rose-500'"
                              class="mr-3 flex-shrink-0 h-8 w-8 flex items-center justify-center rounded-lg transition-colors">
                            <x-heroicon-o-trash class="h-5 w-5" />
                        </span>
                        <span class="whitespace-nowrap">Hapus Akun</span>
                    </button>
                </nav>
            </div>

            {{-- 3. Content Area --}}
            <div class="lg:col-span-9 space-y-6">
                
                {{-- Academic Warning --}}
                @if ($isAcademicIncomplete)
                    <div class="rounded-xl border-l-4 border-amber-500 bg-white p-5 shadow-sm ring-1 ring-slate-200">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0">
                                <span class="flex h-10 w-10 items-center justify-center rounded-full bg-amber-100 text-amber-600">
                                    <x-heroicon-o-exclamation-triangle class="h-6 w-6" />
                                </span>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-slate-900">Data Akademik Belum Lengkap</h3>
                                <p class="mt-1 text-sm text-slate-600 leading-relaxed">
                                    Mohon lengkapi data pada tab <strong>Data Akademik</strong> (NPM, Prodi, dll) agar Anda dapat menggunakan fitur Portofolio dan pengajuan SKPI.
                                </p>
                                <button @click="updateHash('graduation')" class="mt-3 text-sm font-semibold text-amber-700 hover:underline">
                                    Lengkapi Sekarang &rarr;
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Tab Contents with Transitions --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden min-h-[400px]">
                    
                    {{-- Profile Form --}}
                    <div x-show="tab === 'profile'" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="p-6 sm:p-8" x-cloak>
                        <div class="max-w-2xl">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    {{-- Graduation Form --}}
                    <div x-show="tab === 'graduation'" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="p-6 sm:p-8" x-cloak>
                        <div class="max-w-2xl">
                            @include('profile.partials.graduation-information')
                        </div>
                    </div>

                    {{-- Password Form --}}
                    <div x-show="tab === 'password'" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="p-6 sm:p-8" x-cloak>
                        <div class="max-w-xl">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                    {{-- Delete Form --}}
                    <div x-show="tab === 'delete'" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="p-6 sm:p-8 bg-rose-50/30 h-full" x-cloak>
                        <div class="max-w-xl">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

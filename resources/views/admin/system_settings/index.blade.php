<x-app-layout>
    <div x-data="{ activeTab: 'institusi' }" x-cloak class="space-y-8">
        
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Pengaturan Sistem</h2>
                <p class="mt-1 text-sm text-slate-500">Konfigurasi global aplikasi dan parameter dokumen SKPI.</p>
            </div>
        </div>

        @if (session('status'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
                 class="flex items-center gap-3 rounded-xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-emerald-700 shadow-sm">
                <x-heroicon-s-check-circle class="h-5 w-5" />
                <span class="text-sm font-medium">{{ session('status') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="flex items-center gap-3 rounded-xl border border-rose-100 bg-rose-50 px-4 py-3 text-rose-700 shadow-sm">
                <x-heroicon-s-x-circle class="h-5 w-5" />
                <span class="text-sm font-medium">{{ $errors->first() }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            {{-- Sidebar Navigation --}}
            <div class="lg:col-span-3 lg:sticky lg:top-24">
                <nav class="space-y-1">
                    <button @click="activeTab = 'institusi'"
                        x-bind:class="activeTab === 'institusi' 
                            ? 'bg-blue-50 text-[#1b3985] border-[#1b3985]' 
                            : 'border-transparent text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
                        class="group flex w-full items-center gap-3 border-l-4 px-4 py-3 text-sm font-medium transition-all duration-200">
                        <x-heroicon-o-building-library class="h-5 w-5 transition-colors" 
                            x-bind:class="activeTab === 'institusi' ? 'text-[#1b3985]' : 'text-slate-400 group-hover:text-slate-600'" />
                        <span>Identitas Institusi</span>
                    </button>

                    <button @click="activeTab = 'narasi'"
                        x-bind:class="activeTab === 'narasi' 
                            ? 'bg-blue-50 text-[#1b3985] border-[#1b3985]' 
                            : 'border-transparent text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
                        class="group flex w-full items-center gap-3 border-l-4 px-4 py-3 text-sm font-medium transition-all duration-200">
                        <x-heroicon-o-document-text class="h-5 w-5 transition-colors" 
                            x-bind:class="activeTab === 'narasi' ? 'text-[#1b3985]' : 'text-slate-400 group-hover:text-slate-600'" />
                        <span>Narasi Dokumen</span>
                    </button>

                    <button @click="activeTab = 'umum'"
                        x-bind:class="activeTab === 'umum' 
                            ? 'bg-blue-50 text-[#1b3985] border-[#1b3985]' 
                            : 'border-transparent text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
                        class="group flex w-full items-center gap-3 border-l-4 px-4 py-3 text-sm font-medium transition-all duration-200">
                        <x-heroicon-o-cog-6-tooth class="h-5 w-5 transition-colors" 
                            x-bind:class="activeTab === 'umum' ? 'text-[#1b3985]' : 'text-slate-400 group-hover:text-slate-600'" />
                        <span>Konfigurasi Umum</span>
                    </button>
                </nav>
            </div>

            {{-- Content Area --}}
            <div class="lg:col-span-9">
                
                {{-- Tab: Informasi Institusi --}}
                <div x-show="activeTab === 'institusi'" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0">
                    
                    <form method="POST" action="{{ route('admin.system_settings.institution') }}" class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50">
                            <h3 class="text-base font-bold text-slate-900">Data Institusi</h3>
                            <p class="text-xs text-slate-500 mt-1">Data ini akan dicetak pada bagian header dokumen SKPI.</p>
                        </div>
                        
                        <div class="p-6 sm:p-8 space-y-6">
                            @csrf
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <div>
                                    <x-input-label for="univ_name" value="Nama Universitas" />
                                    <x-text-input id="univ_name" name="univ_name" class="mt-1 block w-full" :value="old('univ_name', $data['univ_name'])" required />
                                </div>
                                <div>
                                    <x-input-label for="faculty_name" value="Nama Fakultas" />
                                    <x-text-input id="faculty_name" name="faculty_name" class="mt-1 block w-full" :value="old('faculty_name', $data['faculty_name'])" required />
                                </div>
                            </div>

                            <div>
                                <x-input-label for="sk_pt" value="SK Pendirian Perguruan Tinggi" />
                                <x-text-input id="sk_pt" name="sk_pt" class="mt-1 block w-full" :value="old('sk_pt', $data['sk_pt'])" />
                            </div>

                            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                                <div>
                                    <x-input-label for="grading" value="Sistem Penilaian" />
                                    <textarea id="grading" name="grading" rows="4" class="mt-1 block w-full rounded-xl border-slate-300 shadow-sm focus:border-[#1b3985] focus:ring-[#1b3985] text-sm">{{ old('grading', $data['grading']) }}</textarea>
                                </div>
                                <div>
                                    <x-input-label for="admission" value="Persyaratan Penerimaan" />
                                    <textarea id="admission" name="admission" rows="4" class="mt-1 block w-full rounded-xl border-slate-300 shadow-sm focus:border-[#1b3985] focus:ring-[#1b3985] text-sm">{{ old('admission', $data['admission']) }}</textarea>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                                <div>
                                    <x-input-label for="languages" value="Bahasa Pengantar Kuliah" />
                                    <x-text-input id="languages" name="languages" class="mt-1 block w-full" :value="old('languages', $data['languages'])" />
                                </div>
                                <div>
                                    <x-input-label for="contact" value="Alamat & Kontak" />
                                    <textarea id="contact" name="contact" rows="2" class="mt-1 block w-full rounded-xl border-slate-300 shadow-sm focus:border-[#1b3985] focus:ring-[#1b3985] text-sm">{{ old('contact', $data['contact']) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="bg-slate-50 px-6 py-4 flex items-center justify-end border-t border-slate-100">
                            <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-[#1b3985] px-6 py-2.5 text-sm font-bold text-white shadow-md hover:bg-[#152c66] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all">
                                <x-heroicon-m-check class="h-4 w-4" />
                                Simpan Data
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Tab: Narasi Dokumen --}}
                <div x-show="activeTab === 'narasi'" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-cloak>
                    
                    <form method="POST" action="{{ route('admin.system_settings.narratives') }}" class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50">
                            <h3 class="text-base font-bold text-slate-900">Narasi Standar</h3>
                            <p class="text-xs text-slate-500 mt-1">Penjelasan sistem pendidikan dan KKNI dalam dua bahasa.</p>
                        </div>

                        <div class="p-6 sm:p-8 space-y-8">
                            @csrf
                            
                            <div>
                                <div class="flex items-center gap-2 mb-4">
                                    <div class="h-8 w-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                                        <x-heroicon-o-academic-cap class="h-5 w-5" />
                                    </div>
                                    <h4 class="text-sm font-bold text-slate-800">Sistem Pendidikan Tinggi</h4>
                                </div>
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                    <div>
                                        <x-input-label for="narasi_pt_id" value="Bahasa Indonesia" />
                                        <textarea id="narasi_pt_id" name="narasi_pt_id" rows="6" class="mt-1 block w-full rounded-xl border-slate-300 shadow-sm focus:border-[#1b3985] focus:ring-[#1b3985] text-sm">{{ old('narasi_pt_id', $data['narasi_pt_id']) }}</textarea>
                                    </div>
                                    <div>
                                        <x-input-label for="narasi_pt_en" value="English" />
                                        <textarea id="narasi_pt_en" name="narasi_pt_en" rows="6" class="mt-1 block w-full rounded-xl border-slate-300 shadow-sm focus:border-[#1b3985] focus:ring-[#1b3985] text-sm italic bg-slate-50/50">{{ old('narasi_pt_en', $data['narasi_pt_en']) }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <hr class="border-slate-100">

                            <div>
                                <div class="flex items-center gap-2 mb-4">
                                    <div class="h-8 w-8 rounded-lg bg-orange-50 flex items-center justify-center text-orange-600">
                                        <x-heroicon-o-bars-3-bottom-left class="h-5 w-5" />
                                    </div>
                                    <h4 class="text-sm font-bold text-slate-800">Kerangka Kualifikasi Nasional (KKNI)</h4>
                                </div>
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                    <div>
                                        <x-input-label for="narasi_kkni_id" value="Bahasa Indonesia" />
                                        <textarea id="narasi_kkni_id" name="narasi_kkni_id" rows="6" class="mt-1 block w-full rounded-xl border-slate-300 shadow-sm focus:border-[#1b3985] focus:ring-[#1b3985] text-sm">{{ old('narasi_kkni_id', $data['narasi_kkni_id']) }}</textarea>
                                    </div>
                                    <div>
                                        <x-input-label for="narasi_kkni_en" value="English" />
                                        <textarea id="narasi_kkni_en" name="narasi_kkni_en" rows="6" class="mt-1 block w-full rounded-xl border-slate-300 shadow-sm focus:border-[#1b3985] focus:ring-[#1b3985] text-sm italic bg-slate-50/50">{{ old('narasi_kkni_en', $data['narasi_kkni_en']) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-slate-50 px-6 py-4 flex items-center justify-end border-t border-slate-100">
                            <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-[#1b3985] px-6 py-2.5 text-sm font-bold text-white shadow-md hover:bg-[#152c66] transition-all">
                                <x-heroicon-m-check class="h-4 w-4" />
                                Simpan Narasi
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Tab: Pengaturan Umum --}}
                <div x-show="activeTab === 'umum'" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-cloak>
                    
                    <form method="POST" action="{{ route('admin.system_settings.general') }}" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50">
                            <h3 class="text-base font-bold text-slate-900">Aplikasi & Jadwal</h3>
                            <p class="text-xs text-slate-500 mt-1">Pengaturan visual dan aksesibilitas sistem.</p>
                        </div>

                        <div class="p-6 sm:p-8 space-y-8">
                            @csrf
                            
                            {{-- Logo Upload --}}
                            <div class="flex flex-col sm:flex-row gap-6 items-start">
                                <div class="flex-shrink-0">
                                    <span class="block text-sm font-medium text-slate-700 mb-2">Logo Saat Ini</span>
                                    @if($data['logo_path'])
                                        <div class="h-24 w-24 rounded-xl border border-slate-200 p-2 flex items-center justify-center bg-white shadow-sm">
                                            <img src="{{ asset('storage/'.$data['logo_path']) }}" alt="Logo" class="h-full w-auto object-contain">
                                        </div>
                                    @else
                                        <div class="h-24 w-24 rounded-xl border-2 border-dashed border-slate-300 flex items-center justify-center text-slate-400">
                                            <span class="text-xs">No Logo</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow w-full">
                                    <x-input-label for="logo" value="Unggah Logo Baru" />
                                    <div class="mt-1 flex justify-center rounded-xl border-2 border-dashed border-slate-300 px-6 pt-5 pb-6 hover:border-blue-400 transition-colors">
                                        <div class="space-y-1 text-center">
                                            <x-heroicon-o-photo class="mx-auto h-12 w-12 text-slate-400" />
                                            <div class="flex text-sm text-slate-600 justify-center">
                                                <label for="logo" class="relative cursor-pointer rounded-md bg-white font-medium text-blue-600 focus-within:outline-none hover:text-blue-500">
                                                    <span>Upload file</span>
                                                    <input id="logo" name="logo" type="file" class="sr-only" accept="image/png, image/jpeg">
                                                </label>
                                                <p class="pl-1">atau drag and drop</p>
                                            </div>
                                            <p class="text-xs text-slate-500">PNG, JPG, GIF (Max 2MB)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="border-slate-100">

                            {{-- Jadwal Pengisian --}}
                            <div>
                                <h4 class="text-sm font-bold text-slate-800 mb-4">Periode Pengisian Portofolio</h4>
                                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                    <div>
                                        <x-input-label for="portfolio_open" value="Tanggal Buka" />
                                        <div class="relative mt-1">
                                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                                <x-heroicon-o-calendar class="h-5 w-5 text-slate-400" />
                                            </div>
                                            <x-text-input id="portfolio_open" name="portfolio_open" type="date" class="pl-10 block w-full" :value="old('portfolio_open', $data['portfolio_open'])" />
                                        </div>
                                    </div>
                                    <div>
                                        <x-input-label for="portfolio_close" value="Tanggal Tutup" />
                                        <div class="relative mt-1">
                                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                                <x-heroicon-o-calendar class="h-5 w-5 text-slate-400" />
                                            </div>
                                            <x-text-input id="portfolio_close" name="portfolio_close" type="date" class="pl-10 block w-full" :value="old('portfolio_close', $data['portfolio_close'])" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Maintenance Mode --}}
                            <div x-data="{ maintenance: {{ $data['maintenance'] ? 'true' : 'false' }} }" 
                                 class="rounded-xl border border-slate-200 p-4 flex items-center justify-between bg-slate-50">
                                <div class="flex items-start gap-3">
                                    <div class="p-2 bg-orange-100 text-orange-600 rounded-lg">
                                        <x-heroicon-o-wrench-screwdriver class="h-5 w-5" />
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-800">Mode Pemeliharaan (Maintenance)</h4>
                                        <p class="text-xs text-slate-500 mt-0.5">Aktifkan untuk menutup akses login mahasiswa sementara waktu.</p>
                                    </div>
                                </div>
                                
                                <input type="hidden" name="maintenance" :value="maintenance ? 1 : 0">
                                <button type="button" 
                                        @click="maintenance = !maintenance" 
                                        class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none"
                                        :class="maintenance ? 'bg-orange-500' : 'bg-slate-200'">
                                    <span aria-hidden="true" 
                                          class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                                          :class="maintenance ? 'translate-x-5' : 'translate-x-0'"></span>
                                </button>
                            </div>
                        </div>

                        <div class="bg-slate-50 px-6 py-4 flex items-center justify-end border-t border-slate-100">
                            <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-[#1b3985] px-6 py-2.5 text-sm font-bold text-white shadow-md hover:bg-[#152c66] transition-all">
                                <x-heroicon-m-check class="h-4 w-4" />
                                Simpan Pengaturan
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

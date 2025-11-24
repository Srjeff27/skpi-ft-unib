<x-app-layout>
    <div x-data="{ activeTab: 'institusi' }">
        {{-- Header --}}
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Pengaturan Sistem</h2>
            <p class="text-sm text-gray-500">Atur teks dan konfigurasi statis untuk dokumen SKPI dan aplikasi.</p>
        </div>

        @if (session('status'))
            <x-toast type="success" :message="session('status')" />
        @endif
        @if ($errors->any())
            <x-toast type="error" :message="$errors->first()" />
        @endif

        <div class="grid grid-cols-1 gap-8 md:grid-cols-4">
            {{-- Vertical Nav --}}
            <div class="col-span-1">
                <div class="sticky top-6 space-y-2">
                    <button @click="activeTab = 'institusi'"
                        :class="activeTab === 'institusi' ? 'bg-[#1b3985] text-white' : 'text-gray-600 hover:bg-gray-100'"
                        class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors">
                        <x-heroicon-o-building-office-2 class="h-5 w-5" />
                        <span>Informasi Institusi</span>
                    </button>
                    <button @click="activeTab = 'narasi'"
                        :class="activeTab === 'narasi' ? 'bg-[#1b3985] text-white' : 'text-gray-600 hover:bg-gray-100'"
                        class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors">
                        <x-heroicon-o-document-text class="h-5 w-5" />
                        <span>Narasi Dokumen</span>
                    </button>
                    <button @click="activeTab = 'umum'"
                        :class="activeTab === 'umum' ? 'bg-[#1b3985] text-white' : 'text-gray-600 hover:bg-gray-100'"
                        class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors">
                        <x-heroicon-o-cog-6-tooth class="h-5 w-5" />
                        <span>Pengaturan Umum</span>
                    </button>
                </div>
            </div>

            {{-- Content --}}
            <div class="col-span-1 md:col-span-3">
                {{-- Tab: Informasi Institusi --}}
                <div x-show="activeTab === 'institusi'" x-transition.opacity>
                    <form method="POST" action="{{ route('admin.system_settings.institution') }}" class="rounded-xl border border-gray-100 bg-white shadow-sm">
                        <div class="p-6 border-b">
                            <h3 class="text-lg font-semibold text-gray-800">Informasi Institusi</h3>
                            <p class="text-sm text-gray-500">Informasi ini akan ditampilkan pada dokumen SKPI yang dicetak.</p>
                        </div>
                        <div class="p-6 space-y-4">
                            @csrf
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
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
                            <div>
                                <x-input-label for="grading" value="Sistem Penilaian" />
                                <textarea id="grading" name="grading" rows="3" class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm focus:border-[#1b3985] focus:ring-[#1b3985]">{{ old('grading', $data['grading']) }}</textarea>
                            </div>
                            <div>
                                <x-input-label for="admission" value="Persyaratan Penerimaan" />
                                <textarea id="admission" name="admission" rows="3" class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm focus:border-[#1b3985] focus:ring-[#1b3985]">{{ old('admission', $data['admission']) }}</textarea>
                            </div>
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <x-input-label for="languages" value="Bahasa Pengantar Kuliah" />
                                    <x-text-input id="languages" name="languages" class="mt-1 block w-full" :value="old('languages', $data['languages'])" />
                                </div>
                                <div>
                                    <x-input-label for="contact" value="Alamat & Kontak" />
                                    <textarea id="contact" name="contact" rows="3" class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm focus:border-[#1b3985] focus:ring-[#1b3985]">{{ old('contact', $data['contact']) }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-end gap-4 rounded-b-xl bg-gray-50/75 p-4">
                            <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-[#1b3985] px-4 py-2 text-sm font-semibold text-white">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>

                {{-- Tab: Narasi Dokumen SKPI --}}
                <div x-show="activeTab === 'narasi'" x-transition.opacity>
                    <form method="POST" action="{{ route('admin.system_settings.narratives') }}" class="rounded-xl border border-gray-100 bg-white shadow-sm">
                        <div class="p-6 border-b">
                            <h3 class="text-lg font-semibold text-gray-800">Narasi Dokumen SKPI</h3>
                            <p class="text-sm text-gray-500">Teks naratif yang menjelaskan sistem pendidikan dan KKNI.</p>
                        </div>
                        <div class="p-6 space-y-4">
                            @csrf
                            <div>
                                <x-input-label for="narasi_pt_id" value="Narasi Sistem Pendidikan Tinggi (ID)" />
                                <textarea id="narasi_pt_id" name="narasi_pt_id" rows="6" class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm focus:border-[#1b3985] focus:ring-[#1b3985]">{{ old('narasi_pt_id', $data['narasi_pt_id']) }}</textarea>
                            </div>
                            <div>
                                <x-input-label for="narasi_pt_en" value="Higher Education System Narrative (EN)" />
                                <textarea id="narasi_pt_en" name="narasi_pt_en" rows="6" class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm focus:border-[#1b3985] focus:ring-[#1b3985]">{{ old('narasi_pt_en', $data['narasi_pt_en']) }}</textarea>
                            </div>
                            <div>
                                <x-input-label for="narasi_kkni_id" value="Narasi KKNI (ID)" />
                                <textarea id="narasi_kkni_id" name="narasi_kkni_id" rows="6" class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm focus:border-[#1b3985] focus:ring-[#1b3985]">{{ old('narasi_kkni_id', $data['narasi_kkni_id']) }}</textarea>
                            </div>
                            <div>
                                <x-input-label for="narasi_kkni_en" value="KKNI Narrative (EN)" />
                                <textarea id="narasi_kkni_en" name="narasi_kkni_en" rows="6" class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm focus:border-[#1b3985] focus:ring-[#1b3985]">{{ old('narasi_kkni_en', $data['narasi_kkni_en']) }}</textarea>
                            </div>
                        </div>
                        <div class="flex items-center justify-end gap-4 rounded-b-xl bg-gray-50/75 p-4">
                            <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-[#1b3985] px-4 py-2 text-sm font-semibold text-white">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>

                {{-- Tab: Pengaturan Umum --}}
                <div x-show="activeTab === 'umum'" x-transition.opacity>
                    <form method="POST" action="{{ route('admin.system_settings.general') }}" enctype="multipart/form-data" class="rounded-xl border border-gray-100 bg-white shadow-sm">
                        <div class="p-6 border-b">
                            <h3 class="text-lg font-semibold text-gray-800">Pengaturan Umum</h3>
                            <p class="text-sm text-gray-500">Pengaturan umum aplikasi dan jadwal.</p>
                        </div>
                        <div class="p-6 space-y-6">
                            @csrf
                            <div>
                                <x-input-label for="logo" value="Logo Institusi" />
                                <input id="logo" type="file" name="logo" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>
                                @if($data['logo_path'])
                                    <div class="mt-4">
                                        <p class="text-sm text-gray-600">Logo saat ini:</p>
                                        <img src="{{ asset('storage/'.$data['logo_path']) }}" alt="Logo" class="mt-2 h-16 w-auto object-contain rounded-md border border-gray-200 p-1">
                                    </div>
                                @endif
                            </div>
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <div>
                                    <x-input-label for="portfolio_open" value="Mulai Pengisian Portofolio" />
                                    <x-text-input id="portfolio_open" name="portfolio_open" type="date" class="mt-1 block w-full" :value="old('portfolio_open', $data['portfolio_open'])" />
                                </div>
                                <div>
                                    <x-input-label for="portfolio_close" value="Selesai Pengisian Portofolio" />
                                    <x-text-input id="portfolio_close" name="portfolio_close" type="date" class="mt-1 block w-full" :value="old('portfolio_close', $data['portfolio_close'])" />
                                </div>
                            </div>
                            {{-- Maintenance Mode Toggle --}}
                            <div x-data="{ maintenance: {{ $data['maintenance'] ? 'true' : 'false' }} }" class="flex items-center justify-between rounded-lg border border-gray-200 p-4">
                                <div>
                                    <h4 class="font-medium text-gray-800">Mode Maintenance</h4>
                                    <p class="text-sm text-gray-500">Jika aktif, mahasiswa tidak bisa login atau mengakses dasbor.</p>
                                </div>
                                <div class="flex items-center">
                                    <input type="hidden" name="maintenance" :value="maintenance ? 1 : 0">
                                    <button type="button" @click="maintenance = !maintenance" :class="maintenance ? 'bg-[#1b3985]' : 'bg-gray-200'" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-[#1b3985] focus:ring-offset-2" role="switch" aria-checked="false">
                                        <span aria-hidden="true" :class="maintenance ? 'translate-x-5' : 'translate-x-0'" class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-end gap-4 rounded-b-xl bg-gray-50/75 p-4">
                            <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-[#1b3985] px-4 py-2 text-sm font-semibold text-white">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

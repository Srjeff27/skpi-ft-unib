<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">Pengaturan Sistem</h2>
        <p class="text-sm text-gray-500">Atur teks dan konfigurasi statis untuk dokumen SKPI dan aplikasi</p>
    </x-slot>

    <div class="pt-8 pb-16" x-data="{ tab: 'institusi' }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-100">
                <div class="p-4 sm:p-6">
                    <div class="flex items-center gap-2 text-sm">
                        <button class="px-3 py-2 rounded-md" :class="tab==='institusi' ? 'bg-[#1b3985] text-white' : 'bg-gray-100 text-gray-700'" @click="tab='institusi'">Informasi Institusi</button>
                        <button class="px-3 py-2 rounded-md" :class="tab==='narasi' ? 'bg-[#1b3985] text-white' : 'bg-gray-100 text-gray-700'" @click="tab='narasi'">Narasi Dokumen SKPI</button>
                        <button class="px-3 py-2 rounded-md" :class="tab==='umum' ? 'bg-[#1b3985] text-white' : 'bg-gray-100 text-gray-700'" @click="tab='umum'">Pengaturan Umum</button>
                    </div>

                    {{-- Tab: Informasi Institusi --}}
                    <div x-show="tab==='institusi'" class="mt-6">
                        <form method="POST" action="{{ route('admin.system_settings.institution') }}" class="space-y-4">
                            @csrf
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-xs text-gray-600">Nama Universitas</label>
                                    <input type="text" name="univ_name" value="{{ old('univ_name', $data['univ_name']) }}" required class="mt-1 w-full rounded-md border-gray-300" />
                                </div>
                                <div>
                                    <label class="text-xs text-gray-600">Nama Fakultas</label>
                                    <input type="text" name="faculty_name" value="{{ old('faculty_name', $data['faculty_name']) }}" required class="mt-1 w-full rounded-md border-gray-300" />
                                </div>
                            </div>
                            <div>
                                <label class="text-xs text-gray-600">SK Pendirian Perguruan Tinggi</label>
                                <input type="text" name="sk_pt" value="{{ old('sk_pt', $data['sk_pt']) }}" class="mt-1 w-full rounded-md border-gray-300" />
                            </div>
                            <div>
                                <label class="text-xs text-gray-600">Sistem Penilaian</label>
                                <textarea name="grading" rows="3" class="mt-1 w-full rounded-md border-gray-300">{{ old('grading', $data['grading']) }}</textarea>
                            </div>
                            <div>
                                <label class="text-xs text-gray-600">Persyaratan Penerimaan</label>
                                <textarea name="admission" rows="3" class="mt-1 w-full rounded-md border-gray-300">{{ old('admission', $data['admission']) }}</textarea>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-xs text-gray-600">Bahasa Pengantar Kuliah</label>
                                    <input type="text" name="languages" value="{{ old('languages', $data['languages']) }}" class="mt-1 w-full rounded-md border-gray-300" />
                                </div>
                                <div>
                                    <label class="text-xs text-gray-600">Alamat & Kontak</label>
                                    <textarea name="contact" rows="3" class="mt-1 w-full rounded-md border-gray-300">{{ old('contact', $data['contact']) }}</textarea>
                                </div>
                            </div>
                            <div class="pt-2"><button class="px-4 py-2 rounded-md bg-[#1b3985] text-white">Simpan Perubahan</button></div>
                        </form>
                    </div>

                    {{-- Tab: Narasi Dokumen SKPI --}}
                    <div x-show="tab==='narasi'" class="mt-6">
                        <form method="POST" action="{{ route('admin.system_settings.narratives') }}" class="space-y-4">
                            @csrf
                            <div>
                                <label class="text-xs text-gray-600">Narasi Sistem Pendidikan Tinggi (ID)</label>
                                <textarea name="narasi_pt_id" rows="6" class="mt-1 w-full rounded-md border-gray-300">{{ old('narasi_pt_id', $data['narasi_pt_id']) }}</textarea>
                            </div>
                            <div>
                                <label class="text-xs text-gray-600">Higher Education System Narrative (EN)</label>
                                <textarea name="narasi_pt_en" rows="6" class="mt-1 w-full rounded-md border-gray-300">{{ old('narasi_pt_en', $data['narasi_pt_en']) }}</textarea>
                            </div>
                            <div>
                                <label class="text-xs text-gray-600">Narasi KKNI (ID)</label>
                                <textarea name="narasi_kkni_id" rows="6" class="mt-1 w-full rounded-md border-gray-300">{{ old('narasi_kkni_id', $data['narasi_kkni_id']) }}</textarea>
                            </div>
                            <div>
                                <label class="text-xs text-gray-600">KKNI Narrative (EN)</label>
                                <textarea name="narasi_kkni_en" rows="6" class="mt-1 w-full rounded-md border-gray-300">{{ old('narasi_kkni_en', $data['narasi_kkni_en']) }}</textarea>
                            </div>
                            <div class="pt-2"><button class="px-4 py-2 rounded-md bg-[#1b3985] text-white">Simpan Perubahan</button></div>
                        </form>
                    </div>

                    {{-- Tab: Pengaturan Umum --}}
                    <div x-show="tab==='umum'" class="mt-6">
                        <form method="POST" action="{{ route('admin.system_settings.general') }}" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-end">
                                <div>
                                    <label class="text-xs text-gray-600">Logo Institusi</label>
                                    <input type="file" name="logo" accept="image/*" class="mt-1 w-full" />
                                    @if($data['logo_path'])
                                        <div class="text-xs text-gray-600 mt-2">Pratinjau:</div>
                                        <img src="{{ asset('storage/'.$data['logo_path']) }}" alt="Logo" class="h-16 object-contain">
                                    @endif
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-xs text-gray-600">Mulai Pengisian Portofolio</label>
                                        <input type="date" name="portfolio_open" value="{{ old('portfolio_open', $data['portfolio_open']) }}" class="mt-1 w-full rounded-md border-gray-300" />
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-600">Selesai Pengisian Portofolio</label>
                                        <input type="date" name="portfolio_close" value="{{ old('portfolio_close', $data['portfolio_close']) }}" class="mt-1 w-full rounded-md border-gray-300" />
                                    </div>
                                </div>
                            </div>
                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="maintenance" value="1" {{ $data['maintenance'] ? 'checked' : '' }} class="rounded border-gray-300">
                                Mode Maintenance (tutup akses mahasiswa)
                            </label>
                            <div class="pt-2"><button class="px-4 py-2 rounded-md bg-[#1b3985] text-white">Simpan Perubahan</button></div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

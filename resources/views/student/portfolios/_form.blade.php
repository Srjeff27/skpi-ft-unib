@php
    $isLocked = isset($portfolio) && !in_array($portfolio->status, ['pending', 'requires_revision']);
    
    // Kelas CSS standar untuk input agar konsisten
    $inputClass = "w-full rounded-xl border-slate-300 shadow-sm focus:border-[#1b3985] focus:ring-[#1b3985] pl-10 py-2.5 text-sm transition-all placeholder:text-slate-400";
    $disabledClass = "bg-slate-100 text-slate-500 cursor-not-allowed border-slate-200 focus:ring-0";
@endphp

<div class="space-y-8">
    
    {{-- Section 1: Informasi Utama --}}
    <div class="space-y-6">
        {{-- Judul Kegiatan --}}
        <div>
            <x-input-label for="judul_kegiatan" value="Judul Kegiatan" class="mb-1.5 text-slate-700 font-semibold" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <x-heroicon-o-bookmark class="h-5 w-5 text-slate-400" />
                </div>
                <x-text-input id="judul_kegiatan" name="judul_kegiatan" 
                    class="{{ $inputClass }} {{ $isLocked ? $disabledClass : '' }}"
                    :value="old('judul_kegiatan', $portfolio->judul_kegiatan ?? '')" 
                    :disabled="$isLocked" required
                    placeholder="Contoh: Lomba Cipta Puisi Nasional FT Fair UNIB 2025" />
            </div>
            <x-input-error :messages="$errors->get('judul_kegiatan')" class="mt-1" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Kategori --}}
            <div>
                <x-input-label for="kategori_portfolio" value="Kategori Portofolio" class="mb-1.5 text-slate-700 font-semibold" />
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <x-heroicon-o-tag class="h-5 w-5 text-slate-400" />
                    </div>
                    @if (($categories ?? collect())->count() > 0)
                        <select id="kategori_portfolio" name="kategori_portfolio" required {{ $isLocked ? 'disabled' : '' }}
                            class="{{ $inputClass }} {{ $isLocked ? $disabledClass : '' }} appearance-none">
                            <option value="" disabled selected>Pilih Kategori...</option>
                            @foreach ($categories ?? collect() as $cat)
                                <option value="{{ $cat }}" @selected(old('kategori_portfolio', $portfolio->kategori_portfolio ?? '') === $cat)>
                                    {{ $cat }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <x-heroicon-m-chevron-up-down class="h-4 w-4 text-slate-400" />
                        </div>
                    @else
                        <x-text-input id="kategori_portfolio" name="kategori_portfolio" 
                            class="{{ $inputClass }} {{ $isLocked ? $disabledClass : '' }}" 
                            :value="old('kategori_portfolio', $portfolio->kategori_portfolio ?? '')" 
                            :disabled="$isLocked"
                            placeholder="Tuliskan kategori secara manual" />
                    @endif
                </div>
                <x-input-error :messages="$errors->get('kategori_portfolio')" class="mt-1" />
            </div>

            {{-- Penyelenggara --}}
            <div>
                <x-input-label for="penyelenggara" value="Penyelenggara" class="mb-1.5 text-slate-700 font-semibold" />
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <x-heroicon-o-building-office-2 class="h-5 w-5 text-slate-400" />
                    </div>
                    <x-text-input id="penyelenggara" name="penyelenggara" 
                        class="{{ $inputClass }} {{ $isLocked ? $disabledClass : '' }}"
                        :value="old('penyelenggara', $portfolio->penyelenggara ?? '')" 
                        :disabled="$isLocked" required 
                        placeholder="Contoh: Universitas Bengkulu" />
                </div>
                <x-input-error :messages="$errors->get('penyelenggara')" class="mt-1" />
            </div>
        </div>
    </div>

    {{-- Separator --}}
    <div class="border-t border-slate-100"></div>

    {{-- Section 2: Detail Dokumen --}}
    <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Nama Dokumen ID --}}
            <div>
                <x-input-label for="nama_dokumen_id" class="mb-1.5 text-slate-700 font-semibold flex items-center gap-2">
                    Nama Dokumen <span class="text-[10px] bg-slate-100 text-slate-600 px-1.5 py-0.5 rounded border border-slate-200">Bahasa Indonesia</span>
                </x-input-label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="font-bold text-slate-400 text-xs">ID</span>
                    </div>
                    <x-text-input id="nama_dokumen_id" name="nama_dokumen_id" 
                        class="{{ $inputClass }}" 
                        :value="old('nama_dokumen_id', $portfolio->nama_dokumen_id ?? '')" 
                        :disabled="$isLocked" required
                        placeholder="Contoh: Juara 1 Lomba Cipta Puisi" />
                </div>
                <x-input-error :messages="$errors->get('nama_dokumen_id')" class="mt-1" />
            </div>

            {{-- Nama Dokumen EN --}}
            <div>
                <x-input-label for="nama_dokumen_en" class="mb-1.5 text-slate-700 font-semibold flex items-center gap-2">
                    Nama Dokumen <span class="text-[10px] bg-blue-50 text-blue-600 px-1.5 py-0.5 rounded border border-blue-100">Bahasa Inggris</span>
                </x-input-label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="font-bold text-slate-400 text-xs">EN</span>
                    </div>
                    <x-text-input id="nama_dokumen_en" name="nama_dokumen_en" 
                        class="{{ $inputClass }}" 
                        :value="old('nama_dokumen_en', $portfolio->nama_dokumen_en ?? '')" 
                        :disabled="$isLocked" required
                        placeholder="Example: 1st Place in a Poetry Contest" />
                </div>
                <x-input-error :messages="$errors->get('nama_dokumen_en')" class="mt-1" />
            </div>
        </div>

        {{-- Deskripsi --}}
        <div>
            <x-input-label for="deskripsi_kegiatan" value="Deskripsi Singkat" class="mb-1.5 text-slate-700 font-semibold" />
            <div class="relative">
                <textarea id="deskripsi_kegiatan" name="deskripsi_kegiatan" rows="4" {{ $isLocked ? 'disabled' : '' }} required
                    class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-[#1b3985] focus:ring-[#1b3985] p-3 text-sm transition-all placeholder:text-slate-400 {{ $isLocked ? $disabledClass : '' }}"
                    placeholder="Jelaskan peran, capaian, dan relevansi kegiatan secara singkat...">{{ old('deskripsi_kegiatan', $portfolio->deskripsi_kegiatan ?? '') }}</textarea>
                @if($isLocked)
                    <div class="absolute top-3 right-3 text-slate-400">
                        <x-heroicon-s-lock-closed class="h-4 w-4" />
                    </div>
                @endif
            </div>
            <x-input-error :messages="$errors->get('deskripsi_kegiatan')" class="mt-1" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Tanggal Dokumen --}}
            <div>
                <x-input-label for="tanggal_dokumen" value="Tanggal Sertifikat" class="mb-1.5 text-slate-700 font-semibold" />
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <x-heroicon-o-calendar-days class="h-5 w-5 text-slate-400" />
                    </div>
                    <x-text-input id="tanggal_dokumen" name="tanggal_dokumen" type="date" 
                        class="{{ $inputClass }} {{ $isLocked ? $disabledClass : '' }}"
                        :value="old('tanggal_dokumen', isset($portfolio) && $portfolio->tanggal_dokumen ? optional($portfolio->tanggal_dokumen)->format('Y-m-d') : '')" 
                        :disabled="$isLocked" required />
                </div>
                <x-input-error :messages="$errors->get('tanggal_dokumen')" class="mt-1" />
            </div>

            {{-- Nomor Dokumen --}}
            <div>
                <x-input-label for="nomor_dokumen" value="Nomor Dokumen (Opsional)" class="mb-1.5 text-slate-700 font-semibold" />
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <x-heroicon-o-hashtag class="h-5 w-5 text-slate-400" />
                    </div>
                    <x-text-input id="nomor_dokumen" name="nomor_dokumen" 
                        class="{{ $inputClass }} {{ $isLocked ? $disabledClass : '' }}"
                        :value="old('nomor_dokumen', $portfolio->nomor_dokumen ?? '')" 
                        :disabled="$isLocked"
                        placeholder="Contoh: 123/SK/FT/2024" />
                </div>
                <x-input-error :messages="$errors->get('nomor_dokumen')" class="mt-1" />
            </div>
        </div>
    </div>

    {{-- Separator --}}
    <div class="border-t border-slate-100"></div>

    {{-- Section 3: Bukti Pendukung --}}
    <div class="space-y-4">
        <div>
            <x-input-label for="link_sertifikat" value="Link Bukti Pendukung" class="mb-1.5 text-slate-700 font-semibold" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <x-heroicon-o-link class="h-5 w-5 text-slate-400" />
                </div>
                <x-text-input id="link_sertifikat" name="link_sertifikat" type="url" 
                    class="{{ $inputClass }} {{ $isLocked ? $disabledClass : '' }}"
                    :value="old('link_sertifikat', $portfolio->link_sertifikat ?? '')" 
                    :disabled="$isLocked"
                    placeholder="https://drive.google.com/..." />
            </div>
            <x-input-error :messages="$errors->get('link_sertifikat')" class="mt-1" />
        </div>

        <div>
            <x-input-label for="bukti_file" value="Upload Bukti (Opsional, PDF/JPG/PNG, maks 5MB)" class="mb-1.5 text-slate-700 font-semibold" />
            <input id="bukti_file" name="bukti_file" type="file" accept=".pdf,.jpg,.jpeg,.png"
                class="block w-full text-sm text-slate-700 border border-slate-200 rounded-lg cursor-pointer bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1b3985]"
                @if($isLocked) disabled @endif>
            <x-input-error :messages="$errors->get('bukti_file')" class="mt-1" />
        </div>
        
        {{-- Info Box --}}
        <div class="mt-1 flex gap-3 p-3 rounded-lg bg-blue-50 border border-blue-100 text-blue-800 text-xs">
            <x-heroicon-s-information-circle class="h-5 w-5 shrink-0" />
            <div class="space-y-1">
                <p class="font-semibold">Pilih salah satu: link publik atau unggah file.</p>
                <p>Jika memakai link cloud, pastikan aksesnya <strong>"Anyone with the link"</strong>. Jika mengunggah file, dokumen disimpan privat dan hanya dapat diakses saat login.</p>
            </div>
        </div>
    </div>
</div>

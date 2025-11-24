@php
    $isLocked = isset($portfolio) && $portfolio->status !== 'pending' && $portfolio->status !== 'requires_revision';
@endphp

<div class="p-6 sm:p-8 space-y-6">
    <div>
        <x-input-label for="judul_kegiatan" value="Judul Kegiatan" />
        <x-text-input id="judul_kegiatan" name="judul_kegiatan" class="mt-1 block w-full"
            :value="old('judul_kegiatan', $portfolio->judul_kegiatan ?? '')" :disabled="$isLocked" required
            placeholder="Contoh: Lomba Cipta Puisi Nasional FT Fair UNIB 2025" />
        <x-input-error :messages="$errors->get('judul_kegiatan')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="kategori_portfolio" value="Kategori Portofolio" />
        @if (($categories ?? collect())->count() > 0)
            <select id="kategori_portfolio" name="kategori_portfolio" required {{ $isLocked ? 'disabled' : '' }}
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:bg-gray-100">
                <option value="" disabled selected>- Pilih Kategori -</option>
                @foreach ($categories ?? collect() as $cat)
                    <option value="{{ $cat }}" @selected(old('kategori_portfolio', $portfolio->kategori_portfolio ?? '') === $cat)>
                        {{ $cat }}
                    </option>
                @endforeach
            </select>
        @else
            <x-text-input id="kategori_portfolio" name="kategori_portfolio" class="mt-1 block w-full" 
                :value="old('kategori_portfolio', $portfolio->kategori_portfolio ?? '')" :disabled="$isLocked"
                placeholder="Tuliskan kategori secara manual" />
            <p class="text-xs text-gray-500 mt-1">Admin belum menambahkan daftar kategori.</p>
        @endif
        <x-input-error :messages="$errors->get('kategori_portfolio')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="penyelenggara" value="Penyelenggara" />
        <x-text-input id="penyelenggara" name="penyelenggara" class="mt-1 block w-full"
            :value="old('penyelenggara', $portfolio->penyelenggara ?? '')" :disabled="$isLocked" required 
            placeholder="Contoh: Universitas Bengkulu" />
        <x-input-error :messages="$errors->get('penyelenggara')" class="mt-2" />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <x-input-label for="nama_dokumen_id" value="Nama Dokumen (ID)" />
            <x-text-input id="nama_dokumen_id" name="nama_dokumen_id" class="mt-1 block w-full"
                :value="old('nama_dokumen_id', $portfolio->nama_dokumen_id ?? '')" :disabled="$isLocked" required
                placeholder="Contoh: Juara 1 Lomba Cipta Puisi" />
            <x-input-error :messages="$errors->get('nama_dokumen_id')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="nama_dokumen_en" value="Nama Dokumen (EN)" />
            <x-text-input id="nama_dokumen_en" name="nama_dokumen_en" class="mt-1 block w-full"
                :value="old('nama_dokumen_en', $portfolio->nama_dokumen_en ?? '')" :disabled="$isLocked" required
                placeholder="Example: 1st Place in a Poetry Contest" />
            <x-input-error :messages="$errors->get('nama_dokumen_en')" class="mt-2" />
        </div>
    </div>

    <div>
        <x-input-label for="deskripsi_kegiatan" value="Deskripsi Singkat Kegiatan" />
        <textarea id="deskripsi_kegiatan" name="deskripsi_kegiatan" rows="4" :disabled="$isLocked" required
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:bg-gray-100"
            placeholder="Jelaskan secara singkat tentang kegiatan atau prestasi yang diraih...">{{ old('deskripsi_kegiatan', $portfolio->deskripsi_kegiatan ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('deskripsi_kegiatan')" class="mt-2" />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <x-input-label for="tanggal_dokumen" value="Tanggal Dokumen" />
            <x-text-input id="tanggal_dokumen" name="tanggal_dokumen" type="date" class="mt-1 block w-full"
                :value="old('tanggal_dokumen', isset($portfolio) && $portfolio->tanggal_dokumen ? optional($portfolio->tanggal_dokumen)->format('Y-m-d') : '')" 
                :disabled="$isLocked" required />
            <x-input-error :messages="$errors->get('tanggal_dokumen')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="nomor_dokumen" value="Nomor Dokumen (Opsional)" />
            <x-text-input id="nomor_dokumen" name="nomor_dokumen" class="mt-1 block w-full"
                :value="old('nomor_dokumen', $portfolio->nomor_dokumen ?? '')" :disabled="$isLocked"
                placeholder="Contoh: 123/SK/FT/2024" />
            <x-input-error :messages="$errors->get('nomor_dokumen')" class="mt-2" />
        </div>
    </div>

    <div>
        <x-input-label for="link_sertifikat" value="Link Sertifikat / Bukti Pendukung" />
        <x-text-input id="link_sertifikat" name="link_sertifikat" type="url" class="mt-1 block w-full"
            :value="old('link_sertifikat', $portfolio->link_sertifikat ?? '')" :disabled="$isLocked"
            placeholder="https://..." required />
        <p class="text-xs text-gray-500 mt-1">Wajib diisi. Pastikan link Google Drive sudah diatur **"Siapa saja yang memiliki link"**.</p>
        <x-input-error :messages="$errors->get('link_sertifikat')" class="mt-2" />
    </div>
</div>

<x-app-layout>
    <x-slot name="header">
        {{-- DIUBAH: Menambahkan padding agar header tidak mepet dengan navigasi --}}
        <div class="max-w-3xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            @php
                $hour = now()->timezone(config('app.timezone'))->format('H');
                $greet =
                    $hour < 11
                        ? 'Selamat Pagi'
                        : ($hour < 15
                            ? 'Selamat Siang'
                            : ($hour < 18
                                ? 'Selamat Sore'
                                : 'Selamat Malam'));
                $name = auth()->user()?->name ?? 'Pengguna';
            @endphp
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $greet }}, {{ $name }}!</h2>
            <p class="text-sm text-gray-500 mt-1">Lakukan perubahan pada data portofolio Anda di bawah ini.</p>
        </div>
    </x-slot>

    @php
        // Variabel untuk menentukan apakah form harus dikunci (disabled)
        $isLocked = $portfolio->status !== 'pending' && $portfolio->status !== 'requires_revision';
    @endphp

    {{-- DIUBAH: Menyesuaikan padding untuk mobile dan desktop --}}
    <div class="pt-6 pb-24 sm:pt-8 sm:pb-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl">
                <form method="POST" action="{{ route('student.portfolios.update', $portfolio) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="p-6 sm:p-8 space-y-6">
                        {{-- Pesan Peringatan jika data sudah tidak bisa diubah --}}
                        @if ($isLocked)
                            <div
                                class="flex items-start gap-3 rounded-lg border border-yellow-300 bg-yellow-50 p-4 text-yellow-900">
                                <x-heroicon-s-exclamation-triangle class="h-6 w-6 flex-shrink-0 text-yellow-500" />
                                <div>
                                    <h3 class="font-bold">Portofolio Dikunci</h3>
                                    <p class="text-sm mt-1">Portofolio dengan status
                                        **"{{ ucfirst($portfolio->status) }}"** tidak dapat diubah lagi. Anda hanya
                                        dapat melihat data atau menghapusnya.</p>
                                </div>
                            </div>
                        @endif

                        {{-- Pesan jika butuh perbaikan --}}
                        @if ($portfolio->status === 'requires_revision' && $portfolio->rejection_reason)
                            <div
                                class="flex items-start gap-3 rounded-lg border border-orange-300 bg-orange-50 p-4 text-orange-900">
                                <x-heroicon-s-information-circle class="h-6 w-6 flex-shrink-0 text-orange-500" />
                                <div>
                                    <h3 class="font-bold">Perlu Perbaikan</h3>
                                    <p class="text-sm mt-1">Verifikator meminta perbaikan dengan catatan: <br><span
                                            class="font-semibold italic">"{{ $portfolio->rejection_reason }}"</span></p>
                                </div>
                            </div>
                        @endif

                        {{-- Input Fields --}}
                        <div>
                            <x-input-label for="judul_kegiatan" value="Judul Kegiatan" />
                            <x-text-input id="judul_kegiatan" name="judul_kegiatan" class="mt-1 block w-full"
                                :value="old('judul_kegiatan', $portfolio->judul_kegiatan)" :disabled="$isLocked" required />
                            <x-input-error :messages="$errors->get('judul_kegiatan')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="kategori_portfolio" value="Kategori Portofolio" />
                            @if (($categories ?? collect())->count() > 0)
                                <select id="kategori_portfolio" name="kategori_portfolio"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:bg-gray-100 disabled:text-gray-500"
                                    {{ $isLocked ? 'disabled' : '' }}>
                                    <option value="">- Pilih Kategori -</option>
                                    @foreach ($categories ?? collect() as $cat)
                                        <option value="{{ $cat }}" @selected(old('kategori_portfolio', $portfolio->kategori_portfolio) === $cat)>
                                            {{ $cat }}
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                <x-text-input id="kategori_portfolio" name="kategori_portfolio"
                                    class="mt-1 block w-full" :value="old('kategori_portfolio', $portfolio->kategori_portfolio)" :disabled="$isLocked" />
                                <p class="text-xs text-gray-500 mt-1">Admin belum menambahkan daftar kategori. Isikan
                                    kategori secara manual.</p>
                            @endif
                            <x-input-error :messages="$errors->get('kategori_portfolio')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="penyelenggara" value="Penyelenggara" />
                            <x-text-input id="penyelenggara" name="penyelenggara" class="mt-1 block w-full"
                                :value="old('penyelenggara', $portfolio->penyelenggara)" :disabled="$isLocked" required />
                            <x-input-error :messages="$errors->get('penyelenggara')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="nama_dokumen_id" value="Nama Dokumen (ID)" />
                                <x-text-input id="nama_dokumen_id" name="nama_dokumen_id" class="mt-1 block w-full"
                                    :value="old('nama_dokumen_id', $portfolio->nama_dokumen_id ?? '')" :disabled="$isLocked"
                                    placeholder="Contoh: Juara 1 Lomba Cipta Puisi" />
                                <x-input-error :messages="$errors->get('nama_dokumen_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="nama_dokumen_en" value="Nama Dokumen (EN)" />
                                <x-text-input id="nama_dokumen_en" name="nama_dokumen_en" class="mt-1 block w-full"
                                    :value="old('nama_dokumen_en', $portfolio->nama_dokumen_en ?? '')" :disabled="$isLocked"
                                    placeholder="Example: 1st Place in a Poetry Contest" />
                                <x-input-error :messages="$errors->get('nama_dokumen_en')" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="tanggal_dokumen" value="Tanggal Dokumen" />
                                <x-text-input id="tanggal_dokumen" name="tanggal_dokumen" type="date"
                                    class="mt-1 block w-full" :value="old('tanggal_dokumen', $portfolio->tanggal_dokumen)" :disabled="$isLocked" required />
                                <x-input-error :messages="$errors->get('tanggal_dokumen')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="nomor_dokumen" value="Nomor Dokumen (Opsional)" />
                                <x-text-input id="nomor_dokumen" name="nomor_dokumen" type="text"
                                    class="mt-1 block w-full" :value="old('nomor_dokumen', $portfolio->nomor_dokumen)" :disabled="$isLocked" />
                                <x-input-error :messages="$errors->get('nomor_dokumen')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="deskripsi_kegiatan" value="Deskripsi Singkat Kegiatan" />
                            <textarea id="deskripsi_kegiatan" name="deskripsi_kegiatan" rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:bg-gray-100 disabled:text-gray-500"
                                {{ $isLocked ? 'disabled' : '' }}>{{ old('deskripsi_kegiatan', $portfolio->deskripsi_kegiatan) }}</textarea>
                            <x-input-error :messages="$errors->get('deskripsi_kegiatan')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="link_sertifikat" value="Link Sertifikat / Bukti Pendukung" />
                            <x-text-input id="link_sertifikat" name="link_sertifikat" type="url"
                                class="mt-1 block w-full" :value="old('link_sertifikat', $portfolio->link_sertifikat)" :disabled="$isLocked"
                                placeholder="https://..." required />
                            <p class="text-xs text-gray-500 mt-1">Pastikan link Google Drive sudah diatur **"Siapa saja
                                yang memiliki link"** agar dapat diakses oleh verifikator.</p>
                            <x-input-error :messages="$errors->get('link_sertifikat')" class="mt-2" />
                        </div>
                    </div>

                    {{-- DIUBAH: Area tombol aksi dibuat responsif dan lebih aman --}}
                    <div
                        class="bg-gray-50 px-6 py-4 flex flex-col-reverse sm:flex-row sm:items-center sm:justify-between gap-4 rounded-b-xl">
                        {{-- Aksi Destruktif (Hapus) --}}
                        <form action="{{ route('student.portfolios.destroy', $portfolio) }}" method="POST"
                            onsubmit="return confirm('Anda yakin ingin menghapus portofolio ini? Tindakan ini tidak dapat dibatalkan.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full sm:w-auto inline-flex items-center justify-center rounded-md text-sm font-semibold text-red-600 hover:bg-red-50 px-3 py-2 transition-colors">
                                <x-heroicon-o-trash class="w-5 h-5 mr-2" />
                                Hapus Portofolio
                            </button>
                        </form>

                        {{-- Aksi Utama (Simpan & Kembali) --}}
                        <div class="flex items-center gap-4 flex-col-reverse sm:flex-row">
                            <a href="{{ route('student.portfolios.index') }}"
                                class="w-full sm:w-auto inline-flex justify-center rounded-md text-sm font-semibold text-gray-700 hover:bg-gray-200 px-4 py-2 transition-colors border border-gray-300 bg-white">
                                Kembali
                            </a>
                            <x-primary-button :disabled="$isLocked">
                                <x-heroicon-o-check-circle class="w-5 h-5 mr-2" />
                                {{ __('Simpan Perubahan') }}
                            </x-primary-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

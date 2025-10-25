<x-app-layout>
    <x-slot name="header">
        {{-- DIUBAH: Menambahkan padding agar header tidak mepet --}}
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
            <p class="text-sm text-gray-500 mt-1">
                {{ isset($portfolio) ? 'Edit Portofolio Anda' : 'Upload Portofolio Baru' }}</p>
        </div>
    </x-slot>

    {{-- DIUBAH: Menyesuaikan padding untuk mobile dan desktop --}}
    <div class="pt-6 pb-24 sm:pt-8 sm:pb-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            @if ($errors->any())
                <x-toast type="error" :message="$errors->first('general') ?? 'Gagal mengunggah portofolio. Periksa isian Anda.'" />
            @endif
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl">
                <form method="POST"
                    action="{{ isset($portfolio) ? route('student.portfolios.update', $portfolio) : route('student.portfolios.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    @if (isset($portfolio))
                        @method('PUT')
                    @endif

                    <div class="p-6 sm:p-8 space-y-6">
                        {{-- Input Fields --}}
                        <div>
                            <x-input-label for="judul_kegiatan" value="Judul Kegiatan" />
                            <x-text-input id="judul_kegiatan" name="judul_kegiatan" class="mt-1 block w-full"
                                :value="old('judul_kegiatan', $portfolio->judul_kegiatan ?? '')" required
                                placeholder="Contoh: Lomba Cipta Puisi Nasional FT Fair UNIB 2025" />
                            <x-input-error :messages="$errors->get('judul_kegiatan')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="kategori_portfolio" value="Kategori Portofolio" />
                            @if (($categories ?? collect())->count() > 0)
                                <select id="kategori_portfolio" name="kategori_portfolio" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="" disabled selected>- Pilih Kategori -</option>
                                    @foreach ($categories ?? collect() as $cat)
                                        <option value="{{ $cat }}" @selected(old('kategori_portfolio', $portfolio->kategori_portfolio ?? '') === $cat)>
                                            {{ $cat }}
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                <x-text-input id="kategori_portfolio" name="kategori_portfolio"
                                    class="mt-1 block w-full" :value="old('kategori_portfolio', $portfolio->kategori_portfolio ?? '')"
                                    placeholder="Tuliskan kategori secara manual" />
                                <p class="text-xs text-gray-500 mt-1">Admin belum menambahkan daftar kategori.</p>
                            @endif
                            <x-input-error :messages="$errors->get('kategori_portfolio')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="penyelenggara" value="Penyelenggara" />
                            <x-text-input id="penyelenggara" name="penyelenggara" class="mt-1 block w-full"
                                :value="old('penyelenggara', $portfolio->penyelenggara ?? '')" required placeholder="Contoh: Universitas Bengkulu" />
                            <x-input-error :messages="$errors->get('penyelenggara')" class="mt-2" />
                        </div>

                        {{-- DIUBAH: Mengelompokkan input nama dokumen agar responsif --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="nama_dokumen_id" value="Nama Dokumen (ID)" />
                                <x-text-input id="nama_dokumen_id" name="nama_dokumen_id" class="mt-1 block w-full"
                                    :value="old('nama_dokumen_id', $portfolio->nama_dokumen_id ?? '')" placeholder="Contoh: Juara 1 Lomba Cipta Puisi Nasional FT Fair UNIB 2025" />
                                <x-input-error :messages="$errors->get('nama_dokumen_id')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="nama_dokumen_en" value="Nama Dokumen (EN)" />
                                <x-text-input id="nama_dokumen_en" name="nama_dokumen_en" class="mt-1 block w-full"
                                    :value="old('nama_dokumen_en', $portfolio->nama_dokumen_en ?? '')" placeholder="Example: 1st Place in the 2025 FT Fair UNIB National Poetry Writing Competition" />
                                <x-input-error :messages="$errors->get('nama_dokumen_en')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="deskripsi_kegiatan" value="Deskripsi Singkat Kegiatan" />
                            <textarea id="deskripsi_kegiatan" name="deskripsi_kegiatan" rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Jelaskan secara singkat tentang kegiatan atau prestasi yang diraih...">{{ old('deskripsi_kegiatan', $portfolio->deskripsi_kegiatan ?? '') }}</textarea>
                            <x-input-error :messages="$errors->get('deskripsi_kegiatan')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="tanggal_dokumen" value="Tanggal Dokumen" />
                                <x-text-input id="tanggal_dokumen" name="tanggal_dokumen" type="date"
                                    class="mt-1 block w-full" :value="old('tanggal_dokumen', isset($portfolio) && $portfolio->tanggal_dokumen ? optional($portfolio->tanggal_dokumen)->format('Y-m-d') : '')" required />
                                <x-input-error :messages="$errors->get('tanggal_dokumen')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="nomor_dokumen" value="Nomor Dokumen (Opsional)" />
                                <x-text-input id="nomor_dokumen" name="nomor_dokumen" class="mt-1 block w-full"
                                    :value="old('nomor_dokumen', $portfolio->nomor_dokumen ?? '')" placeholder="Contoh: 123/SK/FT/2024" />
                                <x-input-error :messages="$errors->get('nomor_dokumen')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="link_sertifikat" value="Link Sertifikat / Bukti Pendukung" />
                            <x-text-input id="link_sertifikat" name="link_sertifikat" type="url"
                                class="mt-1 block w-full" :value="old('link_sertifikat', $portfolio->link_sertifikat ?? '')" placeholder="https://..." required />
                            <p class="text-xs text-gray-500 mt-1">Wajib diisi. Pastikan link Google Drive sudah diatur
                                **"Siapa saja yang memiliki link"**.</p>
                            <x-input-error :messages="$errors->get('link_sertifikat')" class="mt-2" />
                        </div>

                        <div class="pt-2">
                            <div class="rounded-lg bg-blue-50 p-4 text-sm text-blue-800 border border-blue-200">
                                <p class="font-bold mb-1">Informasi Penting!</p>
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Jika tidak memiliki sertifikat, Anda dapat mengunggah surat tugas, SK, atau
                                        dokumen valid lainnya.</li>
                                    <li>Hanya portofolio yang lolos verifikasi yang akan ditampilkan pada dokumen SKPI
                                        akhir.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- DIUBAH: Area tombol aksi dibuat responsif --}}
                    <div
                        class="bg-gray-50 px-6 py-4 flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-4 rounded-b-xl">
                        <a href="{{ route('student.portfolios.index') }}"
                            class="w-full sm:w-auto inline-flex justify-center rounded-md text-sm font-semibold text-gray-700 hover:bg-gray-200 px-4 py-2 transition-colors border border-gray-300 bg-white shadow-sm">
                            {{ __('Batal') }}
                        </a>
                        <x-primary-button class="w-full sm:w-auto inline-flex justify-center">
                            <x-heroicon-o-check-circle class="w-5 h-5 mr-2" />
                            {{ isset($portfolio) ? 'Simpan Perubahan' : 'Upload Portofolio' }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

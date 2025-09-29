<x-app-layout>
    <x-slot name="header">
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
        <h2 class="font-semibold text-xl text-gray-900 leading-tight">{{ $greet }}, {{ $name }}</h2>
        <p class="text-sm text-gray-500">{{ isset($portfolio) ? 'Edit Portofolio' : 'Upload Portofolio' }}</p>
    </x-slot>

    {{-- DIUBAH: Padding bawah ditambahkan untuk menghindari tumpang tindih dengan nav mobile --}}
    <div class="pt-8 pb-24 md:pb-8">
        {{-- DIUBAH: Padding horizontal ditambahkan untuk mobile --}}
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 sm:p-8 text-gray-900">
                    <form method="POST"
                        action="{{ isset($portfolio) ? route('student.portfolios.update', $portfolio) : route('student.portfolios.store') }}"
                        class="space-y-6" enctype="multipart/form-data">
                        @csrf
                        @if (isset($portfolio))
                            @method('PUT')
                        @endif

                        <div>
                            <x-input-label for="judul_kegiatan" :value="__('Judul Kegiatan')" />
                            <x-text-input id="judul_kegiatan" name="judul_kegiatan" class="mt-1 block w-full"
                                :value="old('judul_kegiatan')" required placeholder="Contoh: FT FAIR 2024"/>
                            <x-input-error :messages="$errors->get('judul_kegiatan')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="kategori_portfolio" :value="__('Kategori Portofolio')" />
                            @if(($categories ?? collect())->count() > 0)
                                <select id="kategori_portfolio" name="kategori_portfolio"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">- Pilih Kategori -</option>
                                    @foreach(($categories ?? collect()) as $cat)
                                        <option value="{{ $cat }}" @selected(old('kategori_portfolio')===$cat)>{{ $cat }}</option>
                                    @endforeach
                                </select>
                            @else
                                <x-text-input id="kategori_portfolio" name="kategori_portfolio" class="mt-1 block w-full" :value="old('kategori_portfolio')" placeholder="Tuliskan kategori" />
                                <p class="text-xs text-gray-500 mt-1">Admin belum menambahkan daftar kategori. Isikan kategori secara manual.</p>
                            @endif
                            <x-input-error :messages="$errors->get('kategori_portfolio')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="penyelenggara" :value="__('Penyelenggara')" />
                            <x-text-input id="penyelenggara" name="penyelenggara" class="mt-1 block w-full"
                                :value="old('penyelenggara')" required placeholder="Contoh: Universitas XYZ"/>
                            <x-input-error :messages="$errors->get('penyelenggara')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="nama_dokumen_id" :value="__('Nama Dokumen (ID)')" />
                            <x-text-input id="nama_dokumen_id" name="nama_dokumen_id" class="mt-1 block w-full"
                                :value="old('nama_dokumen_id', $portfolio->nama_dokumen_id ?? '')" placeholder="Contoh: Penghargaan Juara 1 Lomba Ngoding FT UNIB Fair 2024"/>
                            <x-input-error :messages="$errors->get('nama_dokumen_id')" class="mt-2"/>
                        </div>

                        <div>
                            <x-input-label for="nama_dokumen_en" :value="__('Nama Dokumen (EN)')" />
                            <x-text-input id="nama_dokumen_en" name="nama_dokumen_en" class="mt-1 block w-full"
                                :value="old('nama_dokumen_en', $portfolio->nama_dokumen_en ?? '')" placeholder="Example: 1st Place in the 2024 UNIB Fair FT Coding Competition"/>
                            <x-input-error :messages="$errors->get('nama_dokumen_en')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="deskripsi_kegiatan" :value="__('Deskripsi Singkat Kegiatan')" />
                            <textarea id="deskripsi_kegiatan" name="deskripsi_kegiatan" rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Contoh: Mengikuti Lomba Coding FT UNIB 2024">{{ old('deskripsi_kegiatan') }}</textarea>
                            <x-input-error :messages="$errors->get('deskripsi_kegiatan')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="tanggal_dokumen" :value="__('Tanggal Dokumen')" />
                                <x-text-input id="tanggal_dokumen" name="tanggal_dokumen" type="date" class="mt-1 block w-full"
                                    :value="old('tanggal_dokumen')" required />
                                <x-input-error :messages="$errors->get('tanggal_dokumen')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="nomor_dokumen" :value="__('Nomor Dokumen (opsional)')" />
                                <x-text-input id="nomor_dokumen" name="nomor_dokumen" class="mt-1 block w-full"
                                    :value="old('nomor_dokumen')" placeholder="Contoh: 123/SK/FT/2024" />
                                <x-input-error :messages="$errors->get('nomor_dokumen')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="link_sertifikat" :value="__('Link Sertifikat')" />
                            <x-text-input id="link_sertifikat" name="link_sertifikat" type="url" class="mt-1 block w-full"
                                :value="old('link_sertifikat')" placeholder="https://..." required />
                            <p class="text-xs text-gray-500 mt-1">Wajib diisi. Pastikan link Google Drive sudah diatur sebagai publik agar dapat diakses oleh verifikator.</p>
                            <x-input-error :messages="$errors->get('link_sertifikat')" class="mt-2" />
                        </div>

                        <div class="mt-4 rounded-md bg-blue-50 p-4 text-sm text-blue-700">
                            <p class="font-bold">Info!</p>
                            <ul class="mt-1 list-disc list-inside space-y-1">
                                <li>Jika Anda tidak memiliki sertifikat, silahkan unggah surat tugas atau dokumen lain yang dapat memvalidasi Portofolio Anda.</li>
                                <li>Tidak semua prestasi akan ditampilkan pada SKPI, hanya data yang lolos validasi oleh verifikator yang akan ditampilkan.</li>
                            </ul>
                        </div>

                        <div class="pt-2 flex items-center gap-3">
                            <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                            <a href="{{ route('student.portfolios.index') }}"
                                class="text-sm text-gray-600 hover:text-gray-900">{{ __('Batal') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

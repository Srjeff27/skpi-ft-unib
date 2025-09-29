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
        <p class="text-sm text-gray-500">Edit Portofolio</p>
    </x-slot>

    @php
        // Variabel untuk menentukan apakah form harus dikunci (disabled)
        $isLocked = $portfolio->status !== 'pending';
    @endphp

    {{-- DIUBAH: Padding bawah ditambahkan untuk menghindari tumpang tindih dengan nav mobile --}}
    <div class="pt-8 pb-24 md:pb-8">
        {{-- DIUBAH: Padding horizontal ditambahkan untuk mobile --}}
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 sm:p-8 text-gray-900">

                    {{-- Pesan Peringatan jika data sudah tidak bisa diubah --}}
                    @if ($isLocked)
                        <div
                            class="mb-6 flex items-start gap-3 rounded-lg border border-yellow-200 bg-yellow-50 p-4 text-yellow-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M8.257 3.099c.636-1.21 2.27-1.21 2.906 0l4.25 8.103c.636 1.21-.213 2.748-1.453 2.748H5.46c-1.24 0-2.089-1.538-1.453-2.748l4.25-8.103zM10 6a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 6zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                    clip-rule="evenodd" />
                            </svg>
                            <div>
                                <h3 class="font-semibold">Portofolio Dikunci</h3>
                                <p class="text-sm">Portofolio dengan status "{{ ucfirst($portfolio->status) }}" tidak
                                    dapat diubah lagi.</p>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('student.portfolios.update', $portfolio) }}" class="space-y-6"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="judul_kegiatan" :value="__('Judul Kegiatan')" />
                            <x-text-input id="judul_kegiatan" name="judul_kegiatan" class="mt-1 block w-full"
                                :value="old('judul_kegiatan', $portfolio->judul_kegiatan)" :disabled="$isLocked" required />
                            <x-input-error :messages="$errors->get('judul_kegiatan')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="kategori_portfolio" :value="__('Kategori Portofolio')" />
                            @if (($categories ?? collect())->count() > 0)
                                <select id="kategori_portfolio" name="kategori_portfolio"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:bg-gray-50"
                                    :disabled="$isLocked">
                                    <option value="">- Pilih Kategori -</option>
                                    @foreach ($categories ?? collect() as $cat)
                                        <option value="{{ $cat }}" @selected(old('kategori_portfolio', $portfolio->kategori_portfolio) === $cat)>
                                            {{ $cat }}</option>
                                    @endforeach
                                </select>
                            @else
                                <x-text-input id="kategori_portfolio" name="kategori_portfolio" class="mt-1 block w-full" :value="old('kategori_portfolio', $portfolio->kategori_portfolio)"
                                    :disabled="$isLocked" />
                                <p class="text-xs text-gray-500 mt-1">Admin belum menambahkan daftar kategori. Isikan
                                    kategori secara manual.</p>
                            @endif
                            <x-input-error :messages="$errors->get('kategori_portfolio')" class="mt-2" />
                        </div>

                        <!-- Field tingkat telah dihapus sesuai dengan perubahan struktur tabel -->

                        <div>
                            <x-input-label for="penyelenggara" :value="__('Penyelenggara')" />
                            <x-text-input id="penyelenggara" name="penyelenggara" class="mt-1 block w-full"
                                :value="old('penyelenggara', $portfolio->penyelenggara)" :disabled="$isLocked" required />
                            <x-input-error :messages="$errors->get('penyelenggara')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="nama_dokumen_id" :value="__('Nama Dokumen (ID)')" />
                            <x-text-input id="nama_dokumen_id" name="nama_dokumen_id" class="mt-1 block w-full"
                                :value="old('nama_dokumen_id', $portfolio->nama_dokumen_id ?? '')" :disabled="$isLocked"
                                placeholder="Contoh: Penghargaan Juara 1 Lomba Ngoding FT UNIB Fair 2024" />
                            <x-input-error :messages="$errors->get('nama_dokumen_id')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="nama_dokumen_en" :value="__('Nama Dokumen (EN)')" />
                            <x-text-input id="nama_dokumen_en" name="nama_dokumen_en" class="mt-1 block w-full"
                                :value="old('nama_dokumen_en', $portfolio->nama_dokumen_en ?? '')" :disabled="$isLocked"
                                placeholder="Example: 1st Place in the 2024 UNIB Fair FT Coding Competition" />
                            <x-input-error :messages="$errors->get('nama_dokumen_en')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="tanggal_dokumen" :value="__('Tanggal Dokumen')" />
                                <x-text-input id="tanggal_dokumen" name="tanggal_dokumen" type="date"
                                    class="mt-1 block w-full" :value="old(
                                        'tanggal_dokumen',
                                        $portfolio->tanggal_dokumen,
                                    )" :disabled="$isLocked" required />
                                <x-input-error :messages="$errors->get('tanggal_dokumen')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="nomor_dokumen" :value="__('Nomor Dokumen')" />
                                <x-text-input id="nomor_dokumen" name="nomor_dokumen" type="text"
                                    class="mt-1 block w-full" :value="old('nomor_dokumen', $portfolio->nomor_dokumen)" :disabled="$isLocked" />
                                <x-input-error :messages="$errors->get('nomor_dokumen')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="deskripsi_kegiatan" :value="__('Deskripsi Singkat Kegiatan')" />
                            <textarea id="deskripsi_kegiatan" name="deskripsi_kegiatan" rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:bg-gray-50"
                                :disabled="$isLocked">{{ old('deskripsi_kegiatan', $portfolio->deskripsi_kegiatan) }}</textarea>
                            <x-input-error :messages="$errors->get('deskripsi_kegiatan')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="link_sertifikat" :value="__('Link Sertifikat')" />
                            <x-text-input id="link_sertifikat" name="link_sertifikat" type="url" class="mt-1 block w-full"
                                :value="old('link_sertifikat', $portfolio->link_sertifikat)" :disabled="$isLocked" placeholder="https://..." required />
                            <p class="text-xs text-gray-500 mt-1">Wajib diisi. Pastikan link Google Drive sudah diatur sebagai publik agar dapat diakses oleh verifikator.</p>
                            <x-input-error :messages="$errors->get('link_sertifikat')" class="mt-2" />
                        </div>

                        <div class="mt-4 rounded-md bg-blue-50 p-4 text-sm text-blue-700">
                            <p class="font-bold">Info!</p>
                            <ul class="mt-1 list-disc list-inside space-y-1">
                                <li>Jika Anda tidak memiliki sertifikat, silahkan unggah surat tugas atau dokumen lain
                                    yang dapat memvalidasi Portofolio Anda.</li>
                                <li>Tidak semua prestasi akan ditampilkan pada SKPI, hanya data yang lolos validasi oleh
                                    verifikator yang akan ditampilkan.</li>
                            </ul>
                        </div>

                        <div class="pt-2 flex items-center gap-4">
                            @if (!$isLocked)
                                <x-primary-button>{{ __('Simpan Perubahan') }}</x-primary-button>
                            @endif
                            <form action="{{ route('student.portfolios.destroy', $portfolio) }}" method="POST"
                                onsubmit="return confirm('Anda yakin ingin menghapus portofolio ini? Tindakan ini tidak dapat dibatalkan.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center rounded-md border border-red-300 px-3 py-2 text-sm font-medium text-red-700 hover:bg-red-50">
                                    Hapus
                                </button>
                            </form>
                            <a href="{{ route('student.portfolios.index') }}"
                                class="text-sm text-gray-600 hover:text-gray-900">{{ __('Kembali') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

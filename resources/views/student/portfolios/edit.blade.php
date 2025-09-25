<x-app-layout>
    <x-slot name="header">
        @php
            $hour = now()->timezone(config('app.timezone'))->format('H');
            $greet = $hour < 11 ? 'Selamat Pagi' : ($hour < 15 ? 'Selamat Siang' : ($hour < 18 ? 'Selamat Sore' : 'Selamat Malam'));
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
                        <div class="mb-6 flex items-start gap-3 rounded-lg border border-yellow-200 bg-yellow-50 p-4 text-yellow-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.636-1.21 2.27-1.21 2.906 0l4.25 8.103c.636 1.21-.213 2.748-1.453 2.748H5.46c-1.24 0-2.089-1.538-1.453-2.748l4.25-8.103zM10 6a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 6zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                            </svg>
                            <div>
                                <h3 class="font-semibold">Portofolio Dikunci</h3>
                                <p class="text-sm">Portofolio dengan status "{{ ucfirst($portfolio->status) }}" tidak dapat diubah lagi.</p>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('student.portfolios.update', $portfolio) }}" class="space-y-6" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="judul_kegiatan" :value="__('Judul Kegiatan')" />
                            <x-text-input id="judul_kegiatan" name="judul_kegiatan" class="mt-1 block w-full" :value="old('judul_kegiatan', $portfolio->judul_kegiatan)" :disabled="$isLocked" required />
                            <x-input-error :messages="$errors->get('judul_kegiatan')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="kategori_portfolio" :value="__('Kategori')" />
                            <x-text-input id="kategori" name="kategori" class="mt-1 block w-full" :value="old('kategori', $portfolio->kategori)" :disabled="$isLocked" required />
                            <x-input-error :messages="$errors->get('kategori')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="tingkat" :value="__('Tingkat Kegiatan')" />
                            <select id="tingkat" name="tingkat" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:bg-gray-50" :disabled="$isLocked">
                                <option value="">- Pilih Tingkat -</option>
                                <option value="regional" @selected(old('tingkat', $portfolio->tingkat) === 'regional')>Regional</option>
                                <option value="nasional" @selected(old('tingkat', $portfolio->tingkat) === 'nasional')>Nasional</option>
                                <option value="internasional" @selected(old('tingkat', $portfolio->tingkat) === 'internasional')>Internasional</option>
                            </select>
                            <x-input-error :messages="$errors->get('tingkat')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="penyelenggara" :value="__('Penyelenggara')" />
                            <x-text-input id="penyelenggara" name="penyelenggara" class="mt-1 block w-full" :value="old('penyelenggara', $portfolio->penyelenggara)" :disabled="$isLocked" required />
                            <x-input-error :messages="$errors->get('penyelenggara')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="tanggal_mulai" :value="__('Tanggal Mulai')" />
                                <x-text-input id="tanggal_mulai" type="date" name="tanggal_mulai" class="mt-1 block w-full" :value="old('tanggal_mulai', $portfolio->tanggal_mulai)" :disabled="$isLocked" required />
                                <x-input-error :messages="$errors->get('tanggal_mulai')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="tanggal_selesai" :value="__('Tanggal Selesai (Opsional)')" />
                                <x-text-input id="tanggal_selesai" type="date" name="tanggal_selesai" class="mt-1 block w-full" :value="old('tanggal_selesai', $portfolio->tanggal_selesai)" :disabled="$isLocked" />
                                <x-input-error :messages="$errors->get('tanggal_selesai')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="deskripsi_kegiatan" :value="__('Deskripsi Singkat Kegiatan')" />
                            <textarea id="deskripsi_kegiatan" name="deskripsi_kegiatan" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:bg-gray-50" :disabled="$isLocked">{{ old('deskripsi_kegiatan', $portfolio->deskripsi_kegiatan) }}</textarea>
                            <x-input-error :messages="$errors->get('deskripsi_kegiatan')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="link_sertifikat" :value="__('Ganti Sertifikat (PDF, JPG, PNG)')" />
                            <input id="bukti_file" type="file" name="bukti_file" accept=".pdf,image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-[#fa7516] hover:file:bg-orange-100" :disabled="$isLocked" />
                            <p class="text-xs text-gray-500 mt-1">Ukuran maks 2MB. Kosongkan jika tidak ingin mengubah bukti yang sudah ada.</p>
                            <x-input-error :messages="$errors->get('bukti_file')" class="mt-2" />
                        </div>

                        <div class="pt-2 flex items-center gap-4">
                            @if (!$isLocked)
                                <x-primary-button>{{ __('Simpan Perubahan') }}</x-primary-button>
                            @endif
                            <a href="{{ route('student.portfolios.index') }}" class="text-sm text-gray-600 hover:text-gray-900">{{ __('Kembali') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

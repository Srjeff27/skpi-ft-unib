<x-app-layout>
    <x-slot name="header">
        @php
            $hour = now()->timezone(config('app.timezone'))->format('H');
            $greet = $hour < 11 ? 'Selamat Pagi' : ($hour < 15 ? 'Selamat Siang' : ($hour < 18 ? 'Selamat Sore' : 'Selamat Malam'));
            $name = auth()->user()?->name ?? 'Pengguna';
        @endphp
        <h2 class="font-semibold text-xl text-gray-900 leading-tight">{{ $greet }}, {{ $name }}</h2>
        <p class="text-sm text-gray-500">Upload Portofolio</p>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('student.portfolios.store') }}" class="space-y-4" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label class="block text-sm text-gray-900">Judul Kegiatan</label>
                            <input name="judul_kegiatan" value="{{ old('judul_kegiatan') }}" required class="mt-1 w-full rounded-md border-gray-300 focus:border-[#1b3985] focus:ring-[#1b3985]"/>
                            @error('judul_kegiatan')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label class="block text-sm text-gray-900">Kategori</label>
                            <input name="kategori" value="{{ old('kategori') }}" required class="mt-1 w-full rounded-md border-gray-300 focus:border-[#1b3985] focus:ring-[#1b3985]"/>
                            @error('kategori')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label class="block text-sm text-gray-900">Tingkat Kegiatan</label>
                            <select name="tingkat" class="mt-1 w-full rounded-md border-gray-300 focus:border-[#1b3985] focus:ring-[#1b3985]">
                                <option value="">- Pilih Tingkat -</option>
                                <option value="regional" {{ old('tingkat')==='regional' ? 'selected' : '' }}>Regional</option>
                                <option value="nasional" {{ old('tingkat')==='nasional' ? 'selected' : '' }}>Nasional</option>
                                <option value="internasional" {{ old('tingkat')==='internasional' ? 'selected' : '' }}>Internasional</option>
                            </select>
                            @error('tingkat')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label class="block text-sm text-gray-900">Penyelenggara</label>
                            <input name="penyelenggara" value="{{ old('penyelenggara') }}" required class="mt-1 w-full rounded-md border-gray-300 focus:border-[#1b3985] focus:ring-[#1b3985]"/>
                            @error('penyelenggara')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm text-gray-900">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required class="mt-1 w-full rounded-md border-gray-300 focus:border-[#1b3985] focus:ring-[#1b3985]"/>
                                @error('tanggal_mulai')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label class="block text-sm text-gray-900">Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" class="mt-1 w-full rounded-md border-gray-300 focus:border-[#1b3985] focus:ring-[#1b3985]"/>
                                @error('tanggal_selesai')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-900">Deskripsi Kegiatan</label>
                            <textarea name="deskripsi_kegiatan" rows="4" class="mt-1 w-full rounded-md border-gray-300 focus:border-[#1b3985] focus:ring-[#1b3985]">{{ old('deskripsi_kegiatan') }}</textarea>
                            @error('deskripsi_kegiatan')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label class="block text-sm text-gray-900">Upload Sertifikat (PDF/JPG/PNG)</label>
                            <input type="file" name="bukti_file" accept=".pdf,image/*" class="mt-1 w-full text-sm" />
                            <p class="text-xs text-gray-500 mt-1">Ukuran maks 2MB.</p>
                            @error('bukti_file')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
                        </div>

                        <div class="pt-2 flex items-center gap-3">
                            <button class="inline-flex items-center rounded-md bg-[#fa7516] px-4 py-2 text-white hover:bg-[#e5670c]">Simpan</button>
                            <a href="{{ route('student.portfolios.index') }}" class="rounded-md border border-[#1b3985] px-4 py-2 text-[#1b3985] hover:bg-blue-50">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

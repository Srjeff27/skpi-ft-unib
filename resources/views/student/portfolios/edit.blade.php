<x-app-layout>
    <x-slot name="header">
        @php
            $hour = now()->timezone(config('app.timezone'))->format('H');
            $greet = $hour < 11 ? 'Selamat Pagi' : ($hour < 15 ? 'Selamat Siang' : ($hour < 18 ? 'Selamat Sore' : 'Selamat Malam'));
            $name = auth()->user()?->name ?? 'Pengguna';
        @endphp
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ $greet }}, {{ $name }}</h2>
        <p class="text-sm text-gray-400">Edit Portofolio</p>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($portfolio->status !== 'pending')
                        <div class="mb-4 rounded border border-yellow-200 bg-yellow-50 p-3 text-yellow-800">Status {{ $portfolio->status }} — data tidak dapat diubah.</div>
                    @endif
                    <form method="POST" action="{{ route('student.portfolios.update', $portfolio) }}" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block text-sm text-gray-700">Judul Kegiatan</label>
                            <input name="judul_kegiatan" value="{{ old('judul_kegiatan', $portfolio->judul_kegiatan) }}" {{ $portfolio->status==='pending' ? '' : 'disabled' }} class="mt-1 w-full rounded-md border-gray-300 focus:border-[#1b3985] focus:ring-[#1b3985]"/>
                            @error('judul_kegiatan')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label class="block text-sm text-gray-700">Kategori</label>
                            <input name="kategori" value="{{ old('kategori', $portfolio->kategori) }}" {{ $portfolio->status==='pending' ? '' : 'disabled' }} class="mt-1 w-full rounded-md border-gray-300 focus:border-[#1b3985] focus:ring-[#1b3985]"/>
                            @error('kategori')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label class="block text-sm text-gray-700">Tingkat Kegiatan</label>
                            <select name="tingkat" {{ $portfolio->status==='pending' ? '' : 'disabled' }} class="mt-1 w-full rounded-md border-gray-300 focus:border-[#1b3985] focus:ring-[#1b3985]">
                                <option value="">- Pilih Tingkat -</option>
                                @php $t = old('tingkat', $portfolio->tingkat); @endphp
                                <option value="regional" {{ $t==='regional' ? 'selected' : '' }}>Regional</option>
                                <option value="nasional" {{ $t==='nasional' ? 'selected' : '' }}>Nasional</option>
                                <option value="internasional" {{ $t==='internasional' ? 'selected' : '' }}>Internasional</option>
                            </select>
                            @error('tingkat')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label class="block text-sm text-gray-700">Penyelenggara</label>
                            <input name="penyelenggara" value="{{ old('penyelenggara', $portfolio->penyelenggara) }}" {{ $portfolio->status==='pending' ? '' : 'disabled' }} class="mt-1 w-full rounded-md border-gray-300 focus:border-[#1b3985] focus:ring-[#1b3985]"/>
                            @error('penyelenggara')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm text-gray-700">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', $portfolio->tanggal_mulai) }}" {{ $portfolio->status==='pending' ? '' : 'disabled' }} class="mt-1 w-full rounded-md border-gray-300 focus:border-[#1b3985] focus:ring-[#1b3985]"/>
                                @error('tanggal_mulai')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label class="block text-sm text-gray-700">Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai', $portfolio->tanggal_selesai) }}" {{ $portfolio->status==='pending' ? '' : 'disabled' }} class="mt-1 w-full rounded-md border-gray-300 focus:border-[#1b3985] focus:ring-[#1b3985]"/>
                                @error('tanggal_selesai')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-700">Deskripsi Kegiatan</label>
                            <textarea name="deskripsi_kegiatan" rows="4" {{ $portfolio->status==='pending' ? '' : 'disabled' }} class="mt-1 w-full rounded-md border-gray-300 focus:border-[#1b3985] focus:ring-[#1b3985]">{{ old('deskripsi_kegiatan', $portfolio->deskripsi_kegiatan) }}</textarea>
                            @error('deskripsi_kegiatan')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label class="block text-sm text-gray-700">Link Bukti (URL)</label>
                            <input name="bukti_link" value="{{ old('bukti_link', $portfolio->bukti_link) }}" {{ $portfolio->status==='pending' ? '' : 'disabled' }} class="mt-1 w-full rounded-md border-gray-300 focus:border-[#1b3985] focus:ring-[#1b3985]"/>
                            @error('bukti_link')<div class="text-sm text-red-600">{{ $message }}</div>@enderror
                        </div>

                        <div class="pt-2 flex items-center gap-3">
                            @if ($portfolio->status==='pending')
                                <button class="inline-flex items-center rounded-md bg-[#fa7516] px-4 py-2 text-white hover:bg-[#e5670c]">Simpan</button>
                            @endif
                            <a href="{{ route('student.portfolios.index') }}" class="rounded-md border border-[#1b3985] px-4 py-2 text-[#1b3985] hover:bg-blue-50">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

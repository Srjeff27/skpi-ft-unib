<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">Kurikulum & CPL</h2>
        <p class="text-sm text-gray-500">Kelola kurikulum dan Capaian Pembelajaran Lulusan (CPL) per program studi</p>
    </x-slot>

    <div class="pt-8 pb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            {{-- Bagian 1: Filter Prodi & Aksi Utama --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 sm:p-6" x-data="{ showCreate:false }">
                <form method="GET" action="{{ route('admin.cpl.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-3 items-end">
                    <div class="sm:col-span-2">
                        <label class="text-xs font-medium text-gray-600">Program Studi</label>
                        <select name="prodi_id" class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">-- Pilih Program Studi --</option>
                            @foreach($prodis as $p)
                                <option value="{{ $p->id }}" @selected($selectedProdiId == $p->id)>{{ $p->nama_prodi }} ({{ $p->jenjang }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button class="inline-flex items-center rounded-md bg-[#1b3985] text-white px-4 py-2 text-sm">Terapkan</button>
                        <button type="button" @click="showCreate=true" class="inline-flex items-center rounded-md px-4 py-2 text-sm {{ $selectedProdiId ? 'bg-orange-500 hover:bg-orange-600 text-white' : 'bg-gray-200 text-gray-500 cursor-not-allowed pointer-events-none' }}" {{ $selectedProdiId ? '' : 'disabled' }}>
                            + Tambah Kurikulum Baru
                        </button>
                    </div>
                </form>

                <!-- Modal Tambah Kurikulum -->
                <div x-show="showCreate" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
                    <div class="absolute inset-0 bg-black/30" @click="showCreate=false"></div>
                    <div class="relative bg-white rounded-lg shadow-xl w-[90vw] max-w-lg p-5">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Tambah Kurikulum Baru</h3>
                        <form method="POST" action="{{ route('admin.cpl.curricula.store') }}" class="space-y-3">
                            @csrf
                            <input type="hidden" name="prodi_id" value="{{ $selectedProdiId }}">
                            <div>
                                <label class="text-xs text-gray-600">Nama Kurikulum</label>
                                <input name="name" type="text" required class="mt-1 w-full rounded-md border-gray-300" placeholder="Contoh: Kurikulum 2024 - MBKM">
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="text-xs text-gray-600">Tahun Berlaku</label>
                                    <input name="year" type="number" min="1900" max="2100" class="mt-1 w-full rounded-md border-gray-300" placeholder="2024">
                                </div>
                                <label class="flex items-center gap-2 mt-6">
                                    <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300">
                                    Jadikan Aktif
                                </label>
                            </div>
                            <div class="pt-2 flex justify-end gap-2">
                                <button type="button" @click="showCreate=false" class="px-4 py-2 rounded-md bg-gray-100 text-gray-700">Batal</button>
                                <button class="px-4 py-2 rounded-md bg-[#1b3985] text-white">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Bagian 2: Tabel Kurikulum per Prodi --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-100">
                <div class="p-4 sm:p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Daftar Kurikulum</h3>
                            @if($selectedProdi)
                                <p class="text-sm text-gray-500">Prodi: {{ $selectedProdi->nama_prodi }} ({{ $selectedProdi->jenjang }})</p>
                            @else
                                <p class="text-sm text-gray-500">Silakan pilih prodi terlebih dahulu.</p>
                            @endif
                        </div>
                    </div>

                    <div class="mt-4 overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="text-left text-gray-500">
                                <tr>
                                    <th class="p-3">Nama Kurikulum</th>
                                    <th class="p-3">Tahun Berlaku</th>
                                    <th class="p-3">Status</th>
                                    <th class="p-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($curricula as $k)
                                    <tr class="border-t">
                                        <td class="p-3">{{ $k->name }}</td>
                                        <td class="p-3">{{ $k->year ?? '-' }}</td>
                                        <td class="p-3">
                                            @if($k->is_active)
                                                <span class="inline-flex items-center rounded-full bg-green-100 text-green-700 px-2 py-0.5 text-xs font-semibold">Aktif</span>
                                            @else
                                                <span class="inline-flex items-center rounded-full bg-gray-100 text-gray-700 px-2 py-0.5 text-xs font-semibold">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td class="p-3 space-x-2">
                                            <a href="{{ route('admin.cpl.manage', $k) }}" class="text-[#1b3985] hover:underline">Kelola CPL</a>
                                            <a href="{{ route('admin.cpl.curricula.edit', $k) }}" class="text-gray-700 hover:underline">Edit</a>
                                            <form action="{{ route('admin.cpl.curricula.destroy', $k) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kurikulum ini? Seluruh CPL akan ikut terhapus.')">
                                                @csrf @method('DELETE')
                                                <button class="text-red-600 hover:underline">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="p-6 text-center text-gray-500" colspan="4">Belum ada data kurikulum untuk prodi ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

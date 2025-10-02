<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">Kelola CPL</h2>
        <p class="text-sm text-gray-500">{{ $curriculum->name }} - {{ optional($curriculum->prodi)->nama_prodi }} ({{ optional($curriculum->prodi)->jenjang }})</p>
    </x-slot>

    <div class="pt-8 pb-16" x-data="{ tab: 'sikap', showForm: {sikap:false, pengetahuan:false, umum:false, khusus:false} }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-100">
                <div class="p-4 sm:p-6">
                    <div class="flex items-center gap-2 text-sm">
                        <button class="px-3 py-2 rounded-md" :class="tab==='sikap' ? 'bg-[#1b3985] text-white' : 'bg-gray-100 text-gray-700'" @click="tab='sikap'">Sikap</button>
                        <button class="px-3 py-2 rounded-md" :class="tab==='pengetahuan' ? 'bg-[#1b3985] text-white' : 'bg-gray-100 text-gray-700'" @click="tab='pengetahuan'">Penguasaan Pengetahuan</button>
                        <button class="px-3 py-2 rounded-md" :class="tab==='umum' ? 'bg-[#1b3985] text-white' : 'bg-gray-100 text-gray-700'" @click="tab='umum'">Keterampilan Umum</button>
                        <button class="px-3 py-2 rounded-md" :class="tab==='khusus' ? 'bg-[#1b3985] text-white' : 'bg-gray-100 text-gray-700'" @click="tab='khusus'">Keterampilan Khusus</button>
                    </div>

                    {{-- Seksi: Sikap --}}
                    <div x-show="tab==='sikap'" class="mt-5">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-800">Sikap</h3>
                            <button @click="showForm.sikap=!showForm.sikap" class="inline-flex items-center rounded-md bg-orange-500 hover:bg-orange-600 text-white px-3 py-1.5 text-sm">+ Tambah CPL Baru</button>
                        </div>
                        <div x-show="showForm.sikap" x-transition class="mt-4 bg-orange-50 border border-orange-200 rounded-lg p-4">
                            <form method="POST" action="{{ route('admin.cpl.items.store', $curriculum) }}" class="space-y-3">
                                @csrf
                                <input type="hidden" name="category" value="sikap">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-xs text-gray-600">Kode (opsional)</label>
                                        <input name="code" type="text" class="mt-1 w-full rounded-md border-gray-300" placeholder="Contoh: CPL-S-1">
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-600">Urutan (opsional)</label>
                                        <input name="order" type="number" min="0" class="mt-1 w-full rounded-md border-gray-300" placeholder="0">
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-xs text-gray-600">Deskripsi (Indonesia)</label>
                                        <textarea name="desc_id" class="mt-1 w-full rounded-md border-gray-300" rows="3" required></textarea>
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-600">Description (English)</label>
                                        <textarea name="desc_en" class="mt-1 w-full rounded-md border-gray-300" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="mt-3 flex gap-2">
                                    <button class="inline-flex items-center rounded-md bg-[#1b3985] text-white px-3 py-1.5 text-sm">Simpan</button>
                                    <button type="button" @click="showForm.sikap=false" class="inline-flex items-center rounded-md bg-gray-100 text-gray-700 px-3 py-1.5 text-sm">Batal</button>
                                </div>
                            </form>
                        </div>
                        <div class="mt-4 overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead class="text-left text-gray-500"><tr><th class="p-3">Kode</th><th class="p-3">Deskripsi (IDN)</th><th class="p-3">Deskripsi (ENG)</th><th class="p-3">Aksi</th></tr></thead>
                                <tbody>
                                    @forelse($itemsByCategory['sikap'] ?? collect() as $it)
                                        <tr class="border-t">
                                            <td class="p-3">{{ $it->code ?? '-' }}</td>
                                            <td class="p-3">{{ Str::limit($it->desc_id, 120) }}</td>
                                            <td class="p-3">{{ Str::limit($it->desc_en ?? '-', 120) }}</td>
                                            <td class="p-3 space-x-2">
                                                <form action="{{ route('admin.cpl.items.destroy', $it) }}" method="POST" class="inline" onsubmit="return confirm('Hapus CPL ini?')">
                                                    @csrf @method('DELETE')
                                                    <button class="text-red-600 hover:underline">Hapus</button>
                                                </form>
                                                <a href="{{ route('admin.cpl.items.edit', $it) }}" class="text-gray-700 hover:underline">Edit</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td class="p-3">-</td><td class="p-3 text-gray-500">Belum ada data</td><td class="p-3 text-gray-500">No data</td><td class="p-3 text-gray-400">—</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Seksi: Penguasaan Pengetahuan --}}
                    <div x-show="tab==='pengetahuan'" class="mt-5">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-800">Penguasaan Pengetahuan</h3>
                            <button @click="showForm.pengetahuan=!showForm.pengetahuan" class="inline-flex items-center rounded-md bg-orange-500 hover:bg-orange-600 text-white px-3 py-1.5 text-sm">+ Tambah CPL Baru</button>
                        </div>
                        <div x-show="showForm.pengetahuan" x-transition class="mt-4 bg-orange-50 border border-orange-200 rounded-lg p-4">
                            <form method="POST" action="{{ route('admin.cpl.items.store', $curriculum) }}" class="space-y-3">
                                @csrf
                                <input type="hidden" name="category" value="pengetahuan">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div><label class="text-xs text-gray-600">Kode (opsional)</label><input name="code" type="text" class="mt-1 w-full rounded-md border-gray-300"></div>
                                    <div><label class="text-xs text-gray-600">Urutan (opsional)</label><input name="order" type="number" min="0" class="mt-1 w-full rounded-md border-gray-300"></div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div><label class="text-xs text-gray-600">Deskripsi (Indonesia)</label><textarea name="desc_id" class="mt-1 w-full rounded-md border-gray-300" rows="3" required></textarea></div>
                                    <div><label class="text-xs text-gray-600">Description (English)</label><textarea name="desc_en" class="mt-1 w-full rounded-md border-gray-300" rows="3"></textarea></div>
                                </div>
                                <div class="mt-3 flex gap-2"><button class="inline-flex items-center rounded-md bg-[#1b3985] text-white px-3 py-1.5 text-sm">Simpan</button><button type="button" @click="showForm.pengetahuan=false" class="inline-flex items-center rounded-md bg-gray-100 text-gray-700 px-3 py-1.5 text-sm">Batal</button></div>
                            </form>
                        </div>
                        <div class="mt-4 overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead class="text-left text-gray-500"><tr><th class="p-3">Kode</th><th class="p-3">Deskripsi (IDN)</th><th class="p-3">Deskripsi (ENG)</th><th class="p-3">Aksi</th></tr></thead>
                                <tbody>
                                    @forelse($itemsByCategory['pengetahuan'] ?? collect() as $it)
                                        <tr class="border-t"><td class="p-3">{{ $it->code ?? '-' }}</td><td class="p-3">{{ Str::limit($it->desc_id, 120) }}</td><td class="p-3">{{ Str::limit($it->desc_en ?? '-', 120) }}</td><td class="p-3 space-x-2"><form action="{{ route('admin.cpl.items.destroy', $it) }}" method="POST" class="inline" onsubmit="return confirm('Hapus CPL ini?')">@csrf @method('DELETE')<button class="text-red-600 hover:underline">Hapus</button></form><a href="{{ route('admin.cpl.items.edit', $it) }}" class="text-gray-700 hover:underline">Edit</a></td></tr>
                                    @empty
                                        <tr><td class="p-3">-</td><td class="p-3 text-gray-500">Belum ada data</td><td class="p-3 text-gray-500">No data</td><td class="p-3 text-gray-400">—</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Seksi: Keterampilan Umum --}}
                    <div x-show="tab==='umum'" class="mt-5">
                        <div class="flex items-center justify-between"><h3 class="text-lg font-semibold text-gray-800">Keterampilan Umum</h3><button @click="showForm.umum=!showForm.umum" class="inline-flex items-center rounded-md bg-orange-500 hover:bg-orange-600 text-white px-3 py-1.5 text-sm">+ Tambah CPL Baru</button></div>
                        <div x-show="showForm.umum" x-transition class="mt-4 bg-orange-50 border border-orange-200 rounded-lg p-4">
                            <form method="POST" action="{{ route('admin.cpl.items.store', $curriculum) }}" class="space-y-3">
                                @csrf
                                <input type="hidden" name="category" value="umum">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4"><div><label class="text-xs text-gray-600">Kode (opsional)</label><input name="code" type="text" class="mt-1 w-full rounded-md border-gray-300"></div><div><label class="text-xs text-gray-600">Urutan (opsional)</label><input name="order" type="number" min="0" class="mt-1 w-full rounded-md border-gray-300"></div></div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4"><div><label class="text-xs text-gray-600">Deskripsi (Indonesia)</label><textarea name="desc_id" class="mt-1 w-full rounded-md border-gray-300" rows="3" required></textarea></div><div><label class="text-xs text-gray-600">Description (English)</label><textarea name="desc_en" class="mt-1 w-full rounded-md border-gray-300" rows="3"></textarea></div></div>
                                <div class="mt-3 flex gap-2"><button class="inline-flex items-center rounded-md bg-[#1b3985] text-white px-3 py-1.5 text-sm">Simpan</button><button type="button" @click="showForm.umum=false" class="inline-flex items-center rounded-md bg-gray-100 text-gray-700 px-3 py-1.5 text-sm">Batal</button></div>
                            </form>
                        </div>
                        <div class="mt-4 overflow-x-auto">
                            <table class="min-w-full text-sm"><thead class="text-left text-gray-500"><tr><th class="p-3">Kode</th><th class="p-3">Deskripsi (IDN)</th><th class="p-3">Deskripsi (ENG)</th><th class="p-3">Aksi</th></tr></thead><tbody>
                                @forelse($itemsByCategory['umum'] ?? collect() as $it)
                                    <tr class="border-t"><td class="p-3">{{ $it->code ?? '-' }}</td><td class="p-3">{{ Str::limit($it->desc_id, 120) }}</td><td class="p-3">{{ Str::limit($it->desc_en ?? '-', 120) }}</td><td class="p-3 space-x-2"><form action="{{ route('admin.cpl.items.destroy', $it) }}" method="POST" class="inline" onsubmit="return confirm('Hapus CPL ini?')">@csrf @method('DELETE')<button class="text-red-600 hover:underline">Hapus</button></form><a href="{{ route('admin.cpl.items.edit', $it) }}" class="text-gray-700 hover:underline">Edit</a></td></tr>
                                @empty
                                    <tr><td class="p-3">-</td><td class="p-3 text-gray-500">Belum ada data</td><td class="p-3 text-gray-500">No data</td><td class="p-3 text-gray-400">—</td></tr>
                                @endforelse
                            </tbody></table>
                        </div>
                    </div>

                    {{-- Seksi: Keterampilan Khusus --}}
                    <div x-show="tab==='khusus'" class="mt-5">
                        <div class="flex items-center justify-between"><h3 class="text-lg font-semibold text-gray-800">Keterampilan Khusus</h3><button @click="showForm.khusus=!showForm.khusus" class="inline-flex items-center rounded-md bg-orange-500 hover:bg-orange-600 text-white px-3 py-1.5 text-sm">+ Tambah CPL Baru</button></div>
                        <div x-show="showForm.khusus" x-transition class="mt-4 bg-orange-50 border border-orange-200 rounded-lg p-4">
                            <form method="POST" action="{{ route('admin.cpl.items.store', $curriculum) }}" class="space-y-3">
                                @csrf
                                <input type="hidden" name="category" value="khusus">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4"><div><label class="text-xs text-gray-600">Kode (opsional)</label><input name="code" type="text" class="mt-1 w-full rounded-md border-gray-300"></div><div><label class="text-xs text-gray-600">Urutan (opsional)</label><input name="order" type="number" min="0" class="mt-1 w-full rounded-md border-gray-300"></div></div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4"><div><label class="text-xs text-gray-600">Deskripsi (Indonesia)</label><textarea name="desc_id" class="mt-1 w-full rounded-md border-gray-300" rows="3" required></textarea></div><div><label class="text-xs text-gray-600">Description (English)</label><textarea name="desc_en" class="mt-1 w-full rounded-md border-gray-300" rows="3"></textarea></div></div>
                                <div class="mt-3 flex gap-2"><button class="inline-flex items-center rounded-md bg-[#1b3985] text-white px-3 py-1.5 text-sm">Simpan</button><button type="button" @click="showForm.khusus=false" class="inline-flex items-center rounded-md bg-gray-100 text-gray-700 px-3 py-1.5 text-sm">Batal</button></div>
                            </form>
                        </div>
                        <div class="mt-4 overflow-x-auto">
                            <table class="min-w-full text-sm"><thead class="text-left text-gray-500"><tr><th class="p-3">Kode</th><th class="p-3">Deskripsi (IDN)</th><th class="p-3">Deskripsi (ENG)</th><th class="p-3">Aksi</th></tr></thead><tbody>
                                @forelse($itemsByCategory['khusus'] ?? collect() as $it)
                                    <tr class="border-t"><td class="p-3">{{ $it->code ?? '-' }}</td><td class="p-3">{{ Str::limit($it->desc_id, 120) }}</td><td class="p-3">{{ Str::limit($it->desc_en ?? '-', 120) }}</td><td class="p-3 space-x-2"><form action="{{ route('admin.cpl.items.destroy', $it) }}" method="POST" class="inline" onsubmit="return confirm('Hapus CPL ini?')">@csrf @method('DELETE')<button class="text-red-600 hover:underline">Hapus</button></form><a href="{{ route('admin.cpl.items.edit', $it) }}" class="text-gray-700 hover:underline">Edit</a></td></tr>
                                @empty
                                    <tr><td class="p-3">-</td><td class="p-3 text-gray-500">Belum ada data</td><td class="p-3 text-gray-500">No data</td><td class="p-3 text-gray-400">—</td></tr>
                                @endforelse
                            </tbody></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

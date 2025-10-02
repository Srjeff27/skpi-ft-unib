<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">Cetak SKPI</h2>
        <p class="text-sm text-gray-500">Filter, pilih, dan cetak SKPI mahasiswa yang sudah dinyatakan lulus</p>
    </x-slot>

    <div class="pt-8 pb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            {{-- Bagian 1: Filter --}}
            <form method="GET" class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 grid grid-cols-1 md:grid-cols-6 gap-3">
                <div class="md:col-span-2">
                    <label class="text-xs text-gray-500">Periode Yudisium (YYYY-MM)</label>
                    <select name="periode" class="w-full border-gray-300 rounded-md">
                        <option value="">Semua</option>
                        @foreach($periods as $p)
                            <option value="{{ $p }}" @selected(request('periode')===$p)>{{ \Carbon\Carbon::createFromFormat('Y-m',$p)->translatedFormat('F Y') }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="text-xs text-gray-500">Program Studi</label>
                    <select name="prodi_id" class="w-full border-gray-300 rounded-md">
                        <option value="">Semua</option>
                        @foreach($prodis as $p)
                            <option value="{{ $p->id }}" @selected(request('prodi_id')==$p->id)>{{ $p->nama_prodi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="text-xs text-gray-500">Pencarian (Nama/NIM)</label>
                    <input type="text" name="q" value="{{ request('q') }}" class="w-full border-gray-300 rounded-md" placeholder="Cari...">
                </div>
                <div class="md:col-span-6 flex justify-end">
                    <button class="inline-flex items-center rounded-md bg-[#1b3985] text-white px-4 py-2 text-sm">Terapkan</button>
                </div>
            </form>

            {{-- Bagian 2: Tabel Mahasiswa --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-x-auto">
                <form method="POST" action="{{ route('admin.cetak_skpi.print_bulk') }}" id="bulkForm">
                    @csrf
                    <table class="min-w-full text-sm">
                        <thead class="text-left text-gray-500">
                            <tr>
                                <th class="p-3"><input type="checkbox" id="check-all"></th>
                                <th class="p-3">NIM</th>
                                <th class="p-3">Nama Mahasiswa</th>
                                <th class="p-3">Program Studi</th>
                                <th class="p-3">Tanggal Yudisium</th>
                                <th class="p-3">Status Cetak</th>
                                <th class="p-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $s)
                                <tr class="border-t">
                                    <td class="p-3"><input type="checkbox" name="selected[]" value="{{ $s->id }}" class="row-check"></td>
                                    <td class="p-3">{{ $s->nim ?? '-' }}</td>
                                    <td class="p-3">{{ $s->name }}</td>
                                    <td class="p-3">{{ optional($s->prodi)->nama_prodi ?? '-' }}</td>
                                    <td class="p-3">{{ $s->tanggal_lulus ? \Carbon\Carbon::parse($s->tanggal_lulus)->format('d/m/Y') : '-' }}</td>
                                    <td class="p-3">
                                        @if($s->nomor_skpi)
                                            <span class="inline-flex items-center rounded-full bg-green-100 text-green-700 px-2 py-0.5 text-xs font-semibold">Sudah Dicetak</span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-gray-100 text-gray-700 px-2 py-0.5 text-xs font-semibold">Belum Dicetak</span>
                                        @endif
                                    </td>
                                    <td class="p-3 space-x-2">
                                        <a href="{{ route('admin.cetak_skpi.preview', $s) }}" target="_blank" class="text-[#1b3985] hover:underline">Pratinjau</a>
                                        <a href="{{ route('admin.cetak_skpi.print_single', $s) }}" class="text-gray-700 hover:underline">Cetak</a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td class="p-6 text-center text-gray-500" colspan="7">Tidak ada data sesuai filter.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="p-3">{{ $students->links() }}</div>

                    {{-- Bagian 3: Aksi Massal --}}
                    <div class="p-4 border-t flex justify-between items-center">
                        <div class="text-xs text-gray-500">Pilih beberapa mahasiswa menggunakan checkbox.</div>
                        <button type="submit" class="inline-flex items-center rounded-md bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 text-sm">Cetak SKPI Terpilih</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        (function(){
            const all = document.getElementById('check-all');
            const rows = document.querySelectorAll('.row-check');
            all?.addEventListener('change',()=>{
                rows.forEach(r=> r.checked = all.checked);
            });
        })();
    </script>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">Penerbitan SKPI (Resmi)</h2>
        <p class="text-sm text-gray-500">Terbitkan SKPI resmi untuk periode yang telah dikunci</p>
    </x-slot>

    <div class="pt-8 pb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            {{-- Filter periode terkunci --}}
            <form method="GET" class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 grid grid-cols-1 md:grid-cols-6 gap-3 items-end">
                <div class="md:col-span-4">
                    <label class="text-xs text-gray-500">Periode Yudisium (terkunci)</label>
                    <select name="periode" class="w-full border-gray-300 rounded-md" required>
                        <option value="">-- Pilih Periode --</option>
                        @foreach($lockedPeriods as $p)
                            <option value="{{ $p }}" @selected($periode===$p)>{{ \Carbon\Carbon::createFromFormat('Y-m',$p)->translatedFormat('F Y') }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-2 flex justify-end">
                    <button class="inline-flex items-center rounded-md bg-[#1b3985] text-white px-4 py-2 text-sm">Terapkan</button>
                </div>
            </form>

            @if($periode)
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-x-auto">
                <form method="POST" action="{{ route('admin.penerbitan.publish_bulk') }}">
                    @csrf
                    <input type="hidden" name="periode" value="{{ $periode }}">
                    <table class="min-w-full text-sm">
                        <thead class="text-left text-gray-500">
                            <tr>
                                <th class="p-3"><input type="checkbox" id="check-all"></th>
                                <th class="p-3">NIM</th>
                                <th class="p-3">Nama</th>
                                <th class="p-3">Nomor SKPI</th>
                                <th class="p-3">Status</th>
                                <th class="p-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $s)
                                <tr class="border-t">
                                    <td class="p-3"><input type="checkbox" name="selected[]" value="{{ $s->id }}" class="row-check"></td>
                                    <td class="p-3">{{ $s->nim ?? '-' }}</td>
                                    <td class="p-3">{{ $s->name }}</td>
                                    <td class="p-3">{{ $s->nomor_skpi ?? '-' }}</td>
                                    <td class="p-3">
                                        @if($s->nomor_skpi)
                                            <span class="inline-flex items-center rounded-full bg-green-100 text-green-700 px-2 py-0.5 text-xs font-semibold">Sudah Terbit</span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-gray-100 text-gray-700 px-2 py-0.5 text-xs font-semibold">Belum Terbit</span>
                                        @endif
                                    </td>
                                    <td class="p-3 space-x-2">
                                        @if(!$s->nomor_skpi)
                                            <form method="POST" action="{{ route('admin.penerbitan.publish_single', $s) }}" class="inline">
                                                @csrf
                                                <button class="text-[#1b3985] hover:underline">Terbitkan</button>
                                            </form>
                                        @else
                                            <a href="{{ route('admin.penerbitan.download', $s) }}" class="text-[#1b3985] hover:underline">Unduh PDF</a>
                                            <a href="{{ route('admin.penerbitan.verify', $s) }}" target="_blank" class="text-gray-700 hover:underline">Lihat Verifikasi</a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td class="p-6 text-center text-gray-500" colspan="6">Tidak ada mahasiswa untuk periode ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="p-3">{{ $students->links() }}</div>
                    <div class="p-4 border-t flex justify-between items-center">
                        <div class="text-xs text-gray-500">Pilih beberapa mahasiswa menggunakan checkbox.</div>
                        <button type="submit" class="inline-flex items-center rounded-md bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 text-sm">Terbitkan SKPI Terpilih</button>
                    </div>
                </form>
            </div>
            @endif
        </div>
    </div>

    <script>
        (function(){
            const all = document.getElementById('check-all');
            const rows = document.querySelectorAll('.row-check');
            all?.addEventListener('change',()=> rows.forEach(r=> r.checked = all.checked));
        })();
    </script>
</x-app-layout>


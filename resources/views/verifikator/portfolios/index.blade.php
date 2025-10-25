<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">Verifikasi Portofolio</h2>
        <p class="text-sm text-gray-500">Akses, filter, dan verifikasi</p>
    </x-slot>

    <div class="pt-8 pb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                <x-toast type="success" :message="session('status')" />
            @endif
            <form method="GET" class="bg-white rounded-lg shadow-sm p-4 grid grid-cols-1 md:grid-cols-4 gap-3">
                <div>
                    <label class="text-xs text-gray-500">Prodi</label>
                    <select name="prodi_id" class="w-full border-gray-300 rounded-md">
                        <option value="">Semua</option>
                        @foreach($prodis as $p)
                            <option value="{{ $p->id }}" @selected(request('prodi_id')==$p->id)>{{ $p->nama_prodi }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-xs text-gray-500">Angkatan</label>
                    <select name="angkatan" class="w-full border-gray-300 rounded-md">
                        <option value="">Semua</option>
                        @foreach($angkatanList as $a)
                            <option value="{{ $a }}" @selected(request('angkatan')==$a)>{{ $a }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-xs text-gray-500">Status</label>
                    <select name="status" class="w-full border-gray-300 rounded-md">
                        <option value="">Semua</option>
                        @foreach(['pending'=>'Menunggu','verified'=>'Disetujui','rejected'=>'Ditolak'] as $k=>$v)
                            <option value="{{ $k }}" @selected(request('status')==$k)>{{ $v }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end">
                    <button class="inline-flex items-center rounded-md bg-[#1b3985] text-white px-4 py-2 text-sm">Filter</button>
                </div>
            </form>

            <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="text-left text-gray-500">
                        <tr>
                            <th class="p-3">Mahasiswa</th>
                            <th class="p-3">Prodi</th>
                            <th class="p-3">Kategori</th>
                            <th class="p-3">Tanggal</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($portfolios as $pf)
                            <tr class="border-t">
                                <td class="p-3">{{ $pf->user->name }}</td>
                                <td class="p-3">{{ optional($pf->user->prodi)->nama_prodi ?? '-' }}</td>
                                <td class="p-3">{{ $pf->kategori_portfolio }}</td>
                                <td class="p-3">{{ optional($pf->tanggal_dokumen)->isoFormat('D MMM YYYY') }}</td>
                                <td class="p-3">{{ ucfirst($pf->status) }}</td>
                                <td class="p-3">
                                    @if($pf->status === 'pending')
                                        <a href="{{ route('verifikator.portfolios.show', $pf) }}" class="text-[#1b3985] underline">Periksa</a>
                                    @else
                                        <a href="{{ route('verifikator.portfolios.show', $pf) }}" class="text-gray-500 underline">Lihat</a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td class="p-6 text-center text-gray-500" colspan="6">Tidak ada data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-3">{{ $portfolios->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>

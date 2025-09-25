<x-app-layout>
    <x-slot name="header">
        @php
            $hour = now()->timezone(config('app.timezone'))->format('H');
            $greet =
                $hour > 3 && $hour < 11
                    ? 'Selamat Pagi'
                    : ($hour > 11 && $hour < 15
                        ? 'Selamat Siang'
                        : ($hour > 15 && $hour < 18
                            ? 'Selamat Sore'
                            : 'Selamat Malam'));
            $name = auth()->user()?->name ?? 'Pengguna';
        @endphp
        <h2 class="font-semibold text-xl text-gray-900 leading-tight">{{ $greet }}, {{ $name }}</h2>
        <p class="text-sm text-gray-500">Portfolio</p>
    </x-slot>

    {{-- DIUBAH: Padding bawah ditambahkan untuk menghindari tumpang tindih dengan nav mobile --}}
    <div class="pt-8 pb-24 md:pb-8">
        {{-- DIUBAH: Padding horizontal ditambahkan untuk mobile --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- DIUBAH: Header dibuat responsif (vertikal di mobile, horizontal di desktop) --}}
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-4">
                <div class="text-gray-900">Kelola portofolio kegiatan Anda.</div>
                <a href="{{ route('student.portfolios.create') }}"
                    class="w-full sm:w-auto text-center inline-flex items-center justify-center rounded-md bg-[#fa7516] px-4 py-2 text-white hover:bg-[#e5670c]">+
                    Upload Portofolio</a>
            </div>

            @if (session('status'))
                <div class="mb-4 rounded border border-green-200 bg-green-50 p-3 text-sm text-green-800">
                    {{ session('status') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="hidden sm:block">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="text-left text-gray-500 bg-gray-50">
                                <tr>
                                    <th class="p-4 font-medium">Nama Dokumen</th>
                                    <th class="p-4 font-medium">Kategori</th>
                                    <th class="p-4 font-medium">Nomor Dokumen</th>
                                    <th class="p-4 font-medium">Tanggal</th>
                                    <th class="p-4 font-medium">Status</th>
                                    <th class="p-4 font-medium text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($portfolios as $p)
                                    <tr>
                                        <td class="p-4 align-top">{{ $p->nama_dokumen_id }}</td>
                                        <td class="p-4 align-top">{{ $p->kategori_portfolio }}</td>
                                        <td class="p-4 align-top">{{ $p->nomor_dokumen }}</td>
                                        <td class="p-4 align-top whitespace-nowrap">
                                            {{ $p->tanggal_dokumen ? \Carbon\Carbon::parse($p->tanggal_dokumen)->isoFormat('D MMM YYYY') : '-' }}
                                        </td>                                        
                                        <td class="p-4 align-top">
                                            @php $colors = ['pending'=>'bg-yellow-100 text-yellow-800','verified'=>'bg-green-100 text-green-800','rejected'=>'bg-red-100 text-red-800']; @endphp
                                            <span
                                                class="px-2 py-1 rounded-full text-xs font-medium {{ $colors[$p->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                {{ $p->status === 'verified' ? 'Disetujui' : ($p->status === 'rejected' ? 'Ditolak' : 'Menunggu') }}
                                            </span>
                                            @if ($p->status === 'rejected' && $p->catatan_verifikator)
                                                <div class="text-xs text-red-600 mt-1"
                                                    title="{{ $p->catatan_verifikator }}">Alasan:
                                                    {{ Str::limit($p->catatan_verifikator, 30) }}</div>
                                            @endif
                                        </td>
                                        <td class="p-4 align-top text-right whitespace-nowrap">
                                            <div class="flex items-center justify-end gap-4">
                                                <a href="{{ $p->link_sertifikat }}" target="_blank"
                                                    class="text-blue-600 hover:underline">Lihat Sertifikat</a>
                                                @if ($p->status !== 'verified')
                                                    <a href="{{ route('student.portfolios.edit', $p) }}"
                                                        class="text-indigo-600 hover:underline">Edit</a>
                                                    <form action="{{ route('student.portfolios.destroy', $p) }}"
                                                        method="POST" class="inline"
                                                        onsubmit="return confirm('Anda yakin ingin menghapus portofolio ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="text-red-600 hover:underline">Hapus</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="p-6 text-center text-gray-500" colspan="6">Belum ada portofolio.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($portfolios->hasPages())
                        <div class="p-4 border-t border-gray-100">{{ $portfolios->links() }}</div>
                    @endif
                </div>

                <div class="block sm:hidden">
                    <div class="p-4 space-y-4">
                        @forelse ($portfolios as $p)
                            <div class="border border-gray-200 rounded-lg">
                                <div class="p-4 space-y-3">
                                    <div class="flex justify-between items-start gap-4">
                                        <h4 class="font-semibold text-gray-800">{{ $p->nama_dokumen_id }}</h4>
                                        @php $colors = ['pending'=>'bg-yellow-100 text-yellow-800','verified'=>'bg-green-100 text-green-800','rejected'=>'bg-red-100 text-red-800']; @endphp
                                        <span
                                            class="flex-shrink-0 px-2 py-1 rounded-full text-xs font-medium {{ $colors[$p->status] ?? 'bg-gray-100 text-gray-800' }}">{{ $p->status === 'verified' ? 'Disetujui' : ($p->status === 'rejected' ? 'Ditolak' : 'Menunggu') }}</span>
                                    </div>

                                    @if ($p->status === 'rejected' && $p->catatan_verifikator)
                                        <div class="text-xs border-l-4 border-red-200 bg-red-50 p-2 text-red-800">
                                            <b>Alasan Ditolak:</b> {{ $p->catatan_verifikator }}
                                        </div>
                                    @endif
                                    
                                    <div>
                                        <div class="text-xs text-gray-500">Kategori</div>
                                        <div class="text-sm text-gray-700">{{ $p->kategori_portfolio }}</div>
                                    </div>
                                    <div>
                                        <div class="text-xs text-gray-500">Nomor Dokumen</div>
                                        <div class="text-sm text-gray-700">
                                            {{ $p->nomor_dokumen ? ucfirst($p->nomor_dokumen) : '-' }}</div>
                                    </div>
                                    <div>
                                        <div class="text-xs text-gray-500">Tanggal</div>
                                        <div class="text-sm text-gray-700">
                                            {{ \Carbon\Carbon::parse($p->tanggal_mulai)->isoFormat('D MMM YYYY') }}{{ $p->tanggal_selesai ? ' - ' . \Carbon\Carbon::parse($p->tanggal_selesai)->isoFormat('D MMM YYYY') : '' }}
                                        </div>
                                    </div>
                                </div>
                                <div class="p-2 border-t border-gray-100 bg-gray-50 text-center">
                                    <div class="flex items-center justify-center divide-x divide-gray-200 text-sm">                                        
                                        <a href="{{ $p->link_sertifikat }}" target="_blank"
                                            class="flex-1 p-2 text-blue-600 font-medium">Lihat Sertifikat</a>
                                        @if ($p->status !== 'verified')
                                            <a href="{{ route('student.portfolios.edit', $p) }}"
                                                class="flex-1 p-2 text-indigo-600 font-medium">Edit</a>
                                            <form action="{{ route('student.portfolios.destroy', $p) }}" method="POST"
                                                class="flex-1 inline"
                                                onsubmit="return confirm('Anda yakin ingin menghapus portofolio ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="w-full p-2 text-red-600 font-medium">Hapus</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="py-12 text-center text-gray-500">
                                <p>Belum ada portofolio.</p>
                            </div>
                        @endforelse
                    </div>
                    @if ($portfolios->hasPages())
                        <div class="p-4 border-t border-gray-100">{{ $portfolios->links() }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

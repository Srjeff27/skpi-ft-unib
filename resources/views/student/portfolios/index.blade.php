<x-app-layout>
    <x-slot name="header">
        @php
            $hour = now()->timezone(config('app.timezone'))->format('H');
            $greet = $hour < 11 ? 'Selamat Pagi' : ($hour < 15 ? 'Selamat Siang' : ($hour < 18 ? 'Selamat Sore' : 'Selamat Malam'));
            $name = auth()->user()?->name ?? 'Pengguna';
        @endphp
        <h2 class="font-semibold text-xl text-gray-900 leading-tight">{{ $greet }}, {{ $name }}</h2>
        <p class="text-sm text-gray-500">Portofolio</p>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-4">
                <div class="text-gray-900">Kelola portofolio kegiatan Anda.</div>
                <a href="{{ route('student.portfolios.create') }}" class="inline-flex items-center rounded-md bg-[#fa7516] px-4 py-2 text-white hover:bg-[#e5670c]">+ Upload Portofolio</a>
            </div>

            @if (session('status'))
                <div class="mb-4 rounded border border-green-200 bg-green-50 p-3 text-green-700">{{ session('status') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="text-left text-gray-500">
                                <tr>
                                    <th class="py-2 pr-4">Judul</th>
                                    <th class="py-2 pr-4">Kategori</th>
                                    <th class="py-2 pr-4">Tingkat</th>
                                    <th class="py-2 pr-4">Tanggal</th>
                                    <th class="py-2 pr-4">Status</th>
                                    <th class="py-2"></th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse ($portfolios as $p)
                                <tr class="border-t border-gray-100">
                                    <td class="py-2 pr-4">{{ $p->judul_kegiatan }}</td>
                                    <td class="py-2 pr-4">{{ $p->kategori }}</td>
                                    <td class="py-2 pr-4">{{ $p->tingkat ? ucfirst($p->tingkat) : '-' }}</td>
                                    <td class="py-2 pr-4">{{ $p->tanggal_mulai }}{{ $p->tanggal_selesai ? ' - ' . $p->tanggal_selesai : '' }}</td>
                                    <td class="py-2 pr-4">
                                        @php $colors = ['pending'=>'bg-yellow-100 text-yellow-700','verified'=>'bg-green-100 text-green-700','rejected'=>'bg-red-100 text-red-700']; @endphp
                                        <span class="px-2 py-1 rounded text-xs {{ $colors[$p->status] ?? 'bg-gray-100 text-gray-700' }}">
                                            {{ $p->status === 'verified' ? 'Disetujui' : ($p->status === 'rejected' ? 'Ditolak' : 'Menunggu') }}
                                        </span>
                                        @if($p->status === 'rejected' && $p->catatan_verifikator)
                                            <div class="text-xs text-red-600 mt-1">Alasan: {{ $p->catatan_verifikator }}</div>
                                        @endif
                                    </td>
                                    <td class="py-2 text-right space-x-2">
                                        <a href="{{ $p->bukti_link }}" target="_blank" class="text-blue-600 hover:underline">Bukti</a>
                                        @if ($p->status === 'pending')
                                            <a href="{{ route('student.portfolios.edit', $p) }}" class="text-[#1b3985] hover:underline">Edit</a>
                                            <form action="{{ route('student.portfolios.destroy', $p) }}" method="POST" class="inline" onsubmit="return confirm('Hapus portofolio ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-red-600 hover:underline">Hapus</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td class="py-6 text-center text-gray-500" colspan="5">Belum ada portofolio.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">{{ $portfolios->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

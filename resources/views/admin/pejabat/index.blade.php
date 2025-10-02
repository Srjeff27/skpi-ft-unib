<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-black leading-tight">Kelola Pejabat Penandatangan</h2>
                <p class="text-sm text-gray-500">Atur pejabat yang menandatangani SKPI</p>
            </div>
            <a href="{{ route('admin.pejabat.create') }}" class="inline-flex items-center rounded-md bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 text-sm">+ Tambah Pejabat Baru</a>
        </div>
    </x-slot>

    <div class="pt-8 pb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="text-left text-gray-500">
                        <tr>
                            <th class="p-3">Nama Lengkap & Gelar</th>
                            <th class="p-3">Jabatan</th>
                            <th class="p-3">NIP/NIDN</th>
                            <th class="p-3">Tanda Tangan</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($officials as $o)
                            <tr class="border-t">
                                <td class="p-3">{{ $o->display_name }}</td>
                                <td class="p-3">{{ $o->jabatan }}</td>
                                <td class="p-3">{{ $o->nip ?? '-' }}</td>
                                <td class="p-3">
                                    @if($o->signature_path)
                                        <img src="{{ asset('storage/'.$o->signature_path) }}" class="h-10 object-contain" alt="Tanda tangan">
                                    @else
                                        <span class="text-gray-400">Belum ada</span>
                                    @endif
                                </td>
                                <td class="p-3">
                                    @if($o->is_active)
                                        <span class="inline-flex items-center rounded-full bg-green-100 text-green-700 px-2 py-0.5 text-xs font-semibold">Aktif</span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-gray-100 text-gray-700 px-2 py-0.5 text-xs font-semibold">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td class="p-3 space-x-2">
                                    <a href="{{ route('admin.pejabat.edit', $o) }}" class="text-[#1b3985] hover:underline">Edit</a>
                                    <form action="{{ route('admin.pejabat.destroy', $o) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pejabat ini?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td class="p-6 text-center text-gray-500" colspan="6">Belum ada data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

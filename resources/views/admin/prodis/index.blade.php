<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">Manajemen Prodi</h2>
    </x-slot>

    <div class="pt-8 pb-16">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <a href="{{ route('admin.prodis.create') }}" class="inline-flex items-center rounded-md bg-[#1b3985] text-white px-4 py-2 text-sm">Tambah Prodi</a>

            <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="text-left text-gray-500">
                        <tr>
                            <th class="p-3">Nama Prodi</th>
                            <th class="p-3">Jenjang</th>
                            <th class="p-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prodis as $p)
                            <tr class="border-t">
                                <td class="p-3">{{ $p->nama_prodi }}</td>
                                <td class="p-3">{{ $p->jenjang }}</td>
                                <td class="p-3 space-x-2">
                                    <a href="{{ route('admin.prodis.edit', $p) }}" class="text-[#1b3985] underline">Edit</a>
                                    <form action="{{ route('admin.prodis.destroy', $p) }}" method="POST" class="inline" onsubmit="return confirm('Hapus prodi?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-3">{{ $prodis->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>


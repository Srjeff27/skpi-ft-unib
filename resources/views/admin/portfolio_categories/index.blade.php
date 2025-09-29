<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">Kategori Portofolio</h2>
    </x-slot>

    <div class="pt-8 pb-16">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <a href="{{ route('admin.portfolio-categories.create') }}" class="inline-flex items-center rounded-md bg-[#1b3985] text-white px-4 py-2 text-sm">Tambah Kategori</a>

            <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="text-left text-gray-500">
                        <tr>
                            <th class="p-3">Nama</th>
                            <th class="p-3">Maks Upload (KB)</th>
                            <th class="p-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $c)
                            <tr class="border-t">
                                <td class="p-3">{{ $c->name }}</td>
                                <td class="p-3">{{ $c->max_upload_kb }}</td>
                                <td class="p-3 space-x-2">
                                    <a href="{{ route('admin.portfolio-categories.edit', $c) }}" class="text-[#1b3985] underline">Edit</a>
                                    <form action="{{ route('admin.portfolio-categories.destroy', $c) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kategori?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-3">{{ $categories->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>


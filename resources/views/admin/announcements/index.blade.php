<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">Pengumuman</h2>
    </x-slot>

    <div class="pt-8 pb-16">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <a href="{{ route('admin.announcements.create') }}" class="inline-flex items-center rounded-md bg-[#1b3985] text-white px-4 py-2 text-sm">Buat Pengumuman</a>

            <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="text-left text-gray-500">
                        <tr>
                            <th class="p-3">Judul</th>
                            <th class="p-3">Terbit</th>
                            <th class="p-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($announcements as $a)
                            <tr class="border-t">
                                <td class="p-3">{{ $a->title }}</td>
                                <td class="p-3">{{ optional($a->published_at)->format('d/m/Y H:i') }}</td>
                                <td class="p-3">
                                    <form action="{{ route('admin.announcements.destroy', $a) }}" method="POST" onsubmit="return confirm('Hapus pengumuman?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-3">{{ $announcements->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>


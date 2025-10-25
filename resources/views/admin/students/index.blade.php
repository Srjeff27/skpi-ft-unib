<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">Manajemen Mahasiswa</h2>
        <p class="text-sm text-gray-500">Data & akun role mahasiswa</p>
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
                <div class="flex items-end">
                    <button class="inline-flex items-center rounded-md bg-[#1b3985] text-white px-4 py-2 text-sm">Filter</button>
                </div>
                <div class="flex items-end justify-end">
                    <a href="{{ route('admin.students.create') }}" class="inline-flex items-center rounded-md bg-[#1b3985] text-white px-4 py-2 text-sm">Tambah</a>
                </div>
            </form>

            <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="text-left text-gray-500">
                        <tr>
                            <th class="p-3">Nama</th>
                            <th class="p-3">Email</th>
                            <th class="p-3">NIM</th>
                            <th class="p-3">Angkatan</th>
                            <th class="p-3">Prodi</th>
                            <th class="p-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $s)
                            <tr class="border-t">
                                <td class="p-3">{{ $s->name }}</td>
                                <td class="p-3">{{ $s->email }}</td>
                                <td class="p-3">{{ $s->nim }}</td>
                                <td class="p-3">{{ $s->angkatan }}</td>
                                <td class="p-3">{{ optional($s->prodi)->nama_prodi ?? '-' }}</td>
                                <td class="p-3 space-x-2">
                                    <a href="{{ route('admin.students.edit', $s) }}" class="text-[#1b3985] underline">Edit</a>
                                    <form action="{{ route('admin.students.destroy', $s) }}" method="POST" class="inline" onsubmit="return confirm('Hapus mahasiswa?')">
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
                <div class="p-3">{{ $students->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>

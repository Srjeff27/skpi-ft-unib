<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">Manajemen User</h2>
        <p class="text-sm text-gray-500">Kelola akun mahasiswa & verifikator</p>
    </x-slot>

    <div class="pt-8 pb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                <x-toast type="success" :message="session('status')" />
            @endif
            <div class="flex justify-between items-center">
                <a href="{{ route('admin.users.create') }}" class="inline-flex items-center rounded-md bg-[#1b3985] text-white px-4 py-2 text-sm">Tambah User</a>
            </div>

            <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="text-left text-gray-500">
                        <tr>
                            <th class="p-3">Nama</th>
                            <th class="p-3">Email</th>
                            <th class="p-3">Role</th>
                            <th class="p-3">Prodi</th>
                            <th class="p-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $u)
                            <tr class="border-t">
                                <td class="p-3">{{ $u->name }}</td>
                                <td class="p-3">{{ $u->email }}</td>
                                <td class="p-3">{{ ucfirst($u->role) }}</td>
                                <td class="p-3">{{ optional($u->prodi)->nama_prodi ?? '-' }}</td>
                                <td class="p-3 space-x-2">
                                    <a href="{{ route('admin.users.edit', $u) }}" class="text-[#1b3985] underline">Edit</a>
                                    <form action="{{ route('admin.users.destroy', $u) }}" method="POST" class="inline" onsubmit="return confirm('Hapus user?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                    <form action="{{ route('admin.users.reset_password', $u) }}" method="POST" class="inline" onsubmit="return confirm('Reset password ke password123?')">
                                        @csrf
                                        <button class="text-orange-600 hover:underline">Reset Password</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-3">{{ $users->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>

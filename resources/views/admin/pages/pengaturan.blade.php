<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">Log Aktivitas</h2>
        <p class="text-sm text-gray-500">Pantau seluruh aktivitas pengguna di sistem</p>
    </x-slot>

    <div class="pt-8 pb-16" x-data="{ tab: 'log' }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-100">
                <div class="p-4 sm:p-6">
                    <div class="flex items-center gap-2 text-sm">
                        <button class="px-3 py-2 rounded-md bg-[#1b3985] text-white">Log Aktivitas</button>
                    </div>

                    {{-- Tab 2: Log Aktivitas --}}
                    <div x-show="tab==='log'" class="mt-6 space-y-4">
                        <form method="GET" class="grid grid-cols-1 md:grid-cols-6 gap-3 items-end">
                            <div class="md:col-span-2">
                                <label class="text-xs text-gray-500">Pengguna</label>
                                <select name="filter_user" class="w-full border-gray-300 rounded-md">
                                    <option value="">Semua</option>
                                    @foreach($users as $u)
                                        <option value="{{ $u->id }}" @selected($filterUser==$u->id)>{{ $u->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label class="text-xs text-gray-500">Tipe Aksi</label>
                                <input type="text" name="filter_action" value="{{ $filterAction }}" class="w-full border-gray-300 rounded-md" placeholder="misal: admin.prodis.update">
                            </div>
                            <div>
                                <label class="text-xs text-gray-500">Dari</label>
                                <input type="date" name="date_from" value="{{ $dateFrom }}" class="w-full border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label class="text-xs text-gray-500">Sampai</label>
                                <input type="date" name="date_to" value="{{ $dateTo }}" class="w-full border-gray-300 rounded-md">
                            </div>
                            <div class="md:col-span-6 flex justify-end">
                                <button class="inline-flex items-center rounded-md bg-[#1b3985] text-white px-4 py-2 text-sm">Terapkan</button>
                            </div>
                        </form>
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead class="text-left text-gray-500"><tr><th class="p-3">Waktu</th><th class="p-3">User</th><th class="p-3">Aksi</th><th class="p-3">Objek</th><th class="p-3">Detail</th></tr></thead>
                                <tbody>
                                    @forelse($logs as $log)
                                        <tr class="border-t"><td class="p-3">{{ optional($log->created_at)->format('d/m/Y H:i') }}</td><td class="p-3">{{ optional($log->user)->name }}</td><td class="p-3">{{ $log->action }}</td><td class="p-3">{{ $log->subject_type }}#{{ $log->subject_id }}</td><td class="p-3"><code class="text-xs">{{ json_encode($log->properties) }}</code></td></tr>
                                    @empty
                                        <tr><td class="p-6 text-center text-gray-500" colspan="5">Belum ada log.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="p-3">{{ $logs->links() }}</div>
                        </div>
                    </div>

                    {{-- Tab Pengaturan Lanjutan dihapus sesuai permintaan --}}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

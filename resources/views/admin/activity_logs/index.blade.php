<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">Log Aktivitas</h2>
    </x-slot>

    <div class="pt-8 pb-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-500">
                            <th class="p-3">Waktu</th>
                            <th class="p-3">User</th>
                            <th class="p-3">Aksi</th>
                            <th class="p-3">Objek</th>
                            <th class="p-3">Properti</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr class="border-t">
                                <td class="p-3">{{ optional($log->created_at)->format('d/m/Y H:i') }}</td>
                                <td class="p-3">{{ optional($log->user)->name }}</td>
                                <td class="p-3">{{ $log->action }}</td>
                                <td class="p-3">{{ $log->subject_type }}#{{ $log->subject_id }}</td>
                                <td class="p-3"><code class="text-xs">{{ json_encode($log->properties) }}</code></td>
                            </tr>
                        @empty
                            <tr><td class="p-6 text-center text-gray-500" colspan="5">Belum ada log.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-3">{{ $logs->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>


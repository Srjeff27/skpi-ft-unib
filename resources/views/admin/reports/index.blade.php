<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">Laporan</h2>
        <p class="text-sm text-gray-500">Export statistik ke CSV/PDF</p>
    </x-slot>

    <div class="pt-8 pb-16">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <div class="text-sm text-gray-500">Verified</div>
                        <div class="text-2xl font-semibold">{{ $byStatus['verified'] }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Rejected</div>
                        <div class="text-2xl font-semibold">{{ $byStatus['rejected'] }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Pending</div>
                        <div class="text-2xl font-semibold">{{ $byStatus['pending'] }}</div>
                    </div>
                </div>

                <div class="mt-6 flex gap-3">
                    <a class="px-4 py-2 rounded-md bg-[#1b3985] text-white" href="{{ route('admin.reports.export_csv') }}">Export CSV</a>
                    <a class="px-4 py-2 rounded-md bg-[#1b3985] text-white" href="{{ route('admin.reports.export_pdf') }}">Export PDF</a>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="font-semibold mb-3">Mahasiswa per Prodi</div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="text-left text-gray-500">
                                <th class="p-2">Prodi</th>
                                <th class="p-2">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($byProdi as $row)
                                <tr class="border-t">
                                    <td class="p-2">{{ $row->nama_prodi }}</td>
                                    <td class="p-2">{{ $row->users_count }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


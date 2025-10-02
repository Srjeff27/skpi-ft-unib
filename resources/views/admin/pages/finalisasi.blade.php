<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">Finalisasi Data</h2>
        <p class="text-sm text-gray-500">Kunci data periode yudisium dan tetapkan pejabat penandatangan</p>
    </x-slot>

    <div class="pt-8 pb-16" x-data="{ hasPeriode: {{ $periode ? 'true' : 'false' }} }">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <form method="GET" class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 grid grid-cols-1 sm:grid-cols-4 gap-3 items-end">
                <div class="sm:col-span-3">
                    <label class="text-xs text-gray-500">Periode Yudisium/Kelulusan (YYYY-MM)</label>
                    <select name="periode" class="w-full border-gray-300 rounded-md">
                        <option value="">-- Pilih Periode --</option>
                        @foreach($periods as $p)
                            <option value="{{ $p }}" @selected($periode===$p)>{{ \Carbon\Carbon::createFromFormat('Y-m',$p)->translatedFormat('F Y') }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-end">
                    <button class="inline-flex items-center rounded-md bg-[#1b3985] text-white px-4 py-2 text-sm">Terapkan</button>
                </div>
            </form>

            @if($periode)
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5 space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <div class="text-sm text-gray-500">Periode</div>
                        <div class="text-lg font-semibold">{{ \Carbon\Carbon::createFromFormat('Y-m',$periode)->translatedFormat('F Y') }}</div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div>
                            <div class="text-sm text-gray-500">Status Data</div>
                            @if($record && $record->is_locked)
                                <span class="inline-flex items-center rounded-full bg-green-100 text-green-700 px-3 py-1 text-xs font-semibold">Terkunci (Final)</span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-amber-100 text-amber-700 px-3 py-1 text-xs font-semibold">Terbuka (Dapat diubah)</span>
                            @endif
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Pejabat Penandatangan</div>
                            <div class="font-medium">
                                @if($record && $record->official)
                                    {{ $record->official->display_name }} — {{ $record->official->jabatan }}
                                @else
                                    <span class="text-gray-500">Belum Ditetapkan</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <form method="POST" action="{{ route('admin.finalisasi.set_official') }}" class="bg-gray-50 rounded-md p-4 border">
                        @csrf
                        <input type="hidden" name="periode" value="{{ $periode }}">
                        <label class="text-xs text-gray-600">Tetapkan Pejabat Penandatangan</label>
                        <div class="mt-1 flex gap-2">
                            <select name="official_id" class="w-full border-gray-300 rounded-md">
                                @foreach($activeOfficials as $o)
                                    <option value="{{ $o->id }}" @selected(($record?->official_id)===$o->id)>{{ $o->display_name }} — {{ $o->jabatan }}</option>
                                @endforeach
                            </select>
                            <button class="px-4 py-2 rounded-md bg-[#1b3985] text-white text-sm">Tetapkan Pejabat</button>
                        </div>
                    </form>

                    <form method="POST" action="{{ route('admin.finalisasi.lock') }}" class="bg-gray-50 rounded-md p-4 border" onsubmit="return confirm('Anda yakin ingin mengunci data? Tindakan ini tidak dapat dibatalkan.')">
                        @csrf
                        <input type="hidden" name="periode" value="{{ $periode }}">
                        <div class="text-xs text-gray-600 mb-1">Kunci Data (Finalize)</div>
                        <button class="px-4 py-2 rounded-md text-sm {{ ($record && $record->official_id) ? 'bg-orange-500 hover:bg-orange-600 text-white' : 'bg-gray-200 text-gray-500 cursor-not-allowed' }}" {{ ($record && $record->official_id) ? '' : 'disabled' }}>
                            Kunci Seluruh Data Periode Ini
                        </button>
                        <div class="text-xs text-gray-500 mt-2">Tombol aktif setelah pejabat ditetapkan.</div>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>

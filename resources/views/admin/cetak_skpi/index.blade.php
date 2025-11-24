<x-app-layout>
    <div class="space-y-6" x-data="{ selected: [], students: {{ json_encode($students->pluck('id')) }} }">
        {{-- Header --}}
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Cetak SKPI</h2>
                <p class="text-sm text-gray-500">Filter, pilih, dan cetak SKPI untuk mahasiswa yang telah lulus.</p>
            </div>
        </div>

        @if (session('status'))
            <x-toast type="success" :message="session('status')" />
        @endif
        @if ($errors->any())
            <x-toast type="error" :message="$errors->first()" />
        @endif

        {{-- Filters and Search --}}
        <div class="rounded-xl border border-gray-100 bg-white p-4 shadow-sm">
            <form method="GET">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <input type="search" name="q" placeholder="Cari nama atau NIM..." value="{{ request('q') }}"
                        class="w-full rounded-lg border-gray-200 focus:border-[#1b3985] focus:ring-[#1b3985] lg:col-span-1">
                    <select name="periode" class="w-full rounded-lg border-gray-200 focus:border-[#1b3985] focus:ring-[#1b3985]">
                        <option value="">Semua Periode Yudisium</option>
                        @foreach ($periods as $p)
                            <option value="{{ $p }}" @selected(request('periode') === $p)>
                                {{ \Carbon\Carbon::createFromFormat('Y-m', $p)->translatedFormat('F Y') }}</option>
                        @endforeach
                    </select>
                    <select name="prodi_id" class="w-full rounded-lg border-gray-200 focus:border-[#1b3985] focus:ring-[#1b3985]">
                        <option value="">Semua Prodi</option>
                        @foreach ($prodis as $p)
                            <option value="{{ $p->id }}" @selected(request('prodi_id') == $p->id)>{{ $p->nama_prodi }}</option>
                        @endforeach
                    </select>
                    <button type="submit"
                        class="inline-flex items-center gap-2 justify-center rounded-lg bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-700 transition-all hover:bg-gray-200">
                        <x-heroicon-o-magnifying-glass class="h-4 w-4" />
                        Filter
                    </button>
                </div>
            </form>
        </div>

        {{-- Student List --}}
        <form method="POST" action="{{ route('admin.cetak_skpi.print_bulk') }}">
            @csrf
            <div class="space-y-4">
                {{-- Bulk Actions --}}
                <div class="rounded-xl border border-gray-100 bg-white p-3 shadow-sm sm:flex sm:items-center sm:justify-between">
                    <div class="flex items-center gap-3">
                        <input type="checkbox" @click="selected = $event.target.checked ? students : []" class="h-4 w-4 rounded border-gray-300 text-[#1b3985] focus:ring-[#1b3985]">
                        <label class="text-sm font-medium text-gray-700">Pilih Semua</label>
                    </div>
                    <button type="submit" :disabled="selected.length === 0"
                        class="mt-3 w-full inline-flex items-center gap-2 justify-center rounded-lg bg-[#1b3985] px-4 py-2 text-sm font-semibold text-white shadow-sm transition-all hover:bg-[#152c66] disabled:cursor-not-allowed disabled:opacity-50 sm:mt-0 sm:w-auto">
                        <x-heroicon-o-printer class="h-4 w-4" />
                        Cetak <span x-text="selected.length" x-show="selected.length > 0"></span> SKPI Terpilih
                    </button>
                </div>

                @if ($students->count() > 0)
                    <div class="space-y-3">
                        @foreach ($students as $student)
                            <div class="flex items-center gap-4 rounded-xl border bg-white p-4 shadow-sm transition-all hover:border-gray-300">
                                <input type="checkbox" name="selected[]" value="{{ $student->id }}" x-model="selected" class="h-4 w-4 rounded border-gray-300 text-[#1b3985] focus:ring-[#1b3985]">
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800">{{ $student->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $student->nim }} - {{ optional($student->prodi)->nama_prodi }}</p>
                                </div>
                                <div class="hidden flex-col items-end gap-1 text-sm sm:flex">
                                    @if($student->nomor_skpi)
                                        <span class="inline-flex items-center rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-700">Sudah Dicetak</span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-gray-100 px-2 py-1 text-xs font-medium text-gray-600">Belum Dicetak</span>
                                    @endif
                                    <p class="text-xs text-gray-400">Lulus: {{ \Carbon\Carbon::parse($student->tanggal_lulus)->isoFormat('D MMM Y') }}</p>
                                </div>
                                <div class="flex flex-shrink-0 items-center gap-2">
                                    <a href="{{ route('admin.cetak_skpi.preview', $student) }}" target="_blank" class="rounded-lg bg-gray-50 p-2 text-sm font-semibold text-gray-600 hover:bg-gray-100" title="Pratinjau">
                                        <x-heroicon-o-eye class="h-5 w-5" />
                                    </a>
                                    <a href="{{ route('admin.cetak_skpi.print_single', $student) }}" class="rounded-lg bg-gray-50 p-2 text-sm font-semibold text-gray-600 hover:bg-gray-100" title="Cetak">
                                        <x-heroicon-o-printer class="h-5 w-5" />
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if ($students->hasPages())
                        <div class="mt-6">
                            {{ $students->links() }}
                        </div>
                    @endif
                @else
                    {{-- Empty State --}}
                    <div class="text-center rounded-xl border-2 border-dashed border-gray-200 bg-white p-12">
                        <x-heroicon-o-user-group class="mx-auto h-12 w-12 text-gray-400" />
                        <h3 class="mt-2 text-sm font-semibold text-gray-900">Tidak Ada Mahasiswa</h3>
                        <p class="mt-1 text-sm text-gray-500">Tidak ada data mahasiswa yang cocok dengan filter Anda.</p>
                    </div>
                @endif
            </div>
        </form>
    </div>
</x-app-layout>

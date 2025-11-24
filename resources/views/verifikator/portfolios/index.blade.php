@php
$isAdmin = Auth::user()->role === 'admin';
$title = $isAdmin ? 'Manajemen Data SKPI' : 'Verifikasi Portofolio';
$subtitle = $isAdmin ? 'Kelola dan lihat semua data portofolio mahasiswa.' : 'Review dan validasi portofolio yang diajukan mahasiswa.';
@endphp

<x-app-layout>
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">{{ $title }}</h2>
                <p class="text-sm text-gray-500">{{ $subtitle }}</p>
            </div>
        </div>

        @if (session('status'))
            <x-toast type="success" :message="session('status')" />
        @endif

        {{-- Filters and Search --}}
        <div class="rounded-xl border border-gray-100 bg-white p-4 shadow-sm">
            <form method="GET">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5">
                    <div class="lg:col-span-2">
                        <input type="search" name="search" placeholder="Cari nama mahasiswa atau judul..." value="{{ request('search') }}"
                            class="w-full rounded-lg border-gray-200 focus:border-[#1b3985] focus:ring-[#1b3985]">
                    </div>
                    <select name="prodi_id" class="w-full rounded-lg border-gray-200 focus:border-[#1b3985] focus:ring-[#1b3985]">
                        <option value="">Semua Prodi</option>
                        @foreach ($prodis as $p)
                            <option value="{{ $p->id }}" @selected(request('prodi_id') == $p->id)>{{ $p->nama_prodi }}</option>
                        @endforeach
                    </select>
                    <select name="status" class="w-full rounded-lg border-gray-200 focus:border-[#1b3985] focus:ring-[#1b3985]">
                        <option value="">Semua Status</option>
                        @foreach (['pending' => 'Menunggu', 'verified' => 'Disetujui', 'rejected' => 'Ditolak', 'requires_revision' => 'Perlu Perbaikan'] as $k => $v)
                            <option value="{{ $k }}" @selected(request('status') == $k)>{{ $v }}</option>
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

        {{-- Portfolio List --}}
        <div class="flow-root">
            @if ($portfolios->count() > 0)
                <div class="space-y-4">
                    @foreach ($portfolios as $portfolio)
                        @php
                            $statusStyles = [
                                'pending' => ['badge' => 'bg-amber-100 text-amber-700', 'border' => 'border-amber-200', 'icon' => 'heroicon-o-clock'],
                                'verified' => ['badge' => 'bg-green-100 text-green-700', 'border' => 'border-green-200', 'icon' => 'heroicon-o-check-circle'],
                                'rejected' => ['badge' => 'bg-red-100 text-red-700', 'border' => 'border-red-200', 'icon' => 'heroicon-o-x-circle'],
                                'requires_revision' => ['badge' => 'bg-blue-100 text-blue-700', 'border' => 'border-blue-200', 'icon' => 'heroicon-o-pencil-square'],
                            ][$portfolio->status] ?? ['badge' => 'bg-gray-100 text-gray-700', 'border' => 'border-gray-200', 'icon' => 'heroicon-o-question-mark-circle'];
                        @endphp
                        <a href="{{ route('verifikator.portfolios.show', $portfolio) }}"
                            class="block rounded-xl border bg-white p-4 shadow-sm transition-all hover:border-gray-300 hover:shadow-md {{ $statusStyles['border'] }}">
                            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                <div class="flex-1">
                                    <div class="flex items-start gap-3">
                                        <img src="{{ $portfolio->user->avatar_url }}" alt="Avatar" class="h-10 w-10 rounded-full object-cover">
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ $portfolio->user->name }}</p>
                                            <p class="text-sm text-gray-600">{{ $portfolio->judul_kegiatan }}</p>
                                            <p class="text-xs text-gray-400">{{ optional($portfolio->user->prodi)->nama_prodi }} - Angkatan {{ $portfolio->user->angkatan }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-shrink-0 flex-col items-end justify-between gap-2">
                                    <div class="inline-flex items-center gap-1.5 rounded-full px-2 py-1 text-xs font-medium {{ $statusStyles['badge'] }}">
                                        <x-dynamic-component :component="$statusStyles['icon']" class="h-3.5 w-3.5" />
                                        {{ ucfirst(str_replace('_', ' ', $portfolio->status)) }}
                                    </div>
                                    <p class="text-xs text-gray-400">{{ $portfolio->updated_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
                @if ($portfolios->hasPages())
                    <div class="mt-6">
                        {{ $portfolios->links() }}
                    </div>
                @endif
            @else
                {{-- Empty State --}}
                <div class="text-center rounded-xl border-2 border-dashed border-gray-200 bg-white p-12">
                    <x-heroicon-o-document-magnifying-glass class="mx-auto h-12 w-12 text-gray-400" />
                    <h3 class="mt-2 text-sm font-semibold text-gray-900">Tidak Ada Portofolio</h3>
                    <p class="mt-1 text-sm text-gray-500">Tidak ada data portofolio yang cocok dengan filter Anda.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

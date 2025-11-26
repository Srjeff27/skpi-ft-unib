<x-app-layout>
    @php
        $isAdmin = Auth::user()->role === 'admin';
        $pageTitle = $isAdmin ? 'Manajemen Data SKPI' : 'Verifikasi Portofolio';
        $pageDesc = $isAdmin ? 'Pantau seluruh data portofolio mahasiswa.' : 'Tinjau dan validasi pengajuan portofolio mahasiswa.';
    @endphp

    <div class="space-y-8 pb-20">
        
        {{-- Header Section --}}
        <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-slate-900">{{ $pageTitle }}</h2>
                <p class="text-sm text-slate-500">{{ $pageDesc }}</p>
            </div>
            
            {{-- Quick Stats (Optional Context) --}}
            <div class="flex items-center gap-3">
                <div class="px-4 py-2 bg-white rounded-xl border border-slate-200 shadow-sm flex items-center gap-2">
                    <span class="flex h-2.5 w-2.5 rounded-full bg-amber-500"></span>
                    <span class="text-xs font-semibold text-slate-600">Pending: {{ $portfolios->where('status', 'pending')->count() }}</span>
                </div>
            </div>
        </div>

        @if (session('status'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
                 class="flex items-center gap-3 rounded-xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-emerald-700 shadow-sm">
                <x-heroicon-s-check-circle class="h-5 w-5" />
                <span class="text-sm font-medium">{{ session('status') }}</span>
            </div>
        @endif

        {{-- Search & Filter Toolbar --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-1.5 shadow-sm">
            <form method="GET" class="flex flex-col gap-2 lg:flex-row">
                <div class="relative flex-grow">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <x-heroicon-o-magnifying-glass class="h-5 w-5 text-slate-400" />
                    </div>
                    <input type="search" name="search" value="{{ request('search') }}" 
                           placeholder="Cari nama mahasiswa, NIM, atau judul kegiatan..." 
                           class="block w-full rounded-xl border-0 py-2.5 pl-10 text-sm text-slate-900 ring-1 ring-inset ring-slate-200 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-[#1b3985]">
                </div>

                <div class="flex gap-2 overflow-x-auto pb-2 lg:pb-0 no-scrollbar">
                    <select name="prodi_id" class="block w-full rounded-xl border-0 py-2.5 pl-3 pr-8 text-sm text-slate-900 ring-1 ring-inset ring-slate-200 focus:ring-2 focus:ring-inset focus:ring-[#1b3985] sm:w-48">
                        <option value="">Semua Prodi</option>
                        @foreach ($prodis as $p)
                            <option value="{{ $p->id }}" @selected(request('prodi_id') == $p->id)>{{ $p->nama_prodi }}</option>
                        @endforeach
                    </select>

                    <select name="status" class="block w-full rounded-xl border-0 py-2.5 pl-3 pr-8 text-sm text-slate-900 ring-1 ring-inset ring-slate-200 focus:ring-2 focus:ring-inset focus:ring-[#1b3985] sm:w-40">
                        <option value="">Semua Status</option>
                        @foreach (['pending' => 'Menunggu', 'verified' => 'Disetujui', 'rejected' => 'Ditolak', 'requires_revision' => 'Revisi'] as $k => $v)
                            <option value="{{ $k }}" @selected(request('status') == $k)>{{ $v }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-slate-100 px-4 py-2.5 text-slate-700 transition-colors hover:bg-slate-200 hover:text-slate-900">
                        <x-heroicon-m-funnel class="h-5 w-5" />
                    </button>
                </div>
            </form>
        </div>

        {{-- Portfolio List --}}
        <div class="space-y-4">
            @forelse ($portfolios as $portfolio)
                @php
                    $config = match($portfolio->status) {
                        'verified' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'icon' => 'heroicon-s-check-badge', 'ring' => 'ring-emerald-600/20', 'border' => 'border-emerald-200'],
                        'rejected' => ['bg' => 'bg-rose-50', 'text' => 'text-rose-700', 'icon' => 'heroicon-s-x-circle', 'ring' => 'ring-rose-600/20', 'border' => 'border-rose-200'],
                        'requires_revision' => ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-700', 'icon' => 'heroicon-s-arrow-path', 'ring' => 'ring-indigo-600/20', 'border' => 'border-indigo-200'],
                        default => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'icon' => 'heroicon-s-clock', 'ring' => 'ring-amber-600/20', 'border' => 'border-amber-200'],
                    };
                @endphp

                <a href="{{ route('verifikator.portfolios.show', $portfolio) }}" 
                   class="group relative block overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all hover:border-blue-300 hover:shadow-md hover:bg-slate-50/30">
                    
                    <div class="flex flex-col gap-5 sm:flex-row sm:items-center">
                        {{-- User Info --}}
                        <div class="flex items-center gap-4 sm:w-1/4">
                            <div class="relative h-12 w-12 shrink-0">
                                <img src="{{ $portfolio->user->avatar_url }}" alt="{{ $portfolio->user->name }}" 
                                     class="h-full w-full rounded-full object-cover ring-2 ring-slate-100 group-hover:ring-blue-100 transition-all">
                            </div>
                            <div class="min-w-0">
                                <p class="truncate text-sm font-bold text-slate-900 group-hover:text-[#1b3985] transition-colors">
                                    {{ $portfolio->user->name }}
                                </p>
                                <p class="truncate text-xs text-slate-500">
                                    {{ optional($portfolio->user->prodi)->nama_prodi }}
                                </p>
                            </div>
                        </div>

                        {{-- Portfolio Details --}}
                        <div class="flex-1 min-w-0 border-l-0 border-t border-slate-100 pt-4 sm:border-l sm:border-t-0 sm:pl-6 sm:pt-0">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="inline-flex items-center rounded-md bg-slate-100 px-2 py-1 text-xs font-medium text-slate-600">
                                    {{ $portfolio->kategori_portfolio }}
                                </span>
                                <span class="text-xs text-slate-400">&bull;</span>
                                <span class="text-xs text-slate-500 flex items-center gap-1">
                                    <x-heroicon-m-calendar class="h-3.5 w-3.5" />
                                    {{ \Carbon\Carbon::parse($portfolio->tanggal_mulai)->isoFormat('D MMM YYYY') }}
                                </span>
                            </div>
                            <h3 class="text-base font-bold text-slate-800 leading-snug group-hover:text-[#1b3985] transition-colors line-clamp-1">
                                {{ $portfolio->judul_kegiatan }}
                            </h3>
                            <p class="text-xs text-slate-500 mt-1 truncate">
                                {{ $portfolio->penyelenggara }}
                            </p>
                        </div>

                        {{-- Status Badge & Action --}}
                        <div class="flex items-center justify-between gap-4 sm:w-auto sm:flex-col sm:items-end sm:justify-center">
                            <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-medium {{ $config['bg'] }} {{ $config['text'] }} ring-1 ring-inset {{ $config['ring'] }}">
                                <x-dynamic-component :component="$config['icon']" class="h-3.5 w-3.5" />
                                {{ ucfirst(str_replace('_', ' ', $portfolio->status == 'pending' ? 'Menunggu' : ($portfolio->status == 'verified' ? 'Disetujui' : ($portfolio->status == 'requires_revision' ? 'Revisi' : 'Ditolak')))) }}
                            </span>
                            
                            <div class="flex items-center gap-1 text-xs font-medium text-slate-400 group-hover:text-[#1b3985] transition-colors">
                                <span>Review Detail</span>
                                <x-heroicon-m-arrow-right class="h-3 w-3 transition-transform group-hover:translate-x-1" />
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="flex flex-col items-center justify-center py-20 text-center rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50">
                    <div class="rounded-full bg-white p-4 shadow-sm ring-1 ring-slate-100 mb-4">
                        <x-heroicon-o-inbox class="h-12 w-12 text-slate-300" />
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900">Tidak ada data ditemukan</h3>
                    <p class="text-sm text-slate-500 mt-1 max-w-sm">
                        Tidak ada portofolio yang sesuai dengan kriteria pencarian atau filter Anda saat ini.
                    </p>
                    <a href="{{ route('verifikator.portfolios.index') }}" class="mt-4 text-sm font-bold text-[#1b3985] hover:underline">
                        Reset Filter
                    </a>
                </div>
            @endforelse
        </div>

        @if ($portfolios->hasPages())
            <div class="mt-8">
                {{ $portfolios->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
<nav x-data="{ open: false }" class="bg-[#1b3985] border-b border-[#1b3985] text-white">
    {{-- Primary Navigation Menu --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                {{-- Admin mobile hamburger --}}
                @if (auth()->check() && request()->routeIs('admin.*'))
                    <button id="admin-menu-btn"
                        class="md:hidden mr-2 -ml-1 flex items-center justify-center w-10 h-10 rounded-md hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-[#1b3985] focus:ring-white"
                        aria-label="Menu Admin">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
                        </svg>
                    </button>
                @endif
                {{-- Logo --}}
                <div class="shrink-0 flex items-center gap-3">
                    <a href="/" class="flex items-center gap-3">
                        <x-application-logo class="block h-9 w-auto fill-current text-white" />
                        <span class="text-white font-semibold sm:hidden">SKPI FT UNIB</span>
                        <span class="hidden sm:inline text-white font-semibold">SKPI FT Universitas Bengkulu</span>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"></div>
            </div>

            {{-- Desktop Navigation --}}
            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-4">
                @php
                    $roleTop = Auth::user()->role ?? null;
                @endphp
                @if ($roleTop === 'mahasiswa')
                    {{-- Tombol Unduh & Notifikasi Desktop --}}
                    @php
                        $hasVerified = \App\Models\Portfolio::where('user_id', Auth::id())
                            ->where('status', 'verified')
                            ->exists();
                        $canDownloadSkpi = Auth::user()->nomor_skpi || $hasVerified;
                        $unread = Auth::user()->unreadNotifications()->count();
                    @endphp

                    <div class="flex items-center gap-3">
                        <a href="{{ $canDownloadSkpi ? route('student.skpi.download') : '#' }}"
                            class="inline-flex items-center rounded-md px-3 py-1.5 text-sm {{ $canDownloadSkpi ? 'bg-white/10 hover:bg-white/20 text-white' : 'bg-white/5 text-white/50 cursor-not-allowed pointer-events-none' }}">
                            Unduh SKPI
                        </a>

                        <x-dropdown align="right" width="80">
                            {{-- TRIGGER (Tombol Lonceng) --}}
                            <x-slot name="trigger">
                                <button
                                    class="relative inline-flex items-center justify-center rounded-full w-9 h-9 hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-[#1b3985] focus:ring-white">

                                    {{-- DIUBAH: Ikon Lonceng SVG Outline --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                                    </svg>

                                    {{-- Badge Notifikasi Belum Dibaca --}}
                                    @if ($unread > 0)
                                        <span
                                            class="absolute -top-0.5 -right-0.5 inline-flex items-center justify-center min-w-4 h-4 px-1 rounded-full bg-orange-500 text-[10px] font-semibold text-white">{{ $unread }}</span>
                                    @endif
                                </button>
                            </x-slot>

                            {{-- KONTEN DROPDOWN --}}
                            <x-slot name="content">
                                <div class="bg-white rounded-md shadow-lg border border-gray-200">
                                    {{-- Header Dropdown --}}
                                    <div class="px-4 py-3 border-b border-gray-200">
                                        <p class="text-lg font-bold text-gray-800">Notifikasi</p>
                                    </div>

                                    {{-- Daftar Notifikasi --}}
                                    <div class="max-h-80 overflow-y-auto divide-y divide-gray-100">
                                        @php $listNotifs = Auth::user()->notifications()->latest()->take(10)->get(); @endphp
                                        @forelse($listNotifs as $n)
                                            @php
                                                $data = $n->data;
                                                // Logika untuk menentukan ikon dan warna berdasarkan judul notifikasi
                                                $icon = 'heroicon-o-bell';
                                                $color = 'text-gray-400 bg-gray-100';
                                                if (Str::contains(strtolower($data['title'] ?? ''), 'ditolak')) {
                                                    $icon = 'heroicon-o-x-circle';
                                                    $color = 'text-red-500 bg-red-50';
                                                } elseif (
                                                    Str::contains(strtolower($data['title'] ?? ''), 'perbaikan')
                                                ) {
                                                    $icon = 'heroicon-o-pencil-square';
                                                    $color = 'text-amber-500 bg-amber-50';
                                                } elseif (
                                                    Str::contains(strtolower($data['title'] ?? ''), [
                                                        'diterima',
                                                        'disetujui',
                                                        'verified',
                                                    ])
                                                ) {
                                                    $icon = 'heroicon-o-check-circle';
                                                    $color = 'text-green-500 bg-green-50';
                                                }
                                            @endphp
                                            <div
                                                class="flex items-start gap-4 px-4 py-3 hover:bg-gray-50 transition-colors duration-150 {{ is_null($n->read_at) ? 'bg-blue-50' : '' }}">
                                                {{-- Ikon Notifikasi --}}
                                                <div
                                                    class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center {{ $color }}">
                                                    <x-dynamic-component :component="$icon" class="w-5 h-5" />
                                                </div>

                                                {{-- Konten Teks Notifikasi --}}
                                                <div class="flex-grow text-sm">
                                                    <div class="flex justify-between items-baseline">
                                                        <p class="font-semibold text-gray-900">
                                                            {{ $data['title'] ?? 'Notifikasi' }}</p>
                                                        <p class="text-xs text-gray-400 flex-shrink-0 ml-2">
                                                            {{ optional($n->created_at)->diffForHumans() }}</p>
                                                    </div>
                                                    @if (!empty($data['judul_kegiatan']))
                                                        <p class="text-gray-700 mt-0.5">
                                                            {{ Str::limit($data['judul_kegiatan'], 40) }}</p>
                                                    @endif
                                                    @if (!empty($data['message']))
                                                        <p class="text-xs text-gray-500 mt-1">
                                                            {{ Str::limit($data['message'], 50) }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        @empty
                                            <div class="px-4 py-10 text-center">
                                                <p class="text-sm text-gray-500">Belum ada notifikasi baru.</p>
                                            </div>
                                        @endforelse
                                    </div>

                                    {{-- Footer Dropdown --}}
                                    <div class="px-4 py-2 bg-gray-50 border-t border-gray-200 text-center rounded-b-md">
                                        <a class="text-sm font-semibold text-blue-600 hover:underline"
                                            href="{{ route('student.notifications.index') }}">
                                            Lihat semua notifikasi
                                        </a>
                                    </div>
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @elseif (in_array($roleTop, ['admin','verifikator']))
                    @php
                        $pendingQuery = \App\Models\Portfolio::query()->where('status','pending');
                        if ($roleTop==='verifikator' && Auth::user()->prodi_id) {
                            $pendingQuery->whereHas('user', function($qq){ $qq->where('prodi_id', Auth::user()->prodi_id); });
                        }
                        $pendingCount = $pendingQuery->count();
                        $pendingList = (clone $pendingQuery)->latest()->take(10)->with(['user:id,name,prodi_id','user.prodi:id,nama_prodi'])->get();
                        $notifUrl = $roleTop==='admin' ? route('admin.portfolios.index', ['status'=>'pending']) : route('verifikator.portfolios.index', ['status'=>'pending']);
                    @endphp
                    <x-dropdown align="right" width="80">
                        <x-slot name="trigger">
                            <button class="relative inline-flex items-center justify-center rounded-full w-9 h-9 hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-[#1b3985] focus:ring-white">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                                </svg>
                                <span id="pending-badge-desktop" class="absolute -top-0.5 -right-0.5 inline-flex items-center justify-center min-w-4 h-4 px-1 rounded-full bg-orange-500 text-[10px] font-semibold text-white {{ $pendingCount>0 ? '' : 'hidden' }}">{{ $pendingCount }}</span>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="bg-white rounded-md shadow-lg border border-gray-200">
                                <div class="px-4 py-3 border-b border-gray-200">
                                    <p class="text-lg font-bold text-gray-800">Notifikasi</p>
                                    <p class="text-xs text-gray-500">Portofolio menunggu verifikasi</p>
                                </div>

                                <div class="max-h-80 overflow-y-auto divide-y divide-gray-100">
                                    @forelse($pendingList as $pf)
                                        <a href="{{ $roleTop==='admin' ? route('verifikator.portfolios.show', $pf) : route('verifikator.portfolios.show', $pf) }}" class="block px-4 py-3 hover:bg-gray-50">
                                            <div class="flex items-start gap-3">
                                                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                </div>
                                                <div class="flex-1 text-sm">
                                                    <p class="font-semibold text-gray-900">{{ $pf->user->name }}</p>
                                                    <p class="text-gray-600">{{ $pf->kategori_portfolio }}</p>
                                                    <p class="text-xs text-gray-400">{{ optional($pf->tanggal_dokumen)->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                        </a>
                                    @empty
                                        <div class="px-4 py-6 text-center text-sm text-gray-500">Tidak ada notifikasi.</div>
                                    @endforelse
                                </div>

                                <div class="px-4 py-2 bg-gray-50 border-t border-gray-200 text-center rounded-b-md">
                                    <a class="text-sm font-semibold text-blue-600 hover:underline" href="{{ $notifUrl }}">Lihat semua</a>
                                </div>
                            </div>
                        </x-slot>
                    </x-dropdown>
                @endif

                {{-- Profile Dropdown Desktop --}}
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center gap-2 px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-transparent hover:bg-white/10 focus:outline-none transition ease-in-out duration-150">
                            <img class="h-6 w-6 rounded-full object-cover"
                                src="{{ Auth::user()->avatar_url }}"
                                alt="Avatar" />
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @php $roleNav = Auth::user()->role ?? null; @endphp
                        @if (in_array($roleNav, ['admin', 'verifikator']))
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Informasi Akun') }}
                            </x-dropdown-link>
                        @else
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                        @endif

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- Mobile Menu Button --}}
            <div class="-me-2 flex items-center sm:hidden gap-2">
                @if ($roleTop === 'mahasiswa')
                    <a href="{{ route('student.notifications.index') }}"
                        class="relative inline-flex items-center justify-center rounded-full w-8 h-8 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-[#1b3985] focus:ring-white">

                        {{-- DIUBAH: Ikon Lonceng SVG Outline --}}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                        </svg>

                        @if (isset($unread) && $unread > 0)
                            <span
                                class="absolute -top-0.5 -right-0.5 inline-flex items-center justify-center min-w-4 h-4 px-1 rounded-full bg-orange-500 text-[10px] font-semibold">{{ $unread }}</span>
                        @endif
                    </a>
                @elseif (in_array($roleTop, ['admin','verifikator']))
                    @php
                        $pendingQueryM = \App\Models\Portfolio::query()->where('status','pending');
                        if ($roleTop==='verifikator' && Auth::user()->prodi_id) {
                            $pendingQueryM->whereHas('user', function($qq){ $qq->where('prodi_id', Auth::user()->prodi_id); });
                        }
                        $pendingCountM = $pendingQueryM->count();
                        $pendingListM = (clone $pendingQueryM)->latest()->take(10)->with(['user:id,name,prodi_id','user.prodi:id,nama_prodi'])->get();
                        $notifUrlM = $roleTop==='admin' ? route('admin.portfolios.index', ['status'=>'pending']) : route('verifikator.portfolios.index', ['status'=>'pending']);
                    @endphp
                    <x-dropdown align="right" width="64">
                        <x-slot name="trigger">
                            <button class="relative inline-flex items-center justify-center rounded-full w-8 h-8 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-[#1b3985] focus:ring-white">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                                </svg>
                                <span id="pending-badge-mobile" class="absolute -top-0.5 -right-0.5 inline-flex items-center justify-center min-w-4 h-4 px-1 rounded-full bg-orange-500 text-[10px] font-semibold {{ $pendingCountM>0 ? '' : 'hidden' }}">{{ $pendingCountM }}</span>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="bg-white rounded-md shadow-lg border border-gray-200">
                                <div class="px-3 py-2 border-b border-gray-200">
                                    <p class="text-sm font-bold text-gray-800">Notifikasi</p>
                                </div>
                                <div class="max-h-64 overflow-y-auto divide-y divide-gray-100">
                                    @forelse($pendingListM as $pf)
                                        <a href="{{ route('verifikator.portfolios.show', $pf) }}" class="block px-3 py-2 hover:bg-gray-50">
                                            <div class="text-sm font-semibold text-gray-900">{{ $pf->user->name }}</div>
                                            <div class="text-xs text-gray-600">{{ $pf->kategori_portfolio }}</div>
                                        </a>
                                    @empty
                                        <div class="px-3 py-4 text-center text-sm text-gray-500">Tidak ada notifikasi.</div>
                                    @endforelse
                                </div>
                                <div class="px-3 py-2 bg-gray-50 border-t border-gray-200 text-center rounded-b-md">
                                    <a class="text-xs font-semibold text-blue-600 hover:underline" href="{{ $notifUrlM }}">Lihat semua</a>
                                </div>
                            </div>
                        </x-slot>
                    </x-dropdown>
                @endif
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-[#1b3985] focus:ring-white transition duration-150 ease-in-out">
                    <img class="h-8 w-8 rounded-full object-cover"
                        src="{{ Auth::user()->avatar_url }}"
                        alt="Avatar" />
                </button>
            </div>
        </div>
    </div>

    {{-- Responsive Navigation Menu --}}
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden bg-[#1b3985] text-white">
        <div class="pt-4 pb-1 border-t border-white/20">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-white/80">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                @php $roleNav = Auth::user()->role ?? null; @endphp
                @if (in_array($roleNav, ['admin', 'verifikator']))
                    <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                        {{ __('Informasi Akun') }}
                    </x-responsive-nav-link>
                @else
                    <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>
                @endif

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
@php $roleScript = Auth::user()->role ?? null; @endphp
@if (in_array($roleScript, ['admin','verifikator']))
    <script>
        (function(){
            const badgeDesktop = document.getElementById('pending-badge-desktop');
            const badgeMobile = document.getElementById('pending-badge-mobile');
            const url = "{{ $roleScript==='admin' ? route('admin.notifications.count') : route('verifikator.notifications.count') }}";
            async function refreshPending(){
                try{ const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' }}); if(!res.ok) return; const data = await res.json(); const c = data.count ?? 0; if(badgeDesktop){ badgeDesktop.textContent = c; badgeDesktop.classList.toggle('hidden', c<=0); } if(badgeMobile){ badgeMobile.textContent = c; badgeMobile.classList.toggle('hidden', c<=0); } }catch(e){}
            }
            refreshPending();
            setInterval(refreshPending, 20000);
        })();
    </script>
@endif

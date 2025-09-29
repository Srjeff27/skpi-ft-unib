<nav x-data="{ open: false }" class="bg-[#1b3985] border-b border-[#1b3985] text-white">
    {{-- Primary Navigation Menu --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                {{-- Logo --}}
                <div class="shrink-0 flex items-center gap-3">
                    <a href="/" class="flex items-center gap-3">
                        <x-application-logo class="block h-9 w-auto fill-current text-white" />
                        {{-- DIUBAH: Menggunakan dua span untuk teks responsif --}}
                        <span class="text-white font-semibold sm:hidden">SKPI FT UNIB</span>
                        <span class="hidden sm:inline text-white font-semibold">SKPI FT Universitas Bengkulu</span>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"></div>
            </div>

            {{-- Desktop Navigation --}}
            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-4">
                @if (Auth::user()->role === 'mahasiswa')
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
                            <x-slot name="trigger">
                                <button
                                    class="relative inline-flex items-center justify-center rounded-full w-9 h-9 hover:bg-white/10">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="w-5 h-5">
                                        <path
                                            d="M8.625 4.5c0-1.243 1.007-2.25 2.25-2.25s2.25 1.007 2.25 2.25V5.25c2.485 0 4.5 2.015 4.5 4.5v2.25l1.5 1.5v.75h-16.5v-.75l1.5-1.5v-2.25c0-2.485 2.015-4.5 4.5-4.5V4.5Z" />
                                        <path d="M9.75 18a2.25 2.25 0 1 0 4.5 0h-4.5Z" />
                                    </svg>
                                    @if ($unread > 0)
                                        <span
                                            class="absolute -top-0.5 -right-0.5 inline-flex items-center justify-center min-w-4 h-4 px-1 rounded-full bg-orange-500 text-[10px] font-semibold">{{ $unread }}</span>
                                    @endif
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <div class="px-4 py-2 text-sm text-gray-600 font-semibold">Notifikasi</div>
                                <div class="max-h-80 overflow-auto">
                                    @php $listNotifs = Auth::user()->notifications()->latest()->take(5)->get(); @endphp
                                    @forelse($listNotifs as $n)
                                        @php $data = $n->data; @endphp
                                        <div
                                            class="px-4 py-2 border-t text-sm {{ is_null($n->read_at) ? 'bg-orange-50' : '' }}">
                                            <div class="flex items-center justify-between">
                                                <div class="font-medium">{{ $data['title'] ?? 'Notifikasi' }}</div>
                                                <div class="text-xs text-gray-500">
                                                    {{ optional($n->created_at)->diffForHumans() }}</div>
                                            </div>
                                            @if (!empty($data['judul_kegiatan']))
                                                <div class="text-gray-700">{{ $data['judul_kegiatan'] }}</div>
                                            @endif
                                            @if (!empty($data['message']))
                                                <div class="text-xs text-gray-500">{{ $data['message'] }}</div>
                                            @endif
                                        </div>
                                    @empty
                                        <div class="px-4 py-6 text-sm text-gray-500">Belum ada notifikasi.</div>
                                    @endforelse
                                    <div class="px-4 py-2 text-right">
                                        <a class="text-[#1b3985] underline"
                                            href="{{ route('student.notifications.index') }}">Lihat semua</a>
                                    </div>
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endif

                {{-- Profile Dropdown Desktop --}}
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center gap-2 px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-transparent hover:bg-white/10 focus:outline-none transition ease-in-out duration-150">
                            <img class="h-6 w-6 rounded-full object-cover"
                                src="{{ Auth::user()->profile_photo_path ? asset('storage/' . Auth::user()->profile_photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=1b3985&color=fff' }}"
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
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

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
                @if (Auth::user()->role === 'mahasiswa')
                    <a href="{{ route('student.notifications.index') }}"
                        class="relative inline-flex items-center justify-center rounded-full w-8 h-8 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-[#1b3985] focus:ring-white">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-5 h-5">
                            <path
                                d="M8.625 4.5c0-1.243 1.007-2.25 2.25-2.25s2.25 1.007 2.25 2.25V5.25c2.485 0 4.5 2.015 4.5 4.5v2.25l1.5 1.5v.75h-16.5v-.75l1.5-1.5v-2.25c0-2.485 2.015-4.5 4.5-4.5V4.5Z" />
                            <path d="M9.75 18a2.25 2.25 0 1 0 4.5 0h-4.5Z" />
                        </svg>
                        @if (isset($unread) && $unread > 0)
                            <span
                                class="absolute -top-0.5 -right-0.5 inline-flex items-center justify-center min-w-4 h-4 px-1 rounded-full bg-orange-500 text-[10px] font-semibold">{{ $unread }}</span>
                        @endif
                    </a>
                @endif
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-[#1b3985] focus:ring-white transition duration-150 ease-in-out">
                    <img class="h-8 w-8 rounded-full object-cover"
                        src="{{ Auth::user()->profile_photo_path ? asset('storage/' . Auth::user()->profile_photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=fafafa&color=1b3985' }}"
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
                <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

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

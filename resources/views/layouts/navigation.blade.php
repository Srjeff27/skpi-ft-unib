<nav x-data="{ open: false }" class="sticky top-0 z-30 w-full border-b border-gray-200 bg-white/90 backdrop-blur-md transition-all">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between">
            <div class="flex items-center">
                {{-- Left hamburger (for admin/verifier sidebar) --}}
                @if (auth()->check() && (request()->routeIs('admin.*') || request()->routeIs('verifikator.*')))
                    <button @click="isSidebarOpen = !isSidebarOpen"
                        class="mr-3 -ml-2 flex h-10 w-10 items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 hover:text-[#1b3985] focus:outline-none focus:ring-2 focus:ring-[#1b3985] md:hidden">
                        <span class="sr-only">Buka sidebar</span>
                        <x-heroicon-o-bars-3 class="h-6 w-6" />
                    </button>
                @endif

                <div class="flex shrink-0 items-center gap-3">
                    <a href="/" class="flex items-center gap-3 group">
                        <x-application-logo class="block h-9 w-auto fill-current text-[#1b3985] transition-transform group-hover:scale-105" />
                        <div class="sm:hidden leading-tight">
                            <span class="text-sm font-bold text-[#1b3985] tracking-tight">SKPI FT UNIB</span>
                        </div>
                        <div class="hidden sm:flex flex-col">
                            <span class="text-sm font-bold leading-none text-[#1b3985] tracking-tight">SKPI FT</span>
                            <span class="text-[10px] font-medium leading-none text-gray-500">Universitas Bengkulu</span>
                        </div>
                    </a>
                </div>
            </div>

            <div class="flex items-center sm:ms-6">
                {{-- Desktop User Menu --}}
                <div class="hidden sm:flex sm:items-center gap-4">
                    @php
                        $roleTop = Auth::user()->role ?? null;
                        // Dummy notifications per role; replace with real data when available
                        $notifications = [];
                        if ($roleTop === 'mahasiswa') {
                            $notifications = [
                                ['title' => 'Belum ada portofolio baru.', 'time' => 'Baru saja'],
                            ];
                        } elseif ($roleTop === 'admin') {
                            $notifications = [
                                ['title' => 'Tidak ada portofolio pending saat ini.', 'time' => 'Hari ini'],
                            ];
                        } elseif ($roleTop === 'verifikator') {
                            $notifications = [
                                ['title' => 'Belum ada portofolio untuk diverifikasi.', 'time' => 'Hari ini'],
                            ];
                        }
                        $notificationCount = count($notifications);
                        $notificationsIndexRoute = match($roleTop) {
                            'mahasiswa' => route('student.notifications.index'),
                            'admin' => route('admin.notifications.index'),
                            'verifikator' => route('verifikator.notifications.index'),
                            default => '#',
                        };
                    @endphp

                    <x-dropdown align="right" width="80">
                        <x-slot name="trigger">
                            <button class="relative flex h-10 w-10 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-500 transition hover:border-[#1b3985] hover:text-[#1b3985] focus:outline-none">
                                <x-heroicon-o-bell class="h-5 w-5" />
                                @if ($notificationCount > 0)
                                    <span class="absolute -top-1 -right-1 flex h-5 min-w-[20px] items-center justify-center rounded-full bg-red-500 px-1.5 text-[11px] font-bold text-white">{{ $notificationCount }}</span>
                                @endif
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <div class="text-sm font-semibold text-gray-800">Notifikasi</div>
                                <p class="text-xs text-gray-500">Peran: {{ ucfirst($roleTop ?? 'Pengguna') }}</p>
                            </div>
                            <div class="max-h-80 overflow-y-auto divide-y divide-gray-100">
                                @forelse ($notifications as $item)
                                    <div class="px-4 py-3">
                                        <div class="text-sm font-medium text-gray-800">{{ $item['title'] }}</div>
                                        @if (!empty($item['time']))
                                            <div class="text-xs text-gray-500">{{ $item['time'] }}</div>
                                        @endif
                                    </div>
                                @empty
                                    <div class="px-4 py-6 text-center text-sm text-gray-500">Belum ada notifikasi.</div>
                                @endforelse
                            </div>
                            <div class="border-t border-gray-100">
                                <a href="{{ $notificationsIndexRoute }}" class="flex items-center justify-between px-4 py-3 text-sm font-semibold text-[#1b3985] hover:bg-gray-50">
                                    <span>Lihat semua notifikasi</span>
                                    <x-heroicon-o-arrow-right class="h-4 w-4" />
                                </a>
                            </div>
                        </x-slot>
                    </x-dropdown>

                    <div class="h-6 w-px bg-gray-200"></div>

                    <x-dropdown align="right" width="60">
                        <x-slot name="trigger">
                            <button class="group flex items-center gap-2 rounded-full py-1 pl-1 pr-2 text-sm font-medium transition hover:bg-gray-50 focus:outline-none">
                                <div class="relative h-8 w-8 overflow-hidden rounded-full border border-gray-200 shadow-sm transition group-hover:border-[#1b3985]">
                                    <img class="h-full w-full object-cover" src="{{ Auth::user()->avatar_url }}" alt="Avatar" />
                                </div>
                                <div class="hidden flex-col items-start lg:flex">
                                    <span class="text-xs font-bold text-gray-700 group-hover:text-[#1b3985]">{{ Str::limit(Auth::user()->name, 12) }}</span>
                                </div>
                                <x-heroicon-o-chevron-down class="h-4 w-4 text-gray-400 transition group-hover:text-gray-600" />
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="border-b border-gray-100 bg-gray-50/80 px-4 py-3">
                                <p class="truncate text-sm font-bold text-[#1b3985]">{{ Auth::user()->name }}</p>
                                <p class="truncate text-xs text-gray-500">{{ Auth::user()->email }}</p>
                            </div>
    
                            <div class="py-1">
                                <a href="{{ route('profile.edit') }}" class="flex w-full items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#1b3985]">
                                    <x-heroicon-o-user-circle class="h-4 w-4 text-gray-400" />
                                    {{ __('Profile') }}
                                </a>
    
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex w-full items-center gap-2 px-4 py-2 text-start text-sm text-red-600 hover:bg-red-50">
                                        <x-heroicon-o-arrow-left-on-rectangle class="h-4 w-4 text-red-400" />
                                        {{ __('Log Out') }}
                                    </button>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>

                {{-- Mobile User Menu Trigger (Avatar) --}}
                <div class="-me-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center rounded-full h-10 w-10 text-gray-400 hover:bg-gray-100 focus:outline-none">
                        <span class="sr-only">Buka menu user</span>
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->avatar_url }}" alt="Avatar" />
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Mobile User Menu Panel --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden bg-white sm:hidden border-t border-gray-100">
        <div class="border-b border-gray-100 bg-gray-50 pb-3 pt-4">
            <div class="px-4 mb-3 flex items-center gap-3">
                <img src="{{ asset('images/logo-ft.png') }}" alt="Logo" class="h-10 w-auto">
                <div>
                    <div class="text-base font-bold text-[#1b3985]">SKPI FT</div>
                    <div class="text-xs font-semibold text-gray-600 -mt-0.5">Universitas Bengkulu</div>
                </div>
            </div>
            <div class="flex items-center px-4">
                <div class="shrink-0">
                    <img class="h-10 w-10 rounded-full border border-gray-200 object-cover" src="{{ Auth::user()->avatar_url }}" alt="Avatar" />
                </div>
                <div class="ml-3">
                    <div class="text-base font-bold text-[#1b3985]">{{ Auth::user()->name }}</div>
                    <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>
        </div>

        <div class="space-y-1 py-2 bg-white">
            <div class="px-4 pb-2">
                <div class="text-sm font-semibold text-gray-800">Notifikasi</div>
                @if (($notificationCount ?? 0) === 0)
                    <p class="text-sm text-gray-500">Belum ada notifikasi.</p>
                @else
                    <div class="mt-2 space-y-2">
                        @foreach ($notifications as $item)
                            <div class="rounded-lg border border-gray-100 bg-gray-50 px-3 py-2">
                                <div class="text-sm font-medium text-gray-800">{{ $item['title'] }}</div>
                                @if (!empty($item['time']))
                                    <div class="text-xs text-gray-500">{{ $item['time'] }}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
                <div class="mt-3">
                    <a href="{{ $notificationsIndexRoute ?? '#' }}" class="flex items-center justify-between rounded-lg border border-gray-100 px-3 py-2 text-sm font-semibold text-[#1b3985] hover:bg-gray-50">
                        <span>Lihat semua notifikasi</span>
                        <x-heroicon-o-arrow-right class="h-4 w-4" />
                    </a>
                </div>
            </div>

            <a href="{{ route('profile.edit') }}" class="flex w-full items-center gap-3 border-l-4 border-transparent px-4 py-2.5 text-base font-medium text-gray-600 transition duration-150 ease-in-out hover:border-[#1b3985] hover:bg-gray-50 hover:text-[#1b3985]">
                <x-heroicon-o-user-circle class="h-5 w-5 text-gray-400" />
                {{ __('Profile') }}
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex w-full items-center gap-3 border-l-4 border-transparent px-4 py-2.5 text-base font-medium text-red-600 transition duration-150 ease-in-out hover:border-red-300 hover:bg-red-50 hover:text-red-800">
                    <x-heroicon-o-arrow-left-on-rectangle class="h-5 w-5 text-red-400" />
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>
</nav>

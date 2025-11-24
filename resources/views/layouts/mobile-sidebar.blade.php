<!-- Mobile Off-canvas Sidebar for Admin/Verifier -->
@if (auth()->check() && (request()->routeIs('admin.*') || request()->routeIs('verifikator.*')))
    <!-- Backdrop -->
    <div 
        x-show="isSidebarOpen" 
        @click="isSidebarOpen = false" 
        x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-30 bg-black/30 md:hidden" 
        x-cloak>
    </div>

    <!-- Sidebar Panel -->
    <aside 
        :class="isSidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed inset-y-0 left-0 z-40 flex w-64 shrink-0 transform flex-col border-r border-gray-200 bg-white transition-transform duration-300 ease-in-out md:hidden"
        x-cloak>
        <div class="flex h-16 shrink-0 items-center justify-end border-b border-gray-200 px-4">
            <button @click="isSidebarOpen = false" class="rounded-lg p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-600">
                <x-heroicon-o-x-mark class="h-6 w-6" />
            </button>
        </div>

        {{-- Navigation Links --}}
        <nav class="flex-1 overflow-y-auto p-3 text-sm space-y-1">
            @php
                if (!function_exists('getLinkClass')) {
                    function getLinkClass($routeName) {
                        $baseClasses = 'flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors';
                        $activeClasses = 'bg-[#1b3985] text-white';
                        $inactiveClasses = 'text-gray-600 hover:bg-gray-100 hover:text-gray-900';
                        return request()->routeIs($routeName) ? $baseClasses . ' ' . $activeClasses : $baseClasses . ' ' . $inactiveClasses;
                    }
                }
                if (!function_exists('getIconClass')) {
                    function getIconClass($routeName) {
                        $baseClasses = 'h-5 w-5';
                        $activeClasses = 'text-white';
                        $inactiveClasses = 'text-gray-400 group-hover:text-gray-600';
                        return request()->routeIs($routeName) ? $baseClasses . ' ' . $activeClasses : $baseClasses . ' ' . $inactiveClasses;
                    }
                }
                $isAdminArea = request()->routeIs('admin.*');
                $isVerifierArea = request()->routeIs('verifikator.*');
                $role = auth()->user()->role ?? null;
            @endphp

            @if ($isAdminArea)
                <a href="{{ route('admin.dashboard') }}" class="{{ getLinkClass('admin.dashboard') }}">
                    <x-heroicon-o-home class="{{ getIconClass('admin.dashboard') }}" /><span>Dashboard</span>
                </a>
                <div class="mt-4 mb-2 px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Manajemen</div>
                <a href="{{ route('admin.students.index') }}" class="{{ getLinkClass('admin.students.*') }}">
                    <x-heroicon-o-users class="{{ getIconClass('admin.students.*') }}" /><span>Mahasiswa</span>
                </a>
                <a href="{{ route('admin.verifikators.index') }}" class="{{ getLinkClass('admin.verifikators.*') }}">
                    <x-heroicon-o-user-group class="{{ getIconClass('admin.verifikators.*') }}" /><span>Verifikator</span>
                </a>
                <a href="{{ route('admin.pejabat.index') }}" class="{{ getLinkClass('admin.pejabat.*') }}">
                    <x-heroicon-o-user-circle class="{{ getIconClass('admin.pejabat.*') }}" /><span>Pejabat</span>
                </a>
                <a href="{{ route('admin.prodis.index') }}" class="{{ getLinkClass('admin.prodis.*') }}">
                    <x-heroicon-o-academic-cap class="{{ getIconClass('admin.prodis.*') }}" /><span>Program Studi</span>
                </a>
                <a href="{{ route('admin.cpl.index') }}" class="{{ getLinkClass('admin.cpl.*') }}">
                    <x-heroicon-o-book-open class="{{ getIconClass('admin.cpl.*') }}" /><span>Kurikulum & CPL</span>
                </a>
                <a href="{{ route('admin.portfolio-categories.index') }}" class="{{ getLinkClass('admin.portfolio-categories.*') }}">
                    <x-heroicon-o-tag class="{{ getIconClass('admin.portfolio-categories.*') }}" /><span>Kategori Portofolio</span>
                </a>
                
                <div class="mt-4 mb-2 px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">SKPI</div>
                <a href="{{ route('admin.portfolios.index') }}" class="{{ getLinkClass('admin.portfolios.*') }}">
                    <x-heroicon-o-document-duplicate class="{{ getIconClass('admin.portfolios.*') }}" /><span>Data SKPI</span>
                </a>
                <a href="{{ route('admin.cetak_skpi.index') }}" class="{{ getLinkClass('admin.cetak_skpi.*') }}">
                    <x-heroicon-o-printer class="{{ getIconClass('admin.cetak_skpi.*') }}" /><span>Cetak SKPI</span>
                </a>

                <div class="mt-4 mb-2 px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Sistem</div>
                <a href="{{ route('admin.announcements.index') }}" class="{{ getLinkClass('admin.announcements.*') }}">
                    <x-heroicon-o-megaphone class="{{ getIconClass('admin.announcements.*') }}" /><span>Pengumuman</span>
                </a>
                <a href="{{ route('admin.system_settings.index') }}" class="{{ getLinkClass('admin.system_settings.*') }}">
                    <x-heroicon-o-cog-6-tooth class="{{ getIconClass('admin.system_settings.*') }}" /><span>Pengaturan</span>
                </a>
                <a href="{{ route('admin.activity_logs.index') }}" class="{{ getLinkClass('admin.activity_logs.*') }}">
                    <x-heroicon-o-clipboard-document-list class="{{ getIconClass('admin.activity_logs.*') }}" /><span>Log Aktivitas</span>
                </a>

            @elseif($isVerifierArea)
                @if ($role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-900 mb-4 border-b pb-4">
                        <x-heroicon-o-arrow-left class="h-5 w-5 text-gray-400" /><span>Kembali ke Admin</span>
                    </a>
                @endif
                <a href="{{ route('verifikator.dashboard') }}" class="{{ getLinkClass('verifikator.dashboard') }}">
                    <x-heroicon-o-home class="{{ getIconClass('verifikator.dashboard') }}" /><span>Dashboard</span>
                </a>
                <a href="{{ route('verifikator.portfolios.index') }}" class="{{ getLinkClass('verifikator.portfolios.*') }}">
                    <x-heroicon-o-document-check class="{{ getIconClass('verifikator.portfolios.*') }}" /><span>Verifikasi Portofolio</span>
                </a>
                <a href="{{ route('verifikator.students.index') }}" class="{{ getLinkClass('verifikator.students.*') }}">
                    <x-heroicon-o-users class="{{ getIconClass('verifikator.students.*') }}" /><span>Data Mahasiswa</span>
                </a>
            @endif
        </nav>
    </aside>
@endif

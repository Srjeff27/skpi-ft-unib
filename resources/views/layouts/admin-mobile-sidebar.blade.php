{{-- Mobile-only offcanvas sidebar for Admin area --}}
<div class="md:hidden">
    <div id="admin-sidebar-backdrop" class="fixed inset-0 bg-black/30 hidden z-40"></div>
    <aside id="admin-sidebar"
        class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 shadow-xl transform -translate-x-full transition-transform duration-200 ease-out">
        <div class="h-16 flex items-center justify-between px-4 border-b border-gray-100">
            <div class="font-semibold text-[#1b3985]">Menu Admin</div>
            <button id="admin-sidebar-close" class="p-2 rounded-md text-gray-500 hover:bg-gray-100" aria-label="Tutup">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd" d="M6.225 4.811a.75.75 0 011.06 0L12 9.525l4.715-4.714a.75.75 0 111.06 1.06L13.06 10.586l4.715 4.714a.75.75 0 11-1.06 1.06L12 11.646l-4.715 4.714a.75.75 0 11-1.06-1.06l4.714-4.715-4.714-4.715a.75.75 0 010-1.06z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
        <nav class="p-3 text-sm">
            <a href="{{ route('admin.dashboard') }}" class="block rounded px-3 py-2 {{ request()->routeIs('admin.dashboard') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Dashboard</a>
            <a href="{{ route('admin.students.index') }}" class="mt-1 block rounded px-3 py-2 {{ request()->routeIs('admin.students.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Manajemen Mahasiswa</a>
            <a href="{{ route('admin.verifikators.index') }}" class="mt-1 block rounded px-3 py-2 {{ request()->routeIs('admin.verifikators.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Manajemen Verifikator</a>

            <div class="mt-3 mb-1 px-3 text-xs font-semibold text-gray-400">Manajemen Akademik</div>
            <a href="{{ route('admin.prodis.index') }}" class="block rounded px-3 py-2 {{ request()->routeIs('admin.prodis.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Program Studi</a>
            <a href="{{ route('admin.cpl.index') }}" class="mt-1 block rounded px-3 py-2 {{ request()->routeIs('admin.cpl.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Kurikulum & CPL</a>

            <div class="mt-3 mb-1 px-3 text-xs font-semibold text-gray-400">SKPI</div>
            <a href="{{ route('admin.portfolios.index') }}" class="block rounded px-3 py-2 {{ request()->routeIs('admin.portfolios.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Manajemen Data SKPI</a>
            <a href="{{ route('admin.cetak_skpi.index') }}" class="mt-1 block rounded px-3 py-2 {{ request()->routeIs('admin.cetak_skpi.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Cetak SKPI</a>

            <a href="{{ route('admin.announcements.index') }}" class="mt-3 block rounded px-3 py-2 {{ request()->routeIs('admin.announcements.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Pengumuman</a>
            <a href="{{ route('admin.reports.index') }}" class="mt-1 block rounded px-3 py-2 {{ request()->routeIs('admin.reports.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Monitoring & Laporan</a>
            <a href="{{ route('admin.finalisasi.index') }}" class="mt-1 block rounded px-3 py-2 {{ request()->routeIs('admin.finalisasi.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Finalisasi Data</a>
            <a href="{{ route('admin.penerbitan.index') }}" class="mt-1 block rounded px-3 py-2 {{ request()->routeIs('admin.penerbitan.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Penerbitan SKPI</a>
            <a href="{{ route('admin.pejabat.index') }}" class="mt-1 block rounded px-3 py-2 {{ request()->routeIs('admin.pejabat.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Kelola Pejabat</a>
            <a href="{{ route('admin.system_settings.index') }}" class="mt-1 block rounded px-3 py-2 {{ request()->routeIs('admin.system_settings.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Pengaturan Sistem</a>
            <a href="{{ route('admin.pengaturan.index') }}" class="mt-1 block rounded px-3 py-2 {{ request()->routeIs('admin.pengaturan.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Keamanan & Pengaturan</a>
        </nav>
    </aside>
</div>

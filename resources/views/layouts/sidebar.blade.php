<aside class="hidden md:block w-56 shrink-0">
    <nav class="bg-white rounded-xl shadow-sm border border-gray-100 p-3 text-sm">
        @php
            $isAdminArea = request()->routeIs('admin.*');
            $isVerifierArea = request()->routeIs('verifikator.*');
        @endphp

        @if ($isAdminArea)
            <a href="{{ route('admin.dashboard') }}" class="block rounded px-3 py-2 {{ request()->routeIs('admin.dashboard') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Dashboard</a>

            <div class="mt-3 mb-1 px-3 text-xs font-semibold text-gray-400">Manajemen Pengguna</div>
            <a href="{{ route('admin.students.index') }}" class="block rounded px-3 py-2 {{ request()->routeIs('admin.students.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Manajemen Mahasiswa</a>
            <a href="{{ route('admin.verifikators.index') }}" class="mt-1 block rounded px-3 py-2 {{ request()->routeIs('admin.verifikators.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Manajemen Verifikator</a>
            <a href="{{ route('admin.pejabat.index') }}" class="mt-1 block rounded px-3 py-2 {{ request()->routeIs('admin.pejabat.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Kelola Pejabat</a>
            <a href="{{ route('admin.users.index') }}" class="sr-only">Manajemen User</a>

            <div class="mt-3 mb-1 px-3 text-xs font-semibold text-gray-400">Data Akademik</div>
            <a href="{{ route('admin.prodis.index') }}" class="block rounded px-3 py-2 {{ request()->routeIs('admin.prodis.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Program Studi</a>
            <a href="{{ route('admin.cpl.index') }}" class="mt-1 block rounded px-3 py-2 {{ request()->routeIs('admin.cpl.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Kurikulum & CPL</a>
            <a href="{{ route('admin.portfolio-categories.index') }}" class="mt-1 block rounded px-3 py-2 {{ request()->routeIs('admin.portfolio-categories.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Manajemen Kategori Portofolio</a>

            <div class="mt-3 mb-1 px-3 text-xs font-semibold text-gray-400">Manajemen SKPI</div>
            <a href="{{ route('admin.portfolios.index') }}" class="block rounded px-3 py-2 {{ request()->routeIs('admin.portfolios.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Manajemen Data SKPI</a>
            <a href="{{ route('admin.reports.index') }}" class="mt-1 block rounded px-3 py-2 {{ request()->routeIs('admin.reports.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Monitoring & Laporan</a>
            <a href="{{ route('admin.finalisasi.index') }}" class="mt-1 block rounded px-3 py-2 {{ request()->routeIs('admin.finalisasi.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Finalisasi Data</a>
            <a href="{{ route('admin.penerbitan.index') }}" class="mt-1 block rounded px-3 py-2 {{ request()->routeIs('admin.penerbitan.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Penerbitan SKPI</a>
            <a href="{{ route('admin.cetak_skpi.index') }}" class="mt-1 block rounded px-3 py-2 {{ request()->routeIs('admin.cetak_skpi.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Cetak SKPI</a>

            <div class="mt-3 mb-1 px-3 text-xs font-semibold text-gray-400">Pengaturan Sistem</div>
            <a href="{{ route('admin.announcements.index') }}" class="block rounded px-3 py-2 {{ request()->routeIs('admin.announcements.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Pengumuman</a>
            <a href="{{ route('admin.system_settings.index') }}" class="mt-1 block rounded px-3 py-2 {{ request()->routeIs('admin.system_settings.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Pengaturan Sistem</a>
            <a href="{{ route('admin.pengaturan.index') }}" class="mt-1 block rounded px-3 py-2 {{ request()->routeIs('admin.pengaturan.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Keamanan & Pengaturan</a>
        @elseif($isVerifierArea)
            @php $userRole = auth()->user()->role ?? null; @endphp
            @if ($userRole === 'admin')
                <a href="{{ route('admin.dashboard') }}"
                    class="block rounded px-3 py-2 bg-orange-500 text-white hover:bg-orange-600 mb-3 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali Ke Beranda Admin
                </a>
            @endif
            <a href="{{ route('verifikator.dashboard') }}"
                class="block rounded px-3 py-2 {{ request()->routeIs('verifikator.dashboard') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Dashboard</a>
            <a href="{{ route('verifikator.portfolios.index') }}"
                class="mt-1 block rounded px-3 py-2 {{ request()->routeIs('verifikator.portfolios.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Verifikasi
                Portofolio</a>
            <a href="{{ route('verifikator.students.index') }}"
                class="mt-1 block rounded px-3 py-2 {{ request()->routeIs('verifikator.students.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Data
                Mahasiswa</a>
        @else
            @php $role = auth()->user()->role ?? null; @endphp
            @if ($role === 'mahasiswa')
                <a href="{{ route('dashboard') }}"
                    class="block rounded px-3 py-2 {{ request()->routeIs('dashboard') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Dashboard</a>
                <a href="{{ route('profile.edit') }}"
                    class="mt-1 block rounded px-3 py-2 {{ request()->routeIs('profile.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Profil</a>
                <a href="{{ route('student.portfolios.index') }}"
                    class="mt-1 block rounded px-3 py-2 {{ request()->routeIs('student.portfolios.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Portfolio</a>
                <a href="{{ route('student.documents.index') }}"
                    class="mt-1 block rounded px-3 py-2 {{ request()->routeIs('student.documents.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Dokumen
                    SKPI</a>
                {{-- Notifikasi dihapus dari sidebar mahasiswa sesuai permintaan --}}
            @else
                {{-- On profile page for admin/verifikator, only show back-to-dashboard link --}}
                @if (in_array($role, ['admin', 'verifikator']))
                    @php
                        $backRoute = $role === 'admin' ? route('admin.dashboard') : route('verifikator.dashboard');
                    @endphp
                    <a href="{{ $backRoute }}"
                        class="block rounded px-3 py-2 text-gray-900 hover:bg-blue-50">Kembali Keberanda</a>
                @else
                    <a href="{{ route('profile.edit') }}"
                        class="block rounded px-3 py-2 {{ request()->routeIs('profile.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Profil</a>
                @endif
            @endif
        @endif
    </nav>
</aside>

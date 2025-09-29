<aside class="hidden md:block w-56 shrink-0">
    <nav class="bg-white rounded-xl shadow-sm border border-gray-100 p-3 text-sm">
        @php $isAdminArea = request()->routeIs('admin.*'); $isVerifierArea = request()->routeIs('verifikator.*'); @endphp

        @if($isAdminArea)
            <a href="{{ route('admin.dashboard') }}" class="block rounded px-3 py-2 {{ request()->routeIs('admin.dashboard') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Dashboard</a>
            <a href="{{ route('admin.students.index') }}" class="mt-1 block rounded px-3 py-2 {{ request()->routeIs('admin.students.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Manajemen Mahasiswa</a>
            <a href="{{ route('admin.verifikators.index') }}" class="mt-1 block rounded px-3 py-2 {{ request()->routeIs('admin.verifikators.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Manajemen Verifikator</a>
            <a href="{{ route('admin.users.index') }}" class="sr-only">Manajemen User</a>
            <a href="{{ route('admin.prodis.index') }}" class="mt-1 block rounded px-3 py-2 {{ request()->routeIs('admin.prodis.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Manajemen Prodi</a>
            <a href="{{ route('admin.portfolio-categories.index') }}" class="mt-1 block rounded px-3 py-2 {{ request()->routeIs('admin.portfolio-categories.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Manajemen Kategori Portofolio</a>
            <a href="{{ route('admin.portfolios.index') }}" class="mt-1 block rounded px-3 py-2 {{ request()->routeIs('admin.portfolios.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Manajemen Data SKPI</a>
            <a href="{{ route('admin.portfolios.index') }}?status=pending" class="mt-1 block rounded px-3 py-2 text-gray-900 hover:bg-blue-50">Verifikasi</a>
            <a href="{{ route('admin.announcements.index') }}" class="mt-1 block rounded px-3 py-2 {{ request()->routeIs('admin.announcements.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Notifikasi</a>
            <a href="{{ route('admin.reports.index') }}" class="mt-1 block rounded px-3 py-2 {{ request()->routeIs('admin.reports.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Monitoring & Laporan</a>
            <a href="{{ route('admin.finalisasi.index') }}" class="mt-1 block rounded px-3 py-2 {{ request()->routeIs('admin.finalisasi.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Finalisasi Data</a>
            <a href="{{ route('admin.penerbitan.index') }}" class="mt-1 block rounded px-3 py-2 {{ request()->routeIs('admin.penerbitan.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Penerbitan SKPI</a>
            <a href="{{ route('admin.pengaturan.index') }}" class="mt-1 block rounded px-3 py-2 {{ request()->routeIs('admin.pengaturan.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Keamanan & Pengaturan</a>
        @elseif($isVerifierArea)
            <a href="{{ route('verifikator.dashboard') }}" class="block rounded px-3 py-2 {{ request()->routeIs('verifikator.dashboard') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Dashboard</a>
            <a href="{{ route('verifikator.portfolios.index') }}" class="mt-1 block rounded px-3 py-2 {{ request()->routeIs('verifikator.portfolios.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Verifikasi Portofolio</a>
        @else
            @php $role = auth()->user()->role ?? null; @endphp
            @if($role === 'mahasiswa')
                <a href="{{ route('dashboard') }}" class="block rounded px-3 py-2 {{ request()->routeIs('dashboard') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Dashboard</a>
                <a href="{{ route('profile.edit') }}" class="mt-1 block rounded px-3 py-2 {{ request()->routeIs('profile.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Profil</a>
                <a href="{{ route('student.portfolios.index') }}" class="mt-1 block rounded px-3 py-2 {{ request()->routeIs('student.portfolios.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Portfolio</a>
                <a href="{{ route('student.documents.index') }}" class="mt-1 block rounded px-3 py-2 {{ request()->routeIs('student.documents.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Dokumen SKPI</a>
                <a href="{{ route('student.notifications.index') }}" class="mt-1 block rounded px-3 py-2 {{ request()->routeIs('student.notifications.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Notifikasi</a>
            @else
                <a href="{{ route('profile.edit') }}" class="block rounded px-3 py-2 {{ request()->routeIs('profile.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Profil</a>
                @if($role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="mt-1 block rounded px-3 py-2 text-gray-900 hover:bg-blue-50">Ke Admin</a>
                @elseif($role === 'verifikator')
                    <a href="{{ route('verifikator.dashboard') }}" class="mt-1 block rounded px-3 py-2 text-gray-900 hover:bg-blue-50">Ke Verifikator</a>
                @endif
            @endif
        @endif
    </nav>
</aside>

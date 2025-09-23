<aside class="hidden md:block w-56 shrink-0">
    <nav class="bg-white rounded-xl shadow-sm border border-gray-100 p-3 text-sm">
        <a href="{{ route('dashboard') }}" class="block rounded px-3 py-2 {{ request()->routeIs('dashboard') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Dashboard</a>
        <a href="{{ route('profile.edit') }}" class="mt-1 block rounded px-3 py-2 {{ request()->routeIs('profile.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Profil</a>
        <a href="{{ route('student.portfolios.index') }}" class="mt-1 block rounded px-3 py-2 {{ request()->routeIs('student.portfolios.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Portfolio</a>
        <a href="{{ route('student.documents.index') }}" class="mt-1 block rounded px-3 py-2 {{ request()->routeIs('student.documents.*') ? 'bg-[#1b3985] text-white' : 'text-gray-900 hover:bg-blue-50' }}">Dokumen SKPI</a>
    </nav>
</aside>


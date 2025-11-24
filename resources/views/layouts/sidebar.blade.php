<aside class="hidden md:block w-60 shrink-0">
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
    @endphp
    <nav class="p-3 text-sm space-y-1">
        @php
            $isAdminArea = request()->routeIs('admin.*');
            $isVerifierArea = request()->routeIs('verifikator.*');
            $role = auth()->user()->role ?? null;
        @endphp

        @if ($isAdminArea)
            {{-- Admin links --}}
        @elseif($isVerifierArea)
            {{-- Verifier links --}}
        @else
            @if ($role === 'mahasiswa')
                <a href="{{ route('dashboard') }}" class="{{ getLinkClass('dashboard') }}">
                    <x-heroicon-o-home class="{{ getIconClass('dashboard') }}" /><span>Dashboard</span>
                </a>
                <a href="{{ route('student.portfolios.index') }}" class="{{ getLinkClass('student.portfolios.*') }}">
                    <x-heroicon-o-briefcase class="{{ getIconClass('student.portfolios.*') }}" /><span>Portofolio</span>
                </a>
                <a href="{{ route('student.documents.index') }}" class="{{ getLinkClass('student.documents.*') }}">
                    <x-heroicon-o-document-text class="{{ getIconClass('student.documents.*') }}" /><span>Dokumen SKPI</span>
                </a>
                <a href="{{ route('profile.edit') }}" class="{{ getLinkClass('profile.edit') }}">
                    <x-heroicon-o-user-circle class="{{ getIconClass('profile.edit') }}" /><span>Profil Saya</span>
                </a>
            @endif
        @endif
    </nav>
</aside>
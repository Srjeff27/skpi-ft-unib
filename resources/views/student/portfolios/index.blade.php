<x-app-layout>
    @php
        $user = auth()->user();
        // Fetch all portfolios for frontend filtering
        $portfolios = \App\Models\Portfolio::where('user_id', $user->id)
            ->latest()
            ->get();
        
        $stats = [
            'semua' => $portfolios->count(),
            'verified' => $portfolios->where('status', 'verified')->count(),
            'pending' => $portfolios->where('status', 'pending')->count(),
            'rejected' => $portfolios->whereIn('status', ['rejected', 'requires_revision'])->count(),
        ];
    @endphp

    <div class="space-y-6" x-data="{ tab: 'semua' }">
        <div class="relative rounded-xl bg-gradient-to-r from-[#1b3985] to-[#2b50a8] p-6 overflow-hidden">
            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="space-y-2">
                    <h1 class="text-2xl font-bold text-white">Portofolio Saya</h1>
                    <p class="text-blue-200 max-w-md">Kelola, tambah, dan lihat status semua portofolio kegiatan Anda di sini.</p>
                </div>
                <a href="{{ route('student.portfolios.create') }}" class="flex-shrink-0 w-full md:w-auto inline-flex items-center justify-center rounded-lg bg-white/10 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-white/20 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-blue-800 focus:ring-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" /></svg>
                    Tambah Portofolio
                </a>
            </div>
            <div class="absolute -bottom-12 -right-12 w-40 h-40 rounded-full bg-blue-800 opacity-50"></div>
        </div>

        @if (session('status'))
            <div class="p-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
                {{ session('status') }}
            </div>
        @endif

        @if ($portfolios->isEmpty())
            <div class="text-center py-16 px-6 bg-white rounded-xl shadow-sm border border-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">Belum ada portofolio</h3>
                <p class="mt-1 text-sm text-gray-500">Mulai kumpulkan prestasi dan pengalaman Anda sekarang.</p>
                <div class="mt-6">
                    <a href="{{ route('student.portfolios.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#F97316] hover:bg-[#E8630B] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F97316]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" /></svg>
                        Unggah Portofolio Pertama
                    </a>
                </div>
            </div>
        @else
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-6 px-6" aria-label="Tabs">
                        <button @click="tab = 'semua'" :class="tab === 'semua' ? 'border-[#1b3985] text-[#1b3985]' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">Semua <span class="ml-1.5 rounded-full bg-gray-200 text-gray-700 px-2 py-0.5 text-xs">{{ $stats['semua'] }}</span></button>
                        <button @click="tab = 'verified'" :class="tab === 'verified' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">Disetujui <span class="ml-1.5 rounded-full bg-green-100 text-green-800 px-2 py-0.5 text-xs">{{ $stats['verified'] }}</span></button>
                        <button @click="tab = 'pending'" :class="tab === 'pending' ? 'border-yellow-500 text-yellow-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">Menunggu <span class="ml-1.5 rounded-full bg-yellow-100 text-yellow-800 px-2 py-0.5 text-xs">{{ $stats['pending'] }}</span></button>
                        <button @click="tab = 'rejected'" :class="tab === 'rejected' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">Ditolak <span class="ml-1.5 rounded-full bg-red-100 text-red-800 px-2 py-0.5 text-xs">{{ $stats['rejected'] }}</span></button>
                    </nav>
                </div>

                <div class="flow-root">
                    <ul role="list" class="divide-y divide-gray-200">
                        @foreach ($portfolios as $p)
                            <li x-show="tab === 'semua' || tab === '{{ $p->status }}' || (tab === 'rejected' && ('{{ $p->status }}' === 'rejected' || '{{ $p->status }}' === 'requires_revision'))" x-cloak class="p-6 hover:bg-gray-50/50 transition-colors">
                                @include('student.portfolios._portfolio-list-item', ['portfolio' => $p])
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>

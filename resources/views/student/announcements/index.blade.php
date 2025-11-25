<x-app-layout>
    <div class="space-y-8 pb-12">
        
        {{-- 1. Header Section --}}
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900 via-[#1b3985] to-[#2b50a8] shadow-xl group">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 h-64 w-64 rounded-full bg-white/5 blur-3xl pointer-events-none group-hover:bg-white/10 transition-colors duration-700"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 h-40 w-40 rounded-full bg-blue-400/10 blur-2xl pointer-events-none"></div>

            <div class="relative z-10 p-8 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="space-y-2">
                    <h1 class="text-3xl font-bold text-white tracking-tight">Papan Pengumuman</h1>
                    <p class="text-blue-100/90 text-sm md:text-base max-w-xl leading-relaxed">
                        Informasi terkini seputar akademik, kemahasiswaan, dan berita kampus. Pantau terus agar tidak ketinggalan jadwal penting.
                    </p>
                </div>
                <div class="hidden md:block">
                    <div class="h-14 w-14 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center text-white border border-white/20 shadow-lg rotate-12 group-hover:rotate-0 transition-transform duration-500">
                        <x-heroicon-o-megaphone class="w-7 h-7" />
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. Announcement Grid --}}
        @if ($announcements->isEmpty())
            <div class="flex flex-col items-center justify-center py-20 bg-white rounded-2xl border border-dashed border-slate-300">
                <div class="p-4 rounded-full bg-slate-50 mb-4 ring-1 ring-slate-100">
                    <x-heroicon-o-newspaper class="w-10 h-10 text-slate-400" />
                </div>
                <h3 class="text-lg font-bold text-slate-800">Belum Ada Pengumuman</h3>
                <p class="text-sm text-slate-500 mt-1">Saat ini belum ada informasi baru yang dipublikasikan.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                @foreach ($announcements as $announcement)
                    @php
                        // Logic untuk badge "BARU" (kurang dari 7 hari)
                        $isNew = \Carbon\Carbon::parse($announcement->published_at)->diffInDays(now()) <= 7;
                    @endphp

                    <div class="group relative flex flex-col h-full bg-white rounded-2xl shadow-sm border border-slate-200 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                        
                        {{-- Accent Color Strip --}}
                        <div class="absolute top-0 left-0 bottom-0 w-1.5 bg-gradient-to-b from-[#1b3985] to-blue-500"></div>

                        <div class="p-6 flex flex-col h-full">
                            {{-- Header: Date & Badge --}}
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-2 text-xs font-medium text-slate-500">
                                    <x-heroicon-m-calendar-days class="w-4 h-4 text-slate-400" />
                                    {{ \Carbon\Carbon::parse($announcement->published_at)->isoFormat('dddd, D MMMM YYYY') }}
                                </div>
                                @if($isNew)
                                    <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-bold text-blue-700 ring-1 ring-inset ring-blue-700/10 animate-pulse">
                                        BARU
                                    </span>
                                @endif
                            </div>

                            {{-- Title --}}
                            <h3 class="text-lg font-bold text-slate-900 mb-3 group-hover:text-[#1b3985] transition-colors leading-snug">
                                <a href="#" class="focus:outline-none">
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    {{ $announcement->title }}
                                </a>
                            </h3>

                            {{-- Excerpt --}}
                            <p class="text-sm text-slate-600 leading-relaxed mb-6 line-clamp-3 flex-grow">
                                {{ Str::limit($announcement->message, 180) }}
                            </p>

                            {{-- Footer: Relative Time & CTA --}}
                            <div class="flex items-center justify-between pt-4 border-t border-slate-100 mt-auto">
                                <span class="text-xs text-slate-400">
                                    Diposting {{ \Carbon\Carbon::parse($announcement->published_at)->diffForHumans() }}
                                </span>
                                <span class="flex items-center text-sm font-semibold text-[#1b3985] group-hover:translate-x-1 transition-transform">
                                    Baca Selengkapnya
                                    <x-heroicon-m-arrow-long-right class="ml-2 w-4 h-4" />
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $announcements->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
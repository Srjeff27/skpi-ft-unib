<x-app-layout>
    <div class="space-y-8">
        
        {{-- Header Section --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-slate-900">Papan Pengumuman</h2>
                <p class="mt-1 text-sm text-slate-500">Kelola informasi dan berita untuk mahasiswa.</p>
            </div>
            <div>
                <a href="{{ route('admin.announcements.create') }}" 
                   class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#1b3985] px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-blue-900/20 transition-all hover:bg-[#152c66] hover:shadow-blue-900/30 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <x-heroicon-m-plus class="h-5 w-5" />
                    <span>Buat Pengumuman</span>
                </a>
            </div>
        </div>

        @if (session('status'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
                 class="flex items-center gap-3 rounded-xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-emerald-700 shadow-sm">
                <x-heroicon-s-check-circle class="h-5 w-5" />
                <span class="text-sm font-medium">{{ session('status') }}</span>
            </div>
        @endif

        {{-- Announcements List --}}
        <div class="space-y-4">
            @forelse ($announcements as $announcement)
                <div class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition-all hover:border-blue-300 hover:shadow-md">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                        
                        {{-- Content --}}
                        <div class="flex-1 space-y-2">
                            <div class="flex items-center gap-2 text-xs text-slate-500">
                                <span class="flex items-center gap-1 rounded-full bg-slate-100 px-2.5 py-0.5 font-medium text-slate-600">
                                    <x-heroicon-m-calendar class="h-3.5 w-3.5" />
                                    {{ optional($announcement->published_at)->isoFormat('D MMMM YYYY, HH:mm') }}
                                </span>
                                @if($announcement->created_at->diffInDays(now()) < 3)
                                    <span class="rounded-full bg-blue-100 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide text-blue-700">Baru</span>
                                @endif
                            </div>

                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-[#1b3985] transition-colors">
                                {{ $announcement->title }}
                            </h3>
                            
                            <p class="text-sm leading-relaxed text-slate-600 line-clamp-2">
                                {{ Str::limit($announcement->message, 200) }}
                            </p>
                        </div>

                        {{-- Actions --}}
                        <div class="flex shrink-0 items-center pt-1">
                            <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST" 
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini? Tindakan ini tidak dapat dibatalkan.')">
                                @csrf @method('DELETE')
                                <button type="submit" 
                                        class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-medium text-slate-400 transition-colors hover:bg-rose-50 hover:text-rose-600 focus:outline-none focus:ring-2 focus:ring-rose-500/20">
                                    <x-heroicon-m-trash class="h-5 w-5" />
                                    <span class="hidden sm:inline">Hapus</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                {{-- Empty State --}}
                <div class="flex flex-col items-center justify-center py-16 text-center rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50">
                    <div class="rounded-full bg-white p-4 shadow-sm ring-1 ring-slate-100 mb-4">
                        <x-heroicon-o-megaphone class="h-12 w-12 text-slate-400" />
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900">Belum Ada Pengumuman</h3>
                    <p class="mt-1 text-sm text-slate-500 max-w-sm">
                        Informasi yang Anda buat akan muncul di dashboard mahasiswa. Mulai buat pengumuman pertama Anda.
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('admin.announcements.create') }}" class="text-sm font-medium text-[#1b3985] hover:underline">
                            Buat Pengumuman Sekarang &rarr;
                        </a>
                    </div>
                </div>
            @endforelse

            @if ($announcements->hasPages())
                <div class="pt-4">
                    {{ $announcements->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Manajemen Pengumuman</h2>
                <p class="text-sm text-gray-500">Buat dan kelola pengumuman untuk mahasiswa.</p>
            </div>
            <div>
                <a href="{{ route('admin.announcements.create') }}"
                    class="inline-flex items-center gap-2 justify-center rounded-lg bg-[#1b3985] px-4 py-2 text-sm font-semibold text-white shadow-sm transition-all hover:bg-[#152c66] focus:outline-none focus:ring-2 focus:ring-[#1b3985] focus:ring-offset-2">
                    <x-heroicon-o-plus class="h-4 w-4" />
                    Buat Pengumuman
                </a>
            </div>
        </div>

        @if (session('status'))
            <x-toast type="success" :message="session('status')" />
        @endif

        {{-- Announcements List --}}
        <div class="flow-root">
            @if ($announcements->count() > 0)
                <div class="space-y-4">
                    @foreach ($announcements as $announcement)
                        <div class="rounded-xl border border-gray-100 bg-white p-4 shadow-sm transition-all hover:border-gray-200 hover:shadow-md">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800">{{ $announcement->title }}</p>
                                    <p class="mt-1 text-sm text-gray-600">{{ Str::limit($announcement->message, 150) }}</p>
                                    <p class="mt-2 text-xs text-gray-400">
                                        Diterbitkan: {{ optional($announcement->published_at)->isoFormat('D MMMM YYYY, HH:mm') }}
                                    </p>
                                </div>
                                <div class="flex-shrink-0">
                                    <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus pengumuman ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="rounded-lg bg-red-50 px-3 py-2 text-sm font-semibold text-red-600 hover:bg-red-100">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if ($announcements->hasPages())
                    <div class="mt-6">
                        {{ $announcements->links() }}
                    </div>
                @endif
            @else
                {{-- Empty State --}}
                <div class="text-center rounded-xl border-2 border-dashed border-gray-200 bg-white p-12">
                    <x-heroicon-o-megaphone class="mx-auto h-12 w-12 text-gray-400" />
                    <h3 class="mt-2 text-sm font-semibold text-gray-900">Belum Ada Pengumuman</h3>
                    <p class="mt-1 text-sm text-gray-500">Mulai dengan membuat pengumuman baru.</p>
                    <div class="mt-6">
                        <a href="{{ route('admin.announcements.create') }}"
                            class="inline-flex items-center gap-2 rounded-md bg-[#1b3985] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#152c66]">
                            <x-heroicon-o-plus class="h-4 w-4" />
                            Buat Pengumuman
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

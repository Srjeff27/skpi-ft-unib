<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengumuman') }}
        </h2>
    </x-slot>

    <div class="space-y-6">
        <div class="relative rounded-xl bg-gradient-to-r from-[#1b3985] to-[#2b50a8] p-6 overflow-hidden">
            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="space-y-2">
                    <h1 class="text-2xl font-bold text-white">Pengumuman Terbaru</h1>
                    <p class="text-blue-200 max-w-md">Ikuti terus informasi dan berita terbaru dari kampus Anda.</p>
                </div>
            </div>
            <div class="absolute -bottom-12 -right-12 w-40 h-40 rounded-full bg-blue-800 opacity-50"></div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            @if ($announcements->isEmpty())
                <div class="text-center py-16 px-6">
                    <x-heroicon-o-megaphone class="mx-auto h-12 w-12 text-gray-400" />
                    <h3 class="mt-2 text-lg font-medium text-gray-900">Tidak ada pengumuman saat ini</h3>
                    <p class="mt-1 text-sm text-gray-500">Semua informasi penting akan muncul di sini.</p>
                </div>
            @else
                <ul role="list" class="divide-y divide-gray-100">
                    @foreach ($announcements as $announcement)
                        <li class="relative flex justify-between gap-x-6 px-4 py-5 hover:bg-gray-50 sm:px-6">
                            <div class="flex min-w-0 gap-x-4">
                                <div class="hidden shrink-0 sm:flex items-center">
                                    <x-heroicon-o-megaphone class="h-10 w-10 text-gray-400" />
                                </div>
                                <div class="min-w-0 flex-auto">
                                    <p class="text-sm font-semibold leading-6 text-gray-900">
                                        <a href="#">
                                            <span class="absolute inset-x-0 -top-px bottom-0"></span>
                                            {{ $announcement->title }}
                                        </a>
                                    </p>
                                    <p class="mt-1 flex text-xs leading-5 text-gray-500">
                                        {{ Str::limit($announcement->message, 150) }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex shrink-0 items-center gap-x-4">
                                <div class="hidden sm:flex sm:flex-col sm:items-end">
                                    <p class="text-sm leading-6 text-gray-900">
                                        <time datetime="{{ $announcement->published_at }}">
                                            {{ \Carbon\Carbon::parse($announcement->published_at)->isoFormat('D MMMM YYYY') }}
                                        </time>
                                    </p>
                                    <p class="mt-1 text-xs leading-5 text-gray-500">
                                        {{ \Carbon\Carbon::parse($announcement->published_at)->diffForHumans() }}
                                    </p>
                                </div>
                                <x-heroicon-o-chevron-right class="h-5 w-5 flex-none text-gray-400" />
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="px-4 py-3 border-t border-gray-100 sm:px-6">
                    {{ $announcements->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

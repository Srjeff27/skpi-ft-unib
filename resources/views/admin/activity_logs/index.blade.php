<x-app-layout>
    <div class="space-y-6" x-data="{ showProperties: null }">
        {{-- Header --}}
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Log Aktivitas</h2>
                <p class="text-sm text-gray-500">Rekam jejak semua aktivitas penting dalam sistem.</p>
            </div>
        </div>

        {{-- Filters and Search --}}
        <div class="rounded-xl border border-gray-100 bg-white p-4 shadow-sm">
            <form method="GET">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <input type="search" name="search" placeholder="Cari nama user..." value="{{ request('search') }}"
                        class="w-full rounded-lg border-gray-200 focus:border-[#1b3985] focus:ring-[#1b3985] lg:col-span-1">
                    <select name="role" class="w-full rounded-lg border-gray-200 focus:border-[#1b3985] focus:ring-[#1b3985]">
                        <option value="">Semua Role</option>
                        <option value="admin" @selected(request('role') == 'admin')>Admin</option>
                        <option value="verifikator" @selected(request('role') == 'verifikator')>Verifikator</option>
                        <option value="mahasiswa" @selected(request('role') == 'mahasiswa')>Mahasiswa</option>
                    </select>
                    <select name="action" class="w-full rounded-lg border-gray-200 focus:border-[#1b3985] focus:ring-[#1b3985]">
                        <option value="">Semua Aksi</option>
                        @foreach($actions as $action)
                            <option value="{{ $action }}" @selected(request('action') == $action)>{{ ucfirst($action) }}</option>
                        @endforeach
                    </select>
                    <button type="submit"
                        class="inline-flex items-center gap-2 justify-center rounded-lg bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-700 transition-all hover:bg-gray-200">
                        <x-heroicon-o-magnifying-glass class="h-4 w-4" />
                        Filter
                    </button>
                </div>
            </form>
        </div>

        {{-- Activity Timeline --}}
        <div class="flow-root">
            @if ($logs->count() > 0)
                <ul role="list" class="-mb-8">
                    @foreach ($logs as $log)
                        <li>
                            <div class="relative pb-8">
                                @if (!$loop->last)
                                    <span class="absolute left-5 top-5 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                @endif
                                <div class="relative flex items-start space-x-4">
                                    {{-- Icon --}}
                                    <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-white ring-8 ring-white">
                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ optional($log->user)->avatar_url }}" alt="">
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm text-gray-600">
                                            <span class="font-semibold text-gray-800">{{ optional($log->user)->name ?? 'User Sistem' }}</span>
                                            {{ $log->description }}
                                        </p>
                                        <p class="mt-0.5 text-xs text-gray-400">
                                            {{ $log->created_at->diffForHumans() }}
                                            <button @click="showProperties = {{ json_encode($log->properties) }}" class="ml-2 text-blue-600 hover:underline">
                                                (Lihat data)
                                            </button>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
                 @if ($logs->hasPages())
                    <div class="mt-8">
                        {{ $logs->links() }}
                    </div>
                @endif
            @else
                <div class="text-center rounded-xl border-2 border-dashed border-gray-200 bg-white p-12">
                    <x-heroicon-o-clipboard-document-list class="mx-auto h-12 w-12 text-gray-400" />
                    <h3 class="mt-2 text-sm font-semibold text-gray-900">Belum Ada Aktivitas</h3>
                    <p class="mt-1 text-sm text-gray-500">Tidak ada log aktivitas yang cocok dengan filter Anda.</p>
                </div>
            @endif
        </div>

        <!-- Properties Modal -->
        <div x-show="showProperties" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
            <div @click.away="showProperties = null" class="w-full max-w-lg rounded-xl bg-white p-6 shadow-xl">
                <h3 class="text-lg font-semibold text-gray-800">Detail Data Log</h3>
                <pre class="mt-4 w-full overflow-auto rounded-lg bg-gray-800 p-4 text-xs text-white"><code x-text="JSON.stringify(showProperties, null, 2)"></code></pre>
                <div class="mt-4 flex justify-end">
                    <button @click="showProperties = null" class="rounded-lg border border-gray-200 bg-white px-4 py-2 text-center text-sm font-medium text-gray-700">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

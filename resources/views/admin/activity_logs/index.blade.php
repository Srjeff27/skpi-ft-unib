<x-app-layout>
    <div x-data="{ 
            showProperties: null,
            openModal(data) { this.showProperties = data; },
            closeModal() { this.showProperties = null; }
        }" 
        class="space-y-8 pb-20">
        
        {{-- Header Section --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-slate-900">Log Aktivitas Sistem</h2>
                <p class="mt-1 text-sm text-slate-500">Rekam jejak digital seluruh interaksi pengguna dalam sistem.</p>
            </div>
        </div>

        {{-- Filter Toolbar --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-1.5 shadow-sm">
            <form method="GET" class="flex flex-col gap-2 lg:flex-row">
                <div class="relative flex-grow">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <x-heroicon-o-magnifying-glass class="h-5 w-5 text-slate-400" />
                    </div>
                    <input type="search" name="search" value="{{ request('search') }}" 
                           placeholder="Cari nama pengguna atau deskripsi..." 
                           class="block w-full rounded-xl border-0 py-2.5 pl-10 text-sm text-slate-900 ring-1 ring-inset ring-slate-200 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-[#1b3985]">
                </div>

                <div class="flex flex-col sm:flex-row gap-2">
                    <select name="role" class="block w-full rounded-xl border-0 py-2.5 pl-3 pr-10 text-sm text-slate-900 ring-1 ring-inset ring-slate-200 focus:ring-2 focus:ring-inset focus:ring-[#1b3985] sm:w-40">
                        <option value="">Semua Role</option>
                        <option value="admin" @selected(request('role') == 'admin')>Admin</option>
                        <option value="verifikator" @selected(request('role') == 'verifikator')>Verifikator</option>
                        <option value="mahasiswa" @selected(request('role') == 'mahasiswa')>Mahasiswa</option>
                    </select>

                    <select name="action" class="block w-full rounded-xl border-0 py-2.5 pl-3 pr-10 text-sm text-slate-900 ring-1 ring-inset ring-slate-200 focus:ring-2 focus:ring-inset focus:ring-[#1b3985] sm:w-40">
                        <option value="">Semua Aksi</option>
                        @foreach($actions as $action)
                            <option value="{{ $action }}" @selected(request('action') == $action)>{{ ucfirst($action) }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-slate-100 px-4 py-2.5 text-slate-700 transition-colors hover:bg-slate-200 hover:text-slate-900">
                        <x-heroicon-m-funnel class="h-5 w-5" />
                    </button>
                </div>
            </form>
        </div>

        {{-- Activity Timeline --}}
        <div class="relative">
            @if ($logs->count() > 0)
                <div class="absolute left-8 top-0 bottom-0 w-px bg-slate-200 hidden sm:block"></div>
                
                <div class="space-y-8">
                    @foreach ($logs as $log)
                        @php
                            // Logic warna berdasarkan jenis aksi
                            $descLower = strtolower($log->description);
                            $theme = match(true) {
                                Str::contains($descLower, ['create', 'tambah', 'upload', 'simpan']) => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-700', 'icon' => 'heroicon-s-plus'],
                                Str::contains($descLower, ['update', 'edit', 'ubah', 'verifikasi']) => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'icon' => 'heroicon-s-pencil'],
                                Str::contains($descLower, ['delete', 'hapus', 'destroy']) => ['bg' => 'bg-rose-100', 'text' => 'text-rose-700', 'icon' => 'heroicon-s-trash'],
                                Str::contains($descLower, ['login', 'logout']) => ['bg' => 'bg-slate-100', 'text' => 'text-slate-700', 'icon' => 'heroicon-s-arrow-right-end-on-rectangle'],
                                default => ['bg' => 'bg-slate-100', 'text' => 'text-slate-600', 'icon' => 'heroicon-s-information-circle'],
                            };
                        @endphp

                        <div class="relative flex flex-col sm:flex-row gap-4 sm:gap-8 group">
                            {{-- Timeline Dot & Avatar --}}
                            <div class="flex items-center gap-4 sm:w-16 sm:flex-col sm:items-center shrink-0 z-10">
                                <div class="relative">
                                    <img class="h-12 w-12 rounded-full object-cover ring-4 ring-white shadow-sm" 
                                         src="{{ optional($log->user)->avatar_url }}" 
                                         alt="{{ optional($log->user)->name }}">
                                    <div class="absolute -bottom-1 -right-1 rounded-full p-1 ring-2 ring-white {{ $theme['bg'] }} {{ $theme['text'] }}">
                                        <x-dynamic-component :component="$theme['icon']" class="h-3 w-3" />
                                    </div>
                                </div>
                            </div>

                            {{-- Content Card --}}
                            <div class="flex-1 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all hover:border-blue-300 hover:shadow-md">
                                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2">
                                    <div>
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="font-bold text-slate-900">{{ optional($log->user)->name ?? 'Sistem' }}</span>
                                            <span class="text-xs px-2 py-0.5 rounded-full bg-slate-100 text-slate-500 font-medium border border-slate-200">
                                                {{ optional($log->user)->role ?? 'System' }}
                                            </span>
                                        </div>
                                        <p class="text-sm text-slate-600 font-medium">{{ $log->description }}</p>
                                    </div>
                                    <span class="text-xs text-slate-400 font-mono flex items-center gap-1 bg-slate-50 px-2 py-1 rounded-md self-start">
                                        <x-heroicon-o-clock class="h-3 w-3" />
                                        {{ $log->created_at->format('d M Y, H:i:s') }}
                                    </span>
                                </div>

                                @if(!empty($log->properties))
                                    <div class="mt-4 pt-4 border-t border-slate-100 flex justify-end">
                                        <button @click="openModal({{ json_encode($log->properties) }})" 
                                                class="text-xs font-semibold text-[#1b3985] hover:text-blue-700 hover:underline flex items-center gap-1">
                                            <x-heroicon-m-code-bracket class="h-4 w-4" />
                                            Lihat Data Teknis
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($logs->hasPages())
                    <div class="mt-10 pl-0 sm:pl-24">
                        {{ $logs->links() }}
                    </div>
                @endif
            @else
                {{-- Empty State --}}
                <div class="flex flex-col items-center justify-center py-20 text-center rounded-3xl border-2 border-dashed border-slate-200 bg-slate-50">
                    <div class="rounded-full bg-white p-4 shadow-sm ring-1 ring-slate-100 mb-4">
                        <x-heroicon-o-clipboard-document-list class="h-12 w-12 text-slate-400" />
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900">Belum Ada Aktivitas</h3>
                    <p class="text-sm text-slate-500 mt-1">Sistem belum mencatat aktivitas apapun sesuai filter yang dipilih.</p>
                </div>
            @endif
        </div>

        {{-- Properties Inspector Modal --}}
        <div x-show="showProperties" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center px-4 sm:px-6" style="display: none;" x-cloak>
            
            <div class="absolute inset-0 bg-slate-900/70 backdrop-blur-sm" @click="closeModal()"></div>

            <div x-show="showProperties"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:scale-95"
                 class="relative w-full max-w-2xl overflow-hidden rounded-2xl bg-white shadow-2xl ring-1 ring-black/5">
                
                <div class="bg-[#1b3985] px-6 py-4 text-white flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <x-heroicon-o-command-line class="h-5 w-5 text-blue-300" />
                        <h3 class="text-lg font-bold font-mono">Payload Inspector</h3>
                    </div>
                    <button @click="closeModal()" class="text-white/70 hover:text-white transition-colors">
                        <x-heroicon-m-x-mark class="h-6 w-6" />
                    </button>
                </div>

                <div class="p-0 bg-[#1e1e1e] overflow-auto max-h-[60vh] custom-scrollbar">
                    {{-- Stylized Code Block --}}
                    <pre class="text-xs sm:text-sm font-mono leading-relaxed p-6 text-blue-100"><code x-text="JSON.stringify(showProperties, null, 4)"></code></pre>
                </div>

                <div class="bg-slate-50 px-6 py-3 border-t border-slate-200 flex justify-end">
                    <button @click="closeModal()" class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition shadow-sm">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    {{-- Header Navigation --}}
    <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Buat Pengumuman Baru</h2>
            <p class="text-sm text-slate-500">Informasi akan disiarkan ke dashboard mahasiswa.</p>
        </div>
        <a href="{{ route('admin.announcements.index') }}" 
           class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition-all hover:bg-slate-50 hover:text-slate-900">
            <x-heroicon-m-arrow-left class="h-4 w-4" />
            Kembali
        </a>
    </div>

    <div class="max-w-3xl mx-auto">
        <form method="POST" action="{{ route('admin.announcements.store') }}">
            @csrf

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                
                {{-- Card Header --}}
                <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <x-heroicon-o-megaphone class="h-5 w-5 text-[#1b3985]" />
                        Detail Pengumuman
                    </h3>
                </div>

                {{-- Form Inputs --}}
                <div class="p-6 sm:p-8 space-y-6">
                    
                    {{-- Judul --}}
                    <div>
                        <x-input-label for="title" value="Judul Pengumuman" />
                        <div class="relative mt-1">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <x-heroicon-o-pencil-square class="h-5 w-5 text-slate-400" />
                            </div>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" required autofocus
                                   class="block w-full rounded-xl border-slate-300 pl-10 focus:border-[#1b3985] focus:ring-[#1b3985] sm:text-sm" 
                                   placeholder="Contoh: Jadwal Verifikasi SKPI Periode Mei">
                        </div>
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    {{-- Isi Pesan --}}
                    <div>
                        <x-input-label for="message" value="Isi Pesan" />
                        <div class="relative mt-1">
                            <textarea name="message" id="message" rows="6" required
                                      class="block w-full rounded-xl border-slate-300 p-4 focus:border-[#1b3985] focus:ring-[#1b3985] sm:text-sm leading-relaxed"
                                      placeholder="Tuliskan detail informasi lengkap di sini...">{{ old('message') }}</textarea>
                        </div>
                        <x-input-error :messages="$errors->get('message')" class="mt-2" />
                    </div>

                    {{-- Waktu Terbit --}}
                    <div>
                        <x-input-label for="published_at" value="Jadwal Terbit (Opsional)" />
                        <div class="relative mt-1">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <x-heroicon-o-calendar class="h-5 w-5 text-slate-400" />
                            </div>
                            <input type="datetime-local" name="published_at" id="published_at" value="{{ old('published_at') }}"
                                   class="block w-full rounded-xl border-slate-300 pl-10 focus:border-[#1b3985] focus:ring-[#1b3985] sm:text-sm text-slate-600 placeholder-slate-400">
                        </div>
                        <p class="mt-2 text-xs text-slate-500 flex items-center gap-1">
                            <x-heroicon-o-information-circle class="w-4 h-4" />
                            Biarkan kosong jika ingin diterbitkan sekarang juga.
                        </p>
                        <x-input-error :messages="$errors->get('published_at')" class="mt-2" />
                    </div>

                </div>

                {{-- Card Footer / Actions --}}
                <div class="flex items-center justify-end gap-3 border-t border-slate-100 bg-slate-50 px-6 py-4">
                    <a href="{{ route('admin.announcements.index') }}" 
                       class="rounded-xl px-5 py-2.5 text-sm font-semibold text-slate-600 transition-colors hover:bg-white hover:text-slate-900 hover:shadow-sm ring-1 ring-transparent hover:ring-slate-200">
                        Batal
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center gap-2 rounded-xl bg-[#1b3985] px-6 py-2.5 text-sm font-bold text-white shadow-lg shadow-blue-900/20 transition-all hover:bg-[#152c66] hover:shadow-blue-900/40 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <x-heroicon-m-paper-airplane class="h-5 w-5" />
                        Simpan & Terbitkan
                    </button>
                </div>

            </div>
        </form>
    </div>
</x-app-layout>
<x-app-layout>
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Buat Pengumuman Baru</h2>
                <p class="text-sm text-gray-500">
                    Pengumuman akan dikirimkan sebagai notifikasi ke semua mahasiswa.
                </p>
            </div>
        </div>

        <div class="max-w-2xl mx-auto">
            <form method="POST" action="{{ route('admin.announcements.store') }}"
                class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm space-y-6">
                @csrf

                {{-- Form Fields --}}
                <div>
                    <x-input-label for="title" value="Judul Pengumuman" />
                    <x-text-input id="title" name="title" class="mt-1 block w-full"
                        :value="old('title')" required autofocus
                        placeholder="Contoh: Jadwal Verifikasi SKPI" />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="message" value="Isi Pengumuman" />
                    <textarea id="message" name="message" rows="6" required
                        class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm focus:border-[#1b3985] focus:ring-[#1b3985]"
                        placeholder="Tuliskan isi pengumuman di sini...">{{ old('message') }}</textarea>
                    <x-input-error :messages="$errors->get('message')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="published_at" value="Waktu Terbit (Opsional)" />
                    <x-text-input id="published_at" name="published_at" type="datetime-local" class="mt-1 block w-full" 
                        :value="old('published_at')" />
                    <p class="mt-1 text-xs text-gray-500">Kosongkan untuk menerbitkan sekarang.</p>
                    <x-input-error :messages="$errors->get('published_at')" class="mt-2" />
                </div>

                {{-- Form Actions --}}
                <div class="flex items-center justify-end gap-4 pt-4">
                    <a href="{{ route('admin.announcements.index') }}"
                        class="rounded-lg border border-gray-200 bg-white px-4 py-2 text-center text-sm font-medium text-gray-700 shadow-sm transition-all hover:bg-gray-50">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center gap-2 justify-center rounded-lg bg-[#1b3985] px-4 py-2 text-sm font-semibold text-white shadow-sm transition-all hover:bg-[#152c66] focus:outline-none focus:ring-2 focus:ring-[#1b3985] focus:ring-offset-2">
                        <x-heroicon-o-paper-airplane class="h-4 w-4" />
                        Simpan & Kirim
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

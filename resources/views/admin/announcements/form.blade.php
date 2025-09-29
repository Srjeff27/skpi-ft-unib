<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">Buat Pengumuman</h2>
    </x-slot>

    <div class="pt-8 pb-16">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <form method="POST" action="{{ route('admin.announcements.store') }}">
                    @csrf

                    <div class="space-y-4">
                        <div>
                            <x-input-label value="Judul" />
                            <x-text-input name="title" class="w-full" value="{{ old('title') }}" required />
                            <x-input-error :messages="$errors->get('title')" />
                        </div>
                        <div>
                            <x-input-label value="Isi Pengumuman" />
                            <textarea name="message" rows="6" class="w-full border-gray-300 rounded-md" required>{{ old('message') }}</textarea>
                            <x-input-error :messages="$errors->get('message')" />
                        </div>
                        <div>
                            <x-input-label value="Waktu Terbit (opsional)" />
                            <x-text-input name="published_at" class="w-full" placeholder="YYYY-MM-DD HH:MM" value="{{ old('published_at') }}" />
                            <x-input-error :messages="$errors->get('published_at')" />
                        </div>
                    </div>

                    <div class="mt-6 flex gap-3">
                        <a href="{{ route('admin.announcements.index') }}" class="px-4 py-2 border rounded-md">Batal</a>
                        <button class="px-4 py-2 rounded-md bg-[#1b3985] text-white">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>


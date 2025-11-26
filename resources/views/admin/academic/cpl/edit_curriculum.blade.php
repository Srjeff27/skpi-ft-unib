<x-app-layout>
    {{-- Header Navigation --}}
    <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">
                Edit Kurikulum
            </h2>
            <p class="text-sm text-slate-500">Perbarui informasi kurikulum untuk Program Studi terkait.</p>
        </div>
        <a href="{{ route('admin.cpl.index', ['prodi_id' => $curriculum->prodi_id]) }}" 
           class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition-all hover:bg-slate-50 hover:text-slate-900">
            <x-heroicon-m-arrow-left class="h-4 w-4" />
            Kembali
        </a>
    </div>

    <div class="max-w-2xl mx-auto">
        <form method="POST" action="{{ route('admin.cpl.curricula.update', $curriculum) }}">
            @csrf
            @method('PUT')

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                
                {{-- Card Header --}}
                <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <x-heroicon-o-pencil-square class="h-5 w-5 text-[#1b3985]" />
                        Detail Kurikulum
                    </h3>
                </div>

                {{-- Form Inputs --}}
                <div class="p-6 sm:p-8 space-y-6">
                    
                    {{-- Nama Kurikulum --}}
                    <div>
                        <x-input-label for="name" value="Nama Kurikulum" />
                        <div class="relative mt-1">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <x-heroicon-o-book-open class="h-5 w-5 text-slate-400" />
                            </div>
                            <input type="text" name="name" id="name" value="{{ old('name', $curriculum->name) }}" required autofocus
                                   class="block w-full rounded-xl border-slate-300 pl-10 focus:border-[#1b3985] focus:ring-[#1b3985] sm:text-sm" 
                                   placeholder="Contoh: Kurikulum 2024 - MBKM">
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        {{-- Tahun Berlaku --}}
                        <div>
                            <x-input-label for="year" value="Tahun Berlaku" />
                            <div class="relative mt-1">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <x-heroicon-o-calendar class="h-5 w-5 text-slate-400" />
                                </div>
                                <input type="number" name="year" id="year" value="{{ old('year', $curriculum->year) }}" min="2000" max="2100"
                                       class="block w-full rounded-xl border-slate-300 pl-10 focus:border-[#1b3985] focus:ring-[#1b3985] sm:text-sm" 
                                       placeholder="2024">
                            </div>
                            <x-input-error :messages="$errors->get('year')" class="mt-2" />
                        </div>

                        {{-- Status Toggle --}}
                        <div>
                            <x-input-label for="is_active" value="Status" class="mb-1" />
                            <label class="flex cursor-pointer items-center gap-3 rounded-xl border border-slate-200 p-2.5 w-full hover:bg-slate-50 transition-colors has-[:checked]:border-[#1b3985] has-[:checked]:bg-blue-50/30">
                                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $curriculum->is_active))
                                       class="h-5 w-5 rounded border-slate-300 text-[#1b3985] focus:ring-[#1b3985]">
                                <span class="text-sm font-medium text-slate-700">Aktifkan Kurikulum</span>
                            </label>
                        </div>
                    </div>

                </div>

                {{-- Card Footer / Actions --}}
                <div class="flex items-center justify-end gap-3 border-t border-slate-100 bg-slate-50 px-6 py-4">
                    <a href="{{ route('admin.cpl.index', ['prodi_id' => $curriculum->prodi_id]) }}" 
                       class="rounded-xl px-5 py-2.5 text-sm font-semibold text-slate-600 transition-colors hover:bg-white hover:text-slate-900 hover:shadow-sm ring-1 ring-transparent hover:ring-slate-200">
                        Batal
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center gap-2 rounded-xl bg-[#1b3985] px-6 py-2.5 text-sm font-bold text-white shadow-lg shadow-blue-900/20 transition-all hover:bg-[#152c66] hover:shadow-blue-900/40 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <x-heroicon-m-check class="h-5 w-5" />
                        Simpan Perubahan
                    </button>
                </div>

            </div>
        </form>
    </div>
</x-app-layout>
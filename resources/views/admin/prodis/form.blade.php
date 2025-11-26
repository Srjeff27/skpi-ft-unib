<x-app-layout>
    {{-- Header Navigation --}}
    <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">
                {{ $prodi->exists ? 'Edit Program Studi' : 'Tambah Program Studi Baru' }}
            </h2>
            <p class="text-sm text-slate-500">Kelola data departemen dan jenjang pendidikan.</p>
        </div>
        <a href="{{ route('admin.prodis.index') }}" 
           class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition-all hover:bg-slate-50 hover:text-slate-900">
            <x-heroicon-m-arrow-left class="h-4 w-4" />
            Kembali
        </a>
    </div>

    <div class="max-w-3xl mx-auto">
        <form method="POST" action="{{ $prodi->exists ? route('admin.prodis.update', $prodi) : route('admin.prodis.store') }}">
            @csrf
            @if ($prodi->exists) @method('PUT') @endif

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                
                {{-- Card Header --}}
                <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <x-heroicon-o-building-library class="h-5 w-5 text-[#1b3985]" />
                        Informasi Program Studi
                    </h3>
                </div>

                {{-- Form Inputs --}}
                <div class="p-6 sm:p-8 space-y-6">
                    
                    {{-- Nama Prodi --}}
                    <div>
                        <x-input-label for="nama_prodi" value="Nama Program Studi" />
                        <div class="relative mt-1">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <x-heroicon-o-book-open class="h-5 w-5 text-slate-400" />
                            </div>
                            <input type="text" name="nama_prodi" id="nama_prodi" value="{{ old('nama_prodi', $prodi->nama_prodi) }}" required autofocus
                                   class="block w-full rounded-xl border-slate-300 pl-10 focus:border-[#1b3985] focus:ring-[#1b3985] sm:text-sm" 
                                   placeholder="Contoh: Teknik Informatika">
                        </div>
                        <x-input-error :messages="$errors->get('nama_prodi')" class="mt-2" />
                    </div>

                    {{-- Jenjang --}}
                    <div>
                        <x-input-label for="jenjang" value="Jenjang Pendidikan" />
                        <div class="relative mt-1">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <x-heroicon-o-academic-cap class="h-5 w-5 text-slate-400" />
                            </div>
                            <select name="jenjang" id="jenjang" required
                                    class="block w-full rounded-xl border-slate-300 pl-10 focus:border-[#1b3985] focus:ring-[#1b3985] sm:text-sm bg-white">
                                <option value="" disabled @selected(old('jenjang', $prodi->jenjang) == '')>- Pilih Jenjang -</option>
                                <option value="D3" @selected(old('jenjang', $prodi->jenjang) == 'D3')>D3 (Diploma Tiga)</option>
                                <option value="S1" @selected(old('jenjang', $prodi->jenjang) == 'S1')>S1 (Sarjana)</option>
                                <option value="S2" @selected(old('jenjang', $prodi->jenjang) == 'S2')>S2 (Magister)</option>
                                <option value="S3" @selected(old('jenjang', $prodi->jenjang) == 'S3')>S3 (Doktor)</option>
                            </select>
                        </div>
                        <x-input-error :messages="$errors->get('jenjang')" class="mt-2" />
                    </div>

                </div>

                {{-- Card Footer / Actions --}}
                <div class="flex items-center justify-end gap-4 border-t border-slate-100 bg-slate-50 px-6 py-4">
                    <a href="{{ route('admin.prodis.index') }}" 
                       class="rounded-xl px-5 py-2.5 text-sm font-semibold text-slate-600 transition-colors hover:bg-white hover:text-slate-900 hover:shadow-sm ring-1 ring-transparent hover:ring-slate-200">
                        Batal
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center gap-2 rounded-xl bg-[#1b3985] px-6 py-2.5 text-sm font-bold text-white shadow-lg shadow-blue-900/20 transition-all hover:bg-[#152c66] hover:shadow-blue-900/40 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <x-heroicon-m-check class="h-5 w-5" />
                        Simpan Data
                    </button>
                </div>

            </div>
        </form>
    </div>
</x-app-layout>
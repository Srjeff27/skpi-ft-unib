<x-app-layout>
    {{-- Header Navigation --}}
    <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">
                {{ $official->exists ? 'Edit Data Pejabat' : 'Tambah Pejabat Baru' }}
            </h2>
            <p class="text-sm text-slate-500">Kelola data penandatangan dokumen (Dekan/Wakil Dekan).</p>
        </div>
        <a href="{{ route('admin.pejabat.index') }}" 
           class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition-all hover:bg-slate-50 hover:text-slate-900">
            <x-heroicon-m-arrow-left class="h-4 w-4" />
            Kembali
        </a>
    </div>

    <form method="POST" action="{{ $official->exists ? route('admin.pejabat.update', $official) : route('admin.pejabat.store') }}" 
          enctype="multipart/form-data" class="space-y-8 pb-20">
        @csrf
        @if($official->exists) @method('PUT') @endif

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
            
            {{-- Kolom Kiri: Informasi Identitas --}}
            <div class="lg:col-span-2 space-y-8">
                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4">
                        <h3 class="font-bold text-slate-800 flex items-center gap-2">
                            <x-heroicon-o-user-circle class="h-5 w-5 text-[#1b3985]" />
                            Identitas Pejabat
                        </h3>
                    </div>
                    <div class="p-6 sm:p-8">
                        <div class="grid grid-cols-1 gap-6">
                            
                            {{-- Nama Lengkap --}}
                            <div>
                                <x-input-label for="name" value="Nama Lengkap (Tanpa Gelar)" />
                                <div class="relative mt-1">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <x-heroicon-o-user class="h-5 w-5 text-slate-400" />
                                    </div>
                                    <input type="text" name="name" id="name" value="{{ old('name', $official->name) }}" required
                                           class="block w-full rounded-xl border-slate-300 pl-10 focus:border-[#1b3985] focus:ring-[#1b3985] sm:text-sm" 
                                           placeholder="Contoh: Budi Santoso">
                                </div>
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            {{-- Gelar --}}
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <div>
                                    <x-input-label for="gelar_depan" value="Gelar Depan" />
                                    <div class="relative mt-1">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <x-heroicon-o-academic-cap class="h-5 w-5 text-slate-400" />
                                        </div>
                                        <input type="text" name="gelar_depan" id="gelar_depan" value="{{ old('gelar_depan', $official->gelar_depan) }}"
                                               class="block w-full rounded-xl border-slate-300 pl-10 focus:border-[#1b3985] focus:ring-[#1b3985] sm:text-sm" 
                                               placeholder="Dr. Ir.">
                                    </div>
                                    <x-input-error :messages="$errors->get('gelar_depan')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="gelar_belakang" value="Gelar Belakang" />
                                    <div class="relative mt-1">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <x-heroicon-o-academic-cap class="h-5 w-5 text-slate-400" />
                                        </div>
                                        <input type="text" name="gelar_belakang" id="gelar_belakang" value="{{ old('gelar_belakang', $official->gelar_belakang) }}"
                                               class="block w-full rounded-xl border-slate-300 pl-10 focus:border-[#1b3985] focus:ring-[#1b3985] sm:text-sm" 
                                               placeholder="M.T., IPM.">
                                    </div>
                                    <x-input-error :messages="$errors->get('gelar_belakang')" class="mt-2" />
                                </div>
                            </div>

                            {{-- Jabatan & NIP --}}
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <div>
                                    <x-input-label for="jabatan" value="Jabatan Struktural" />
                                    <div class="relative mt-1">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <x-heroicon-o-briefcase class="h-5 w-5 text-slate-400" />
                                        </div>
                                        <input type="text" name="jabatan" id="jabatan" value="{{ old('jabatan', $official->jabatan) }}" required
                                               class="block w-full rounded-xl border-slate-300 pl-10 focus:border-[#1b3985] focus:ring-[#1b3985] sm:text-sm" 
                                               placeholder="Contoh: Dekan Fakultas Teknik">
                                    </div>
                                    <x-input-error :messages="$errors->get('jabatan')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="nip" value="NIP / NIDN" />
                                    <div class="relative mt-1">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <x-heroicon-o-identification class="h-5 w-5 text-slate-400" />
                                        </div>
                                        <input type="text" name="nip" id="nip" value="{{ old('nip', $official->nip) }}"
                                               class="block w-full rounded-xl border-slate-300 pl-10 focus:border-[#1b3985] focus:ring-[#1b3985] sm:text-sm" 
                                               placeholder="198xxxxxxxxx">
                                    </div>
                                    <x-input-error :messages="$errors->get('nip')" class="mt-2" />
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Tanda Tangan & Status --}}
            <div class="space-y-8">
                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm h-full">
                    <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4">
                        <h3 class="font-bold text-slate-800 flex items-center gap-2">
                            <x-heroicon-o-pencil-square class="h-5 w-5 text-[#1b3985]" />
                            Atribut Validasi
                        </h3>
                    </div>
                    <div class="p-6 sm:p-8 space-y-6">
                        
                        {{-- Status Toggle --}}
                        <div>
                            <x-input-label for="is_active" value="Status Pejabat" class="mb-2" />
                            <select name="is_active" id="is_active" class="block w-full rounded-xl border-slate-300 focus:border-[#1b3985] focus:ring-[#1b3985] sm:text-sm">
                                <option value="1" {{ old('is_active', $official->is_active ? 1 : 0) == 1 ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('is_active', $official->is_active ? 1 : 0) == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                            <p class="mt-2 text-xs text-slate-500">Hanya pejabat aktif yang akan muncul di pilihan cetak SKPI.</p>
                        </div>

                        <hr class="border-slate-100">

                        {{-- Upload Tanda Tangan --}}
                        <div>
                            <x-input-label for="signature" value="Scan Tanda Tangan (PNG)" class="mb-2" />
                            
                            {{-- Preview Area --}}
                            <div class="relative mb-4 flex justify-center rounded-xl border-2 border-dashed border-slate-200 bg-slate-50 p-4">
                                @if($official->signature_path)
                                    <div class="text-center">
                                        <div class="mb-2 inline-block bg-[url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAMUlEQVQ4T2NkYGAQYcAP3uCTZhw1gGGYhAGBZIA/nYDCgBDAm9BGDWAAJyRCgLaBCAAgXwixzAS0pgAAAABJRU5ErkJggg==')] p-4 rounded-lg">
                                            <img src="{{ asset('storage/'.$official->signature_path) }}" alt="Signature" class="h-20 object-contain">
                                        </div>
                                        <p class="text-xs text-slate-500">Tanda tangan saat ini</p>
                                    </div>
                                @else
                                    <div class="flex flex-col items-center text-slate-400">
                                        <x-heroicon-o-photo class="h-10 w-10 mb-2" />
                                        <span class="text-xs">Belum ada tanda tangan</span>
                                    </div>
                                @endif
                            </div>

                            {{-- File Input --}}
                            <input type="file" name="signature" id="signature" accept="image/png"
                                   class="block w-full text-sm text-slate-500
                                          file:mr-4 file:py-2 file:px-4
                                          file:rounded-full file:border-0
                                          file:text-xs file:font-semibold
                                          file:bg-blue-50 file:text-blue-700
                                          hover:file:bg-blue-100
                                          cursor-pointer border rounded-lg">
                            <p class="mt-2 text-xs text-slate-500">Format wajib: <strong>PNG Transparan</strong>.</p>
                            <x-input-error :messages="$errors->get('signature')" class="mt-2" />
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- Sticky Action Footer --}}
        <div class="fixed bottom-0 left-0 right-0 border-t border-slate-200 bg-white/80 p-4 backdrop-blur-md md:pl-64 z-40">
            <div class="mx-auto flex max-w-7xl items-center justify-end gap-4 px-4">
                <a href="{{ route('admin.pejabat.index') }}" class="rounded-xl px-6 py-2.5 text-sm font-semibold text-slate-600 transition-colors hover:bg-slate-100 hover:text-slate-900">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-[#1b3985] px-8 py-2.5 text-sm font-bold text-white shadow-lg shadow-blue-900/20 transition-all hover:bg-[#152c66] hover:shadow-blue-900/40 hover:-translate-y-0.5">
                    <x-heroicon-m-check class="h-5 w-5" />
                    Simpan Data
                </button>
            </div>
        </div>
    </form>
</x-app-layout>
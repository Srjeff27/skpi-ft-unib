<x-app-layout>
    @php
        $isLocked = !in_array($portfolio->status, ['pending', 'requires_revision']);
        $isRevision = $portfolio->status === 'requires_revision' && $portfolio->rejection_reason;
    @endphp

    <div class="max-w-5xl mx-auto space-y-6 pb-12">
        
        {{-- HEADER SECTION --}}
        <div class="relative rounded-2xl bg-[#1b3985] p-6 sm:p-10 shadow-lg overflow-hidden">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white opacity-5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-blue-400 opacity-10 rounded-full blur-2xl"></div>
            
            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-white tracking-tight flex items-center gap-3">
                        <x-heroicon-o-pencil-square class="w-8 h-8 text-blue-200" />
                        Edit Portofolio
                    </h1>
                    <p class="text-blue-100 mt-2 text-sm sm:text-base max-w-xl">
                        Perbarui informasi kegiatan atau prestasi Anda. Pastikan data yang diunggah valid dan dapat dipertanggungjawabkan.
                    </p>
                </div>
                <div class="hidden sm:block">
                    <span class="inline-flex items-center rounded-full bg-blue-900/50 px-3 py-1 text-xs font-medium text-blue-200 ring-1 ring-inset ring-blue-400/20">
                        ID: {{ $portfolio->id }}
                    </span>
                </div>
            </div>
        </div>

        {{-- ALERT SECTION --}}
        @if ($errors->any())
            <div class="rounded-xl border-l-4 border-red-500 bg-white p-4 shadow-sm">
                <div class="flex items-start gap-3">
                    <x-heroicon-s-x-circle class="h-6 w-6 text-red-500 flex-shrink-0" />
                    <div>
                        <h3 class="text-sm font-bold text-red-800">Gagal Menyimpan</h3>
                        <p class="text-sm text-red-600 mt-1">{{ $errors->first() ?? 'Silakan periksa kembali inputan Anda.' }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if ($isLocked)
            <div class="rounded-xl border border-blue-100 bg-blue-50 p-4 shadow-sm">
                <div class="flex items-start gap-3">
                    <x-heroicon-s-lock-closed class="h-6 w-6 text-blue-600 flex-shrink-0" />
                    <div>
                        <h3 class="text-sm font-bold text-blue-900">Mode Baca Saja</h3>
                        <p class="text-sm text-blue-700 mt-1">
                            Portofolio ini sedang dalam status <span class="font-semibold uppercase">{{ $portfolio->status }}</span>. Anda tidak dapat melakukan perubahan data saat ini.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @if ($isRevision)
            <div class="rounded-xl border-l-4 border-amber-500 bg-white p-5 shadow-sm ring-1 ring-gray-900/5">
                <div class="flex flex-col sm:flex-row sm:items-start gap-4">
                    <div class="flex-shrink-0">
                        <span class="flex h-10 w-10 items-center justify-center rounded-full bg-amber-100 text-amber-600">
                            <x-heroicon-o-exclamation-triangle class="h-6 w-6" />
                        </span>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Perlu Perbaikan (Revisi)</h3>
                        <div class="mt-2 text-sm text-gray-600 bg-amber-50 p-3 rounded-lg border border-amber-100">
                            <span class="font-semibold text-amber-800 block mb-1">Catatan Verifikator:</span>
                            "{{ $portfolio->rejection_reason }}"
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Silakan perbaiki data sesuai catatan di atas lalu simpan kembali untuk diverifikasi ulang.</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- FORM SECTION --}}
        <form method="POST" action="{{ route('student.portfolios.update', $portfolio) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                {{-- Form Content --}}
                <div class="p-6 sm:p-10">
                    @include('student.portfolios._form', ['portfolio' => $portfolio, 'categories' => $categories])
                </div>

                {{-- Action Footer --}}
                <div class="bg-gray-50 px-6 py-5 sm:px-10 border-t border-gray-100 flex flex-col-reverse sm:flex-row sm:items-center justify-between gap-4">
                    
                    {{-- Tombol Hapus (Kiri) --}}
                    @if(!$isLocked)
                        <x-confirm :action="route('student.portfolios.destroy', $portfolio)" method="DELETE" type="error" title="Hapus Data" message="Apakah Anda yakin? Data yang dihapus tidak dapat dikembalikan.">
                            <x-slot name="trigger">
                                <button type="button" class="w-full sm:w-auto inline-flex justify-center items-center gap-2 rounded-lg border border-red-200 px-4 py-2.5 text-sm font-semibold text-red-600 hover:bg-red-50 hover:border-red-300 transition-all focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                    <x-heroicon-o-trash class="h-5 w-5" />
                                    Hapus Data
                                </button>
                            </x-slot>
                        </x-confirm>
                    @else
                        <div></div> {{-- Spacer jika tombol hapus tidak ada --}}
                    @endif

                    {{-- Tombol Aksi Utama (Kanan) --}}
                    <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                        <a href="{{ route('student.portfolios.index') }}" class="inline-flex justify-center items-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 transition-all focus:ring-2 focus:ring-gray-200">
                            Batal
                        </a>
                        
                        @if(!$isLocked)
                            <button type="submit" class="inline-flex justify-center items-center gap-2 rounded-lg bg-[#1b3985] px-6 py-2.5 text-sm font-semibold text-white shadow-md hover:bg-[#152e6b] hover:shadow-lg transition-all focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <x-heroicon-o-check-circle class="h-5 w-5" />
                                Simpan Perubahan
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </form>

    </div>
</x-app-layout>
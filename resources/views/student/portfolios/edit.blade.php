<x-app-layout>
    @php
        $isLocked = $portfolio->status !== 'pending' && $portfolio->status !== 'requires_revision';
    @endphp

    <div class="space-y-6">
        <div class="relative rounded-xl bg-gradient-to-r from-[#1b3985] to-[#2b50a8] p-6 overflow-hidden">
            <div class="relative z-10">
                <h1 class="text-2xl font-bold text-white">Edit Portofolio</h1>
                <p class="text-blue-200 mt-1 max-w-md">Perbarui detail kegiatan, prestasi, atau pengalaman Anda.</p>
            </div>
            <div class="absolute -bottom-12 -right-12 w-40 h-40 rounded-full bg-blue-800 opacity-50"></div>
        </div>

        @if ($errors->any())
            <div class="p-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
                <span class="font-medium">Terjadi kesalahan!</span> {{ $errors->first('general') ?? 'Gagal menyimpan perubahan. Periksa kembali isian Anda.' }}
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
            <form method="POST" action="{{ route('student.portfolios.update', $portfolio) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="p-6 sm:p-8 space-y-6">
                    @if ($isLocked)
                        <div class="flex items-start gap-3 rounded-lg border border-yellow-300 bg-yellow-50 p-4 text-yellow-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0 text-yellow-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 3.011-1.742 3.011H4.42c-1.53 0-2.493-1.677-1.743-3.011l5.58-9.92zM10 13a1 1 0 110-2 1 1 0 010 2zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                            <div>
                                <h3 class="font-bold">Portofolio Dikunci</h3>
                                <p class="text-sm mt-1">Portofolio dengan status "{{ ucfirst($portfolio->status) }}" tidak dapat diubah lagi.</p>
                            </div>
                        </div>
                    @endif
                    @if ($portfolio->status === 'requires_revision' && $portfolio->rejection_reason)
                        <div class="flex items-start gap-3 rounded-lg border border-orange-300 bg-orange-50 p-4 text-orange-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0 text-orange-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" /></svg>
                            <div>
                                <h3 class="font-bold">Perlu Perbaikan</h3>
                                <p class="text-sm mt-1">Verifikator meminta perbaikan dengan catatan: <br><span class="font-semibold italic">"{{ $portfolio->rejection_reason }}"</span></p>
                            </div>
                        </div>
                    @endif
                </div>
                
                @include('student.portfolios._form', ['portfolio' => $portfolio, 'categories' => $categories])

                <div class="bg-gray-50 px-6 py-4 flex flex-col-reverse sm:flex-row sm:items-center sm:justify-between gap-4 rounded-b-xl">
                    <x-confirm :action="route('student.portfolios.destroy', $portfolio)" method="DELETE" type="error" title="Hapus Portofolio" message="Anda yakin ingin menghapus portofolio ini?">
                        <x-slot name="trigger">
                            <button type="button" class="w-full sm:w-auto inline-flex items-center justify-center rounded-md text-sm font-semibold text-red-600 hover:bg-red-50 px-3 py-2 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                                Hapus
                            </button>
                        </x-slot>
                    </x-confirm>
                    <div class="flex items-center gap-4 w-full sm:w-auto flex-col-reverse sm:flex-row">
                        <a href="{{ route('student.portfolios.index') }}" class="w-full sm:w-auto inline-flex justify-center rounded-md text-sm font-semibold text-gray-700 hover:bg-gray-200 px-4 py-2 transition-colors border border-gray-300 bg-white">
                            Kembali
                        </a>
                        <x-primary-button :disabled="$isLocked">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" /><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" /></svg>
                            Simpan Perubahan
                        </x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

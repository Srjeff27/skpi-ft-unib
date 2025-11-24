<x-app-layout>
    <div class="space-y-6">
        <div class="relative rounded-xl bg-gradient-to-r from-[#1b3985] to-[#2b50a8] p-6 overflow-hidden">
            <div class="relative z-10">
                <h1 class="text-2xl font-bold text-white">Unggah Portofolio Baru</h1>
                <p class="text-blue-200 mt-1 max-w-md">Isi detail kegiatan, prestasi, atau pengalaman yang ingin Anda ajukan.</p>
            </div>
            <div class="absolute -bottom-12 -right-12 w-40 h-40 rounded-full bg-blue-800 opacity-50"></div>
        </div>

        @if ($errors->any())
            <div class="p-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
                <span class="font-medium">Terjadi kesalahan!</span> {{ $errors->first('general') ?? 'Gagal mengunggah portofolio. Periksa kembali isian Anda.' }}
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
            <form method="POST" action="{{ route('student.portfolios.store') }}" enctype="multipart/form-data">
                @csrf
                
                @include('student.portfolios._form', ['portfolio' => null])

                <div class="bg-gray-50 px-6 py-4 flex items-center justify-end gap-4 rounded-b-xl">
                    <a href="{{ route('student.portfolios.index') }}"
                        class="inline-flex justify-center rounded-md text-sm font-semibold text-gray-700 hover:bg-gray-200 px-4 py-2 transition-colors border border-gray-300 bg-white shadow-sm">
                        Batal
                    </a>
                    <x-primary-button>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 13H11V9.414l-1.293 1.293a1 1 0 01-1.414-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L13 9.414V13h-2.5z" />
                            <path d="M9 13h2v5a1 1 0 11-2 0v-5z" />
                        </svg>
                        Upload Portofolio
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

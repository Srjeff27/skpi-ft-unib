<x-app-layout>
    <div class="space-y-6">
        <div class="relative rounded-xl bg-gradient-to-r from-[#1b3985] to-[#2b50a8] p-6 overflow-hidden">
            <div class="relative z-10">
                <h1 class="text-2xl font-bold text-white">Dokumen SKPI</h1>
                <p class="text-blue-200 mt-1 max-w-lg">Pratinjau dan ajukan Surat Keterangan Pendamping Ijazah (SKPI) Anda di sini. Pastikan semua data sudah benar sebelum mengajukan.</p>
            </div>
            <div class="absolute -bottom-12 -right-12 w-40 h-40 rounded-full bg-blue-800 opacity-50"></div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                    <div class="p-4 sm:p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Pratinjau Dokumen</h3>
                        <p class="text-sm text-gray-500 mt-1">Ini adalah tampilan SKPI Anda berdasarkan data profil dan portofolio yang telah disetujui.</p>
                    </div>
                    <div class="p-4 sm:p-6 bg-gray-50/50">
                        <div x-data="{ loading: true }" class="relative aspect-[1/1.414] w-full max-w-2xl mx-auto bg-white rounded-lg shadow-lg border">
                            <div x-show="loading" class="absolute inset-0 flex items-center justify-center bg-gray-100">
                                <div class="text-center">
                                    <svg class="mx-auto h-8 w-8 text-gray-400 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    <p class="mt-2 text-sm text-gray-500">Memuat pratinjau...</p>
                                </div>
                            </div>
                            <iframe @load="loading = false" src="{{ route('student.skpi.download') }}" class="w-full h-full border-0" title="Pratinjau SKPI"></iframe>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800">Status Pengajuan</h3>
                        <div class="mt-4 flex items-center gap-3 rounded-lg bg-blue-50 text-blue-900 border border-blue-200 p-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span class="font-semibold text-sm">Belum Diajukan</span>
                        </div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800">Langkah Pengajuan</h3>
                        <ul class="mt-4 space-y-4 text-sm">
                            <li class="flex gap-3">
                                <span class="flex-shrink-0 flex items-center justify-center h-6 w-6 rounded-full bg-green-100 text-green-700 font-bold">1</span>
                                <span class="text-gray-600">Periksa kembali <a href="{{ route('profile.edit') }}" class="font-medium text-[#1b3985] hover:underline">data profil</a> Anda.</span>
                            </li>
                            <li class="flex gap-3">
                                <span class="flex-shrink-0 flex items-center justify-center h-6 w-6 rounded-full bg-green-100 text-green-700 font-bold">2</span>
                                <span class="text-gray-600">Pastikan semua <a href="{{ route('student.portfolios.index') }}" class="font-medium text-[#1b3985] hover:underline">portofolio</a> yang ingin dicantumkan telah disetujui.</span>
                            </li>
                            <li class="flex gap-3">
                                <span class="flex-shrink-0 flex items-center justify-center h-6 w-6 rounded-full bg-green-100 text-green-700 font-bold">3</span>
                                <span class="text-gray-600">Periksa dokumen pada panel pratinjau.</span>
                            </li>
                            <li class="flex gap-3">
                                <span class="flex-shrink-0 flex items-center justify-center h-6 w-6 rounded-full bg-gray-200 text-gray-700 font-bold">4</span>
                                <span class="text-gray-600">Jika semua sudah benar, klik tombol "Ajukan SKPI".</span>
                            </li>
                        </ul>
                    </div>
                    <div class="p-6 bg-gray-50/50 border-t border-gray-200 space-y-3">
                        <form method="POST" action="{{ route('student.skpi.apply') }}" onsubmit="return confirm('Anda yakin ingin mengajukan SKPI sekarang? Pastikan semua data sudah benar.')">
                            @csrf
                            <button class="w-full inline-flex items-center justify-center rounded-md bg-[#1b3985] hover:bg-blue-800 text-white px-4 py-2.5 text-sm font-semibold shadow-sm transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.428A1 1 0 009.026 16h1.948a1 1 0 00.754-.364l5-1.428a1 1 0 001.17-1.408l-7-14z" /></svg>
                                Ajukan SKPI
                            </button>
                        </form>
                        <a href="{{ route('student.skpi.download') }}" target="_blank" class="w-full inline-flex items-center justify-center rounded-md border border-gray-300 bg-white text-gray-700 px-4 py-2.5 text-sm font-semibold shadow-sm hover:bg-gray-50 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                            Unduh PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

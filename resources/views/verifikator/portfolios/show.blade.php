<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">Detail Portofolio</h2>
        <p class="text-sm text-gray-500">Verifikasi dan beri catatan</p>
    </x-slot>

<div class="pt-8 pb-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                <x-toast type="success" :message="session('status')" />
            @endif
            @if ($errors->any())
                <x-toast type="error" :message="$errors->first()" :auto-close="false" />
            @endif
            <div class="bg-white rounded-lg shadow-sm p-5 space-y-4">
                <div class="text-sm text-gray-500">Mahasiswa</div>
                <div class="text-lg font-semibold">{{ $portfolio->user->name }} ({{ $portfolio->user->nim ?? '-' }})</div>
                <div class="text-sm text-gray-600">Prodi: {{ optional($portfolio->user->prodi)->nama_prodi ?? '-' }}</div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-5 space-y-3">
                <div><span class="text-sm text-gray-500">Judul</span><div class="font-medium">{{ $portfolio->judul_kegiatan }}</div></div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div><span class="text-sm text-gray-500">Kategori</span><div>{{ $portfolio->kategori_portfolio }}</div></div>
                    <div><span class="text-sm text-gray-500">Penyelenggara</span><div>{{ $portfolio->penyelenggara }}</div></div>
                    <div><span class="text-sm text-gray-500">Tanggal</span><div>{{ optional($portfolio->tanggal_dokumen)->format('d/m/Y') }}</div></div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div><span class="text-sm text-gray-500">Nama Dokumen (ID)</span><div>{{ $portfolio->nama_dokumen_id ?? '-' }}</div></div>
                    <div><span class="text-sm text-gray-500">Nomor Dokumen</span><div>{{ $portfolio->nomor_dokumen ?? '-' }}</div></div>
                </div>
                <div><span class="text-sm text-gray-500">Deskripsi</span><div class="text-gray-800">{{ $portfolio->deskripsi_kegiatan }}</div></div>
                <div><span class="text-sm text-gray-500">Bukti</span>
                    @if($portfolio->link_sertifikat)
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ $portfolio->link_sertifikat }}" target="_blank" class="text-[#1b3985] underline">Lihat Bukti</a>
                            <a href="{{ $portfolio->link_sertifikat }}" target="_blank" class="inline-flex items-center rounded-md bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 text-sm">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Lihat Sertifikat
                            </a>
                        </div>
                    @else
                        <div class="text-gray-500">-</div>
                    @endif
                </div>
                <div><span class="text-sm text-gray-500">Status Saat Ini</span><div class="font-medium">{{ ucfirst($portfolio->status) }}</div></div>
                @if($portfolio->catatan_verifikator)
                    <div><span class="text-sm text-gray-500">Catatan verifikator</span><div class="text-gray-800">{{ $portfolio->catatan_verifikator }}</div></div>
                @endif
            </div>

            @if($portfolio->status === 'pending')
            <div class="bg-white rounded-lg shadow-sm p-5 space-y-4">
                <div class="font-semibold">Tindakan</div>
                <form method="POST" action="{{ route('verifikator.portfolios.approve', $portfolio) }}" class="space-y-2">
                    @csrf
                    <label class="text-sm text-gray-600">Catatan (opsional)</label>
                    <textarea name="catatan" class="w-full border-gray-300 rounded-md" rows="2" placeholder="Catatan untuk mahasiswa (opsional)"></textarea>
                    <button class="inline-flex items-center rounded-md bg-green-600 hover:bg-green-700 text-white px-4 py-2 text-sm">Approve</button>
                </form>

                <form method="POST" action="{{ route('verifikator.portfolios.reject', $portfolio) }}" class="space-y-2">
                    @csrf
                    <label class="text-sm text-gray-600">Alasan penolakan</label>
                    <textarea name="alasan" class="w-full border-gray-300 rounded-md" rows="2" required placeholder="Tulis alasan penolakan"></textarea>
                    <button class="inline-flex items-center rounded-md bg-red-600 hover:bg-red-700 text-white px-4 py-2 text-sm">Reject</button>
                </form>

                <form method="POST" action="{{ route('verifikator.portfolios.request_edit', $portfolio) }}" class="space-y-2">
                    @csrf
                    <label class="text-sm text-gray-600">Catatan perbaikan</label>
                    <textarea name="catatan" class="w-full border-gray-300 rounded-md" rows="2" required placeholder="Contoh: perbaiki typo pada judul"></textarea>
                    <button class="inline-flex items-center rounded-md bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 text-sm">Minta Perbaikan</button>
                </form>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>

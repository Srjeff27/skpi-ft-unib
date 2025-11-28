<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="font-bold text-2xl text-[#1b3985] leading-tight">Verifikasi Portofolio</h2>
                <p class="text-sm text-slate-500 mt-1">Tinjau kelayakan dokumen dan berikan keputusan akademik.</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ url()->previous() }}" class="inline-flex items-center text-sm font-medium text-slate-600 hover:text-[#1b3985] transition-colors">
                    <x-heroicon-o-arrow-left class="w-4 h-4 mr-1" />
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8" x-data="{ showDeleteModal: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Alerts --}}
            @if (session('status'))
                <x-toast type="success" :message="session('status')" class="mb-6" />
            @endif
            @if ($errors->any())
                <div class="mb-6 rounded-lg bg-red-50 p-4 border-l-4 border-red-500">
                    <div class="flex">
                        <x-heroicon-s-x-circle class="h-5 w-5 text-red-400" />
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan input</h3>
                            <div class="mt-2 text-sm text-red-700">{{ $errors->first() }}</div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- KOLOM KIRI: Detail Dokumen --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                            <h3 class="font-bold text-lg text-slate-800 flex items-center gap-2">
                                <x-heroicon-o-document-text class="w-5 h-5 text-[#1b3985]" />
                                Informasi Dokumen
                            </h3>
                            @php
                                $statusColors = [
                                    'pending' => 'bg-amber-100 text-amber-700 border-amber-200',
                                    'verified' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                    'rejected' => 'bg-rose-100 text-rose-700 border-rose-200',
                                    'requires_revision' => 'bg-orange-100 text-orange-700 border-orange-200',
                                ];
                                $colorClass = $statusColors[$portfolio->status] ?? 'bg-gray-100 text-gray-700 border-gray-200';
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $colorClass }} uppercase tracking-wide">
                                {{ $portfolio->status }}
                            </span>
                        </div>
                        
                        <div class="p-6 space-y-6">
                            {{-- Judul --}}
                            <div>
                                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Judul Kegiatan/Prestasi</label>
                                <p class="text-lg font-medium text-slate-900">{{ $portfolio->judul_kegiatan }}</p>
                            </div>

                            {{-- Grid Info --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Kategori</label>
                                    <div class="flex items-center gap-2 text-slate-700">
                                        <x-heroicon-o-tag class="w-4 h-4 text-slate-400" />
                                        {{ $portfolio->kategori_portfolio }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Penyelenggara</label>
                                    <div class="flex items-center gap-2 text-slate-700">
                                        <x-heroicon-o-building-office class="w-4 h-4 text-slate-400" />
                                        {{ $portfolio->penyelenggara }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Tanggal Pelaksanaan</label>
                                    <div class="flex items-center gap-2 text-slate-700">
                                        <x-heroicon-o-calendar class="w-4 h-4 text-slate-400" />
                                        {{ optional($portfolio->tanggal_dokumen)->isoFormat('D MMMM YYYY') }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Nomor Dokumen</label>
                                    <div class="flex items-center gap-2 text-slate-700">
                                        <x-heroicon-o-hashtag class="w-4 h-4 text-slate-400" />
                                        {{ $portfolio->nomor_dokumen ?? '-' }}
                                    </div>
                                </div>
                            </div>

                            {{-- Deskripsi --}}
                            <div class="pt-4 border-t border-slate-100">
                                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Deskripsi Kegiatan</label>
                                <div class="prose prose-sm text-slate-600 bg-slate-50 p-4 rounded-lg border border-slate-100">
                                    {{ $portfolio->deskripsi_kegiatan }}
                                </div>
                            </div>

                            {{-- Bukti Fisik --}}
                            <div class="pt-2">
                                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Bukti Pendukung</label>
                                @if($portfolio->link_sertifikat)
                                    @php
                                        $proofUrl = \Illuminate\Support\Str::startsWith($portfolio->link_sertifikat, ['http://','https://'])
                                            ? $portfolio->link_sertifikat
                                            : route('portfolios.proof', $portfolio);
                                    @endphp
                                    <a href="{{ $proofUrl }}" target="_blank" 
                                       class="group flex items-center justify-between p-4 bg-white border border-slate-200 rounded-xl hover:border-[#1b3985] hover:shadow-md transition-all duration-200">
                                        <div class="flex items-center gap-3">
                                            <div class="p-2 bg-blue-50 text-[#1b3985] rounded-lg group-hover:bg-[#1b3985] group-hover:text-white transition-colors">
                                                <x-heroicon-o-paper-clip class="w-6 h-6" />
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-slate-900">Lampiran Sertifikat/Bukti</p>
                                                <p class="text-xs text-slate-500">Klik untuk membuka dokumen</p>
                                            </div>
                                        </div>
                                        <x-heroicon-o-arrow-top-right-on-square class="w-5 h-5 text-slate-400 group-hover:text-[#1b3985]" />
                                    </a>
                                @else
                                    <div class="text-sm text-slate-500 italic flex items-center gap-2 bg-slate-50 p-3 rounded-lg">
                                        <x-heroicon-o-exclamation-circle class="w-5 h-5" />
                                        Tidak ada bukti lampiran.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Riwayat Catatan (Jika ada) --}}
                    @if($portfolio->catatan_verifikator)
                        <div class="bg-amber-50 rounded-xl p-6 border border-amber-200">
                            <h4 class="font-bold text-amber-800 mb-2 flex items-center gap-2">
                                <x-heroicon-s-chat-bubble-left-right class="w-5 h-5" />
                                Catatan Sebelumnya
                            </h4>
                            <p class="text-sm text-amber-900">{{ $portfolio->catatan_verifikator }}</p>
                        </div>
                    @endif
                </div>

                {{-- KOLOM KANAN: Info Mahasiswa & Panel Aksi --}}
                <div class="lg:col-span-1 space-y-6">
                    
                    {{-- Kartu Mahasiswa --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="h-12 w-12 rounded-full bg-[#1b3985] text-white flex items-center justify-center font-bold text-lg">
                                {{ substr($portfolio->user->name, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 leading-tight">{{ $portfolio->user->name }}</h4>
                                <p class="text-xs text-slate-500 font-mono">{{ $portfolio->user->nim ?? 'NIM Tidak Ada' }}</p>
                            </div>
                        </div>
                        <div class="pt-4 border-t border-slate-100">
                            <p class="text-xs text-slate-400 uppercase">Program Studi</p>
                            <p class="text-sm font-semibold text-slate-700 mt-0.5">
                                {{ optional($portfolio->user->prodi)->nama_prodi ?? '-' }}
                            </p>
                        </div>
                    </div>

                    {{-- Panel Aksi (Hanya Tampil jika Pending) --}}
                    @if($portfolio->status === 'pending')
                        <div x-data="{ action: null }" class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden sticky top-6">
                            <div class="bg-slate-50 px-6 py-4 border-b border-slate-200">
                                <h3 class="font-bold text-slate-800">Keputusan Verifikasi</h3>
                            </div>

                            {{-- Pilihan Tombol Awal --}}
                            <div x-show="!action" class="p-6 grid gap-3" x-transition:enter>
                                <button @click="action = 'approve'" class="w-full flex items-center justify-between px-4 py-3 bg-emerald-50 text-emerald-700 rounded-xl border border-emerald-200 hover:bg-emerald-100 transition-colors font-semibold">
                                    <span>Setujui (Approve)</span>
                                    <x-heroicon-s-check-circle class="w-5 h-5" />
                                </button>
                                <button @click="action = 'revision'" class="w-full flex items-center justify-between px-4 py-3 bg-amber-50 text-amber-700 rounded-xl border border-amber-200 hover:bg-amber-100 transition-colors font-semibold">
                                    <span>Minta Revisi</span>
                                    <x-heroicon-s-pencil-square class="w-5 h-5" />
                                </button>
                                <button @click="action = 'reject'" class="w-full flex items-center justify-between px-4 py-3 bg-rose-50 text-rose-700 rounded-xl border border-rose-200 hover:bg-rose-100 transition-colors font-semibold">
                                    <span>Tolak (Reject)</span>
                                    <x-heroicon-s-x-circle class="w-5 h-5" />
                                </button>
                                <div class="pt-2">
                                    <button @click="showDeleteModal = true" class="w-full flex items-center justify-center px-4 py-3 bg-red-50 text-red-700 rounded-xl border border-red-200 hover:bg-red-100 transition-colors font-semibold">
                                        <x-heroicon-s-trash class="w-5 h-5 mr-2" />
                                        Hapus Portofolio
                                    </button>
                                </div>
                            </div>

                            {{-- Form Approve --}}
                            <div x-show="action === 'approve'" class="p-6" x-cloak x-transition>
                                <form method="POST" action="{{ route('verifikator.portfolios.approve', $portfolio) }}">
                                    @csrf
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-slate-700 mb-1">Catatan Tambahan (Opsional)</label>
                                        <textarea name="catatan" rows="3" class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm" placeholder="Pesan penyemangat..."></textarea>
                                    </div>
                                    <div class="flex gap-2">
                                        <button type="submit" class="flex-1 bg-emerald-600 text-white py-2 rounded-lg font-semibold hover:bg-emerald-700 transition-colors shadow-md shadow-emerald-200">Konfirmasi</button>
                                        <button type="button" @click="action = null" class="px-4 py-2 border border-slate-300 rounded-lg text-slate-600 hover:bg-slate-50 font-medium">Batal</button>
                                    </div>
                                </form>
                            </div>

                            {{-- Form Revisi --}}
                            <div x-show="action === 'revision'" class="p-6" x-cloak x-transition>
                                <form method="POST" action="{{ route('verifikator.portfolios.request_edit', $portfolio) }}">
                                    @csrf
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-slate-700 mb-1">Poin Perbaikan <span class="text-red-500">*</span></label>
                                        <textarea name="catatan" rows="3" required class="w-full rounded-lg border-slate-300 focus:border-amber-500 focus:ring-amber-500 text-sm" placeholder="Misal: Nama kegiatan typo, lampiran buram..."></textarea>
                                    </div>
                                    <div class="flex gap-2">
                                        <button type="submit" class="flex-1 bg-amber-500 text-white py-2 rounded-lg font-semibold hover:bg-amber-600 transition-colors shadow-md shadow-amber-200">Kirim Revisi</button>
                                        <button type="button" @click="action = null" class="px-4 py-2 border border-slate-300 rounded-lg text-slate-600 hover:bg-slate-50 font-medium">Batal</button>
                                    </div>
                                </form>
                            </div>

                            {{-- Form Reject --}}
                            <div x-show="action === 'reject'" class="p-6" x-cloak x-transition>
                                <form method="POST" action="{{ route('verifikator.portfolios.reject', $portfolio) }}">
                                    @csrf
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-slate-700 mb-1">Alasan Penolakan <span class="text-red-500">*</span></label>
                                        <textarea name="alasan" rows="3" required class="w-full rounded-lg border-slate-300 focus:border-rose-500 focus:ring-rose-500 text-sm" placeholder="Jelaskan mengapa dokumen ini tidak valid..."></textarea>
                                    </div>
                                    <div class="flex gap-2">
                                        <button type="submit" class="flex-1 bg-rose-600 text-white py-2 rounded-lg font-semibold hover:bg-rose-700 transition-colors shadow-md shadow-rose-200">Tolak Permanen</button>
                                        <button type="button" @click="action = null" class="px-4 py-2 border border-slate-300 rounded-lg text-slate-600 hover:bg-slate-50 font-medium">Batal</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @else
                        {{-- Pesan Jika Sudah Diproses --}}
                        <div class="bg-gray-50 rounded-xl p-6 text-center border border-gray-200 space-y-4">
                            <x-heroicon-o-lock-closed class="w-10 h-10 text-gray-400 mx-auto" />
                            <div>
                                <h4 class="font-bold text-gray-900">Telah Diverifikasi</h4>
                                <p class="text-sm text-gray-500 mt-1">Dokumen ini tidak dapat diubah lagi statusnya.</p>
                            </div>
                            <button @click="showDeleteModal = true" class="w-full flex items-center justify-center mt-4 px-4 py-3 bg-red-600 text-white rounded-xl font-semibold hover:bg-red-700 transition-colors shadow-md shadow-red-200">
                                <x-heroicon-s-trash class="w-5 h-5 mr-2" />
                                Hapus Portofolio
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Modal Hapus Portofolio -->
            <div x-show="showDeleteModal" x-cloak 
                 x-transition:enter="transition ease-out duration-300" 
                 x-transition:enter-start="opacity-0" 
                 x-transition:enter-end="opacity-100" 
                 x-transition:leave="transition ease-in duration-200" 
                 x-transition:leave-start="opacity-100" 
                 x-transition:leave-end="opacity-0" 
                 class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
                <div @click.away="showDeleteModal = false" class="w-full max-w-lg rounded-xl bg-white p-6 shadow-xl">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                        <x-heroicon-s-trash class="w-5 h-5 text-red-500" />
                        Hapus Portofolio
                    </h3>
                    <p class="text-sm text-gray-500 mt-1 mb-4">Anda akan menghapus portofolio <span class="font-bold">"{{ $portfolio->judul_kegiatan }}"</span> secara permanen. Tindakan ini tidak dapat diurungkan.</p>
                    <form method="POST" action="{{ route('verifikator.portfolios.destroy', $portfolio) }}" class="space-y-4">
                        @csrf
                        @method('DELETE')
                        <div>
                            <label for="alasan_hapus" class="block text-sm font-medium text-gray-700">Alasan Penghapusan <span class="text-red-500">*</span></label>
                            <textarea id="alasan_hapus" name="alasan_hapus" rows="3" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500" placeholder="Jelaskan mengapa portofolio ini dihapus..."></textarea>
                        </div>
                        <div class="flex items-center justify-end gap-4 pt-4">
                            <button type="button" @click="showDeleteModal = false" class="rounded-lg border border-gray-200 bg-white px-4 py-2 text-center text-sm font-medium text-gray-700 shadow-sm transition-all hover:bg-gray-50">Batal</button>
                            <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition-all hover:bg-red-700">Ya, Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

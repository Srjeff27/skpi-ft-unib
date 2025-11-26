<x-app-layout>
    @php
        $user = auth()->user();
        $portfolios = \App\Models\Portfolio::where('user_id', $user->id)->latest()->get();
        
        $stats = [
            'semua' => $portfolios->count(),
            'verified' => $portfolios->where('status', 'verified')->count(),
            'pending' => $portfolios->where('status', 'pending')->count(),
            'rejected' => $portfolios->whereIn('status', ['rejected', 'requires_revision'])->count(),
        ];
        
        $successToast = session('status');
        $errorToast = session('error') ?? ($errors->any() ? 'Gagal memuat data.' : null);
    @endphp

    <div x-data="{
            tab: 'semua',
            toast: { show: false, type: 'success', title: '', message: '' },
            deleteModal: { show: false, name: '', badge: '', meta: '', date: '', formId: null },
            
            init() {
                const successMsg = @js($successToast);
                const errorMsg = @js($errorToast);
                if (successMsg) this.showToast('success', 'Berhasil', successMsg);
                if (errorMsg) this.showToast('error', 'Terjadi Kesalahan', errorMsg);
            },
            
            showToast(type, title, message) {
                this.toast = { show: true, type, title, message };
                setTimeout(() => this.toast.show = false, 4000);
            },
            
            confirmDelete(detail) {
                this.deleteModal = {
                    show: true,
                    name: detail.name || 'Dokumen',
                    badge: detail.badge || 'Portofolio',
                    meta: detail.meta || '',
                    date: detail.date || '',
                    formId: detail.formId
                };
            },
            
            submitDelete() {
                if (this.deleteModal.formId) {
                    document.getElementById(this.deleteModal.formId)?.submit();
                }
                this.deleteModal.show = false;
            }
        }"
        @open-delete.window="confirmDelete($event.detail)"
        class="min-h-[80vh] space-y-8 pb-20">

        {{-- 1. Header Section --}}
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#0f2456] via-[#1b3985] to-[#2b50a8] p-8 sm:p-10 shadow-xl group">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 h-64 w-64 rounded-full bg-white/5 blur-3xl group-hover:bg-white/10 transition-colors duration-700"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 h-40 w-40 rounded-full bg-blue-400/10 blur-2xl"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="space-y-2">
                    <h1 class="text-3xl font-bold text-white tracking-tight">Portofolio Saya</h1>
                    <p class="text-blue-100/90 text-sm md:text-base max-w-xl leading-relaxed">
                        Kelola arsip prestasi akademik dan non-akademik Anda untuk transkrip SKPI yang valid dan profesional.
                    </p>
                </div>
                
                <a href="{{ route('student.portfolios.create') }}" 
                   class="inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-2xl bg-white text-[#1b3985] font-bold text-sm shadow-lg shadow-blue-900/20 hover:bg-blue-50 hover:scale-[1.02] hover:shadow-xl transition-all duration-300">
                    <x-heroicon-o-plus class="w-5 h-5 stroke-2" />
                    <span>Tambah Baru</span>
                </a>
            </div>
        </div>

        {{-- 2. Main Content --}}
        @if ($portfolios->isEmpty())
            <div class="flex flex-col items-center justify-center py-24 px-4 text-center bg-white border border-dashed border-slate-300 rounded-3xl">
                <div class="h-16 w-16 bg-slate-50 rounded-2xl flex items-center justify-center mb-6 ring-1 ring-slate-100">
                    <x-heroicon-o-document-plus class="w-8 h-8 text-slate-400" />
                </div>
                <h3 class="text-lg font-bold text-slate-900">Belum Ada Portofolio</h3>
                <p class="text-slate-500 max-w-sm mt-2 mb-8 leading-relaxed">
                    Mulai bangun rekam jejak akademik Anda dengan mengunggah sertifikat atau bukti kegiatan pertama Anda.
                </p>
                <a href="{{ route('student.portfolios.create') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-[#1b3985] hover:bg-[#152e6b] text-white font-semibold rounded-xl transition-all shadow-md hover:shadow-lg">
                    <x-heroicon-m-arrow-right class="w-4 h-4" />
                    Unggah Sekarang
                </a>
            </div>
        @else
            <div class="space-y-6">
                {{-- Tabs Navigation (Sticky) --}}
                <div class="sticky top-[80px] z-20 bg-slate-50/90 backdrop-blur-md py-2 -mx-2 px-2 md:static md:bg-transparent md:p-0">
                    <nav class="flex space-x-2 overflow-x-auto pb-2 no-scrollbar" aria-label="Tabs">
                        @php
                            $filters = [
                                ['id' => 'semua', 'label' => 'Semua', 'icon' => 'heroicon-o-squares-2x2'],
                                ['id' => 'verified', 'label' => 'Disetujui', 'icon' => 'heroicon-o-check-badge'],
                                ['id' => 'pending', 'label' => 'Menunggu', 'icon' => 'heroicon-o-clock'],
                                ['id' => 'rejected', 'label' => 'Ditolak/Revisi', 'icon' => 'heroicon-o-exclamation-circle'],
                            ];
                        @endphp

                        @foreach($filters as $f)
                            <button @click="tab = '{{ $f['id'] }}'"
                                :class="tab === '{{ $f['id'] }}' 
                                    ? 'bg-white text-[#1b3985] shadow-md ring-1 ring-slate-200' 
                                    : 'text-slate-500 hover:text-slate-700 hover:bg-white/60'"
                                class="flex-shrink-0 group flex items-center px-4 py-2.5 text-sm font-medium rounded-xl transition-all duration-200">
                                <x-dynamic-component :component="$f['icon']" 
                                    class="mr-2 h-5 w-5" 
                                    :class="tab === '{{ $f['id'] }}' ? 'text-[#1b3985]' : 'text-slate-400 group-hover:text-slate-500'" />
                                {{ $f['label'] }}
                                <span :class="tab === '{{ $f['id'] }}' ? 'bg-blue-50 text-[#1b3985]' : 'bg-slate-200 text-slate-600'"
                                      class="ml-3 py-0.5 px-2.5 rounded-full text-xs font-bold transition-colors">
                                    {{ $stats[$f['id']] }}
                                </span>
                            </button>
                        @endforeach
                    </nav>
                </div>

                {{-- Portfolio Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 min-h-[300px]">
                    @foreach ($portfolios as $p)
                        @php
                            $statusKey = match($p->status) {
                                'verified' => 'verified',
                                'pending' => 'pending',
                                'rejected', 'requires_revision' => 'rejected',
                                default => 'semua'
                            };
                        @endphp

                        <div x-show="tab === 'semua' || tab === '{{ $statusKey }}'"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 scale-[0.98]"
                             x-transition:enter-end="opacity-100 scale-100"
                             class="h-full">
                            {{-- Pastikan file partial ini menggunakan desain Card yang sudah diperbarui --}}
                            @include('student.portfolios._portfolio-list-item', ['portfolio' => $p])
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- 3. Delete Confirmation Modal --}}
        <div x-show="deleteModal.show" 
             style="display: none;"
             class="fixed inset-0 z-50 flex items-center justify-center px-4 sm:px-6" x-cloak>
            
            {{-- Backdrop --}}
            <div x-show="deleteModal.show"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" 
                 @click="deleteModal.show = false">
            </div>

            {{-- Modal Panel --}}
            <div x-show="deleteModal.show"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-2xl ring-1 ring-black/5">
                
                <div class="bg-[#1b3985] px-6 py-6 text-white flex items-center gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-white/10">
                        <x-heroicon-o-trash class="h-6 w-6 text-white" />
                    </div>
                    <div>
                        <h3 class="text-lg font-bold">Konfirmasi Hapus</h3>
                        <p class="text-blue-100 text-sm">Tindakan ini tidak dapat dibatalkan.</p>
                    </div>
                </div>

                <div class="px-6 py-6 space-y-4">
                    <div class="rounded-xl bg-slate-50 border border-slate-100 p-4">
                        <p class="text-xs font-bold uppercase text-slate-400 tracking-wider mb-1" x-text="deleteModal.badge"></p>
                        <h4 class="text-base font-bold text-slate-800 line-clamp-2" x-text="deleteModal.name"></h4>
                        <div class="mt-2 flex items-center gap-3 text-sm text-slate-500">
                            <span class="flex items-center gap-1" x-show="deleteModal.date">
                                <x-heroicon-m-calendar class="w-4 h-4" /> <span x-text="deleteModal.date"></span>
                            </span>
                        </div>
                    </div>
                    
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Apakah Anda yakin ingin menghapus data ini secara permanen? Semua bukti dokumen dan riwayat validasi terkait akan hilang.
                    </p>
                </div>

                <div class="bg-slate-50 px-6 py-4 flex flex-row-reverse gap-3">
                    <button type="button" @click="submitDelete()"
                            class="inline-flex w-full justify-center rounded-xl bg-rose-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-rose-500 sm:w-auto">
                        Ya, Hapus Permanen
                    </button>
                    <button type="button" @click="deleteModal.show = false"
                            class="inline-flex w-full justify-center rounded-xl bg-white px-5 py-2.5 text-sm font-semibold text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:w-auto">
                        Batal
                    </button>
                </div>
            </div>
        </div>

        {{-- 4. Toast Notification --}}
        <div x-show="toast.show" 
             x-transition:enter="transform ease-out duration-300 transition"
             x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
             x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed bottom-6 right-6 z-[60] max-w-sm w-full bg-white rounded-xl shadow-lg border border-slate-100 p-4 pointer-events-auto flex items-start gap-4"
             x-cloak>
            
            <div :class="toast.type === 'success' ? 'text-emerald-500 bg-emerald-50' : 'text-rose-500 bg-rose-50'"
                 class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center">
                <template x-if="toast.type === 'success'">
                    <x-heroicon-m-check-circle class="w-6 h-6" />
                </template>
                <template x-if="toast.type === 'error'">
                    <x-heroicon-m-x-circle class="w-6 h-6" />
                </template>
            </div>
            
            <div class="flex-1 pt-0.5">
                <p class="text-sm font-bold text-slate-900" x-text="toast.title"></p>
                <p class="mt-1 text-sm text-slate-600 leading-relaxed" x-text="toast.message"></p>
            </div>
            
            <button @click="toast.show = false" class="flex-shrink-0 text-slate-400 hover:text-slate-600">
                <x-heroicon-m-x-mark class="w-5 h-5" />
            </button>
        </div>

    </div>
</x-app-layout>
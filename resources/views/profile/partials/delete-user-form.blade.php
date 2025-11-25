<section class="space-y-6">
    <header class="mb-6">
        <h2 class="text-lg font-bold text-slate-900">
            {{ __('Hapus Akun') }}
        </h2>
        <p class="mt-1 text-sm text-slate-600">
            {{ __('Tindakan ini bersifat permanen. Harap pertimbangkan dengan matang sebelum melanjutkan.') }}
        </p>
    </header>

    <div class="rounded-2xl border border-rose-200 bg-rose-50/50 p-6 sm:p-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-rose-100 text-rose-600">
                        <x-heroicon-o-exclamation-triangle class="h-6 w-6" />
                    </div>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-rose-800">
                        {{ __('Peringatan Penghapusan') }}
                    </h3>
                    <p class="mt-1 text-sm text-rose-700/80 leading-relaxed max-w-xl">
                        {{ __('Setelah akun dihapus, semua data portofolio, riwayat SKPI, dan dokumen terkait akan hilang secara permanen. Tindakan ini tidak dapat dibatalkan.') }}
                    </p>
                </div>
            </div>

            <div class="flex-shrink-0 w-full sm:w-auto">
                <x-danger-button
                    x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                    class="w-full sm:w-auto justify-center gap-2 px-6 py-3"
                >
                    <x-heroicon-o-trash class="w-4 h-4" />
                    {{ __('Hapus Akun Saya') }}
                </x-danger-button>
            </div>
        </div>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <div class="text-center sm:text-left">
                <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-rose-100 sm:mx-0 sm:h-10 sm:w-10 mb-4">
                    <x-heroicon-o-exclamation-triangle class="h-6 w-6 text-rose-600" />
                </div>
                
                <h2 class="text-lg font-bold text-slate-900">
                    {{ __('Konfirmasi Penghapusan Akun') }}
                </h2>

                <p class="mt-2 text-sm text-slate-500 leading-relaxed">
                    {{ __('Apakah Anda yakin ingin menghapus akun ini? Masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda pemilik sah akun ini. Data yang dihapus tidak dapat dipulihkan.') }}
                </p>
            </div>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <x-heroicon-o-key class="h-5 w-5 text-slate-400" />
                    </div>
                    <x-text-input
                        id="password"
                        name="password"
                        type="password"
                        class="mt-1 block w-full pl-10 border-slate-300 focus:border-rose-500 focus:ring-rose-500 rounded-lg"
                        placeholder="{{ __('Masukkan kata sandi Anda') }}"
                    />
                </div>

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex flex-col-reverse sm:flex-row justify-end gap-3 border-t border-slate-100 pt-4">
                <x-secondary-button x-on:click="$dispatch('close')" class="justify-center w-full sm:w-auto">
                    {{ __('Batal') }}
                </x-secondary-button>

                <x-danger-button class="justify-center w-full sm:w-auto gap-2 bg-rose-600 hover:bg-rose-700">
                    {{ __('Ya, Hapus Permanen') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
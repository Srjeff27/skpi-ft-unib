<section class="max-w-5xl mx-auto mt-10">
    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-rose-200 overflow-hidden relative">
        <div class="absolute top-0 left-0 w-1 h-full bg-rose-500"></div>
        
        <div class="p-6 sm:p-10 flex flex-col sm:flex-row sm:items-start justify-between gap-6">
            <div class="max-w-xl">
                <h2 class="text-xl font-bold text-rose-700 flex items-center gap-2">
                    <x-heroicon-o-exclamation-triangle class="w-6 h-6" />
                    Hapus Akun Permanen
                </h2>
                <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                    Setelah akun dihapus, semua sumber daya dan data akan hilang selamanya. 
                    Pastikan Anda telah mengunduh dokumen atau data penting sebelum melakukan tindakan ini.
                </p>
            </div>

            <div class="flex-shrink-0">
                <x-danger-button
                    x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                    class="w-full sm:w-auto justify-center"
                >
                    <x-heroicon-o-trash class="w-5 h-5 mr-2" />
                    {{ __('Hapus Akun') }}
                </x-danger-button>
            </div>
        </div>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 sm:p-8">
            @csrf
            @method('delete')

            <div class="text-center sm:text-left">
                <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-rose-100 sm:mx-0 sm:h-10 sm:w-10 mb-4">
                    <x-heroicon-o-exclamation-triangle class="h-6 w-6 text-rose-600" />
                </div>
                
                <h2 class="text-lg font-bold text-gray-900">
                    {{ __('Konfirmasi Penghapusan') }}
                </h2>

                <p class="mt-2 text-sm text-gray-500">
                    Apakah Anda yakin ingin menghapus akun ini? Masukkan kata sandi Anda untuk mengonfirmasi bahwa tindakan ini tidak dapat dibatalkan.
                </p>
            </div>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full"
                    placeholder="{{ __('Masukkan kata sandi Anda') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex flex-col-reverse sm:flex-row justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')" class="justify-center">
                    {{ __('Batal') }}
                </x-secondary-button>

                <x-danger-button class="justify-center">
                    {{ __('Ya, Hapus Akun') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
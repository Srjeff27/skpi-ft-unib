<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">Import Data</h2>
        <p class="text-sm text-gray-500">Import user dari CSV</p>
    </x-slot>

    <div class="pt-8 pb-16">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <form method="POST" action="{{ route('admin.import.users') }}" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <x-input-label value="File CSV" />
                        <input type="file" name="file" accept=".csv" class="mt-1 block w-full" required />
                        <p class="text-xs text-gray-500 mt-1">Header: name,email,role,password,nim,angkatan,prodi</p>
                        <x-input-error :messages="$errors->get('file')" />
                    </div>
                    <div class="mt-4">
                        <button class="px-4 py-2 rounded-md bg-[#1b3985] text-white">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>


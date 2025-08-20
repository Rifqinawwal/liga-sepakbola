<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Liga Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">

                    @if ($errors->any())
                        {{-- ... (bagian error handling tetap sama) ... --}}
                    @endif

                    {{-- PENTING: Tambahkan enctype="multipart/form-data" --}}
                    <form action="{{ route('liga.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Nama Liga --}}
                        <div class="mt-4">
                            <x-input-label for="nama" :value="__('Nama Liga')" />
                            <x-text-input id="nama" class="block mt-1 w-full" type="text" name="nama" :value="old('nama')" required autofocus />
                        </div>

                        {{-- Negara --}}
                        <div class="mt-4">
                            <x-input-label for="negara" :value="__('Negara')" />
                            <x-text-input id="negara" class="block mt-1 w-full" type="text" name="negara" :value="old('negara')" required />
                        </div>

                        {{-- ===== INPUT BENDERA BARU ===== --}}
                        <div class="mt-4">
                            <x-input-label for="bendera" :value="__('Bendera Negara')" />
                            <input id="bendera" name="bendera" type="file" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm p-2" />
                        </div>
                        {{-- ===== AKHIR INPUT BENDERA ===== --}}

                        {{-- Logo Liga --}}
                        <div class="mt-4">
                            <x-input-label for="logo" :value="__('Logo Liga')" />
                            <input id="logo" name="logo" type="file" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm p-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('liga.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                Batal
                            </a>
                            <x-primary-button>
                                {{ __('Simpan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

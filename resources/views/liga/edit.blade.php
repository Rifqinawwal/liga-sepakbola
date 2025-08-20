<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Edit Liga') }}</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                        </div>
                    @endif
                    <form action="{{ route('liga.update', $liga->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Nama Liga --}}
                        <div class="mt-4">
                            <x-input-label for="nama" value="Nama Liga" />
                            <x-text-input id="nama" class="block mt-1 w-full" type="text" name="nama" :value="old('nama', $liga->nama)" required autofocus />
                        </div>

                        {{-- Negara --}}
                        <div class="mt-4">
                            <x-input-label for="negara" value="Negara" />
                            <x-text-input id="negara" class="block mt-1 w-full" type="text" name="negara" :value="old('negara', $liga->negara)" required />
                        </div>

                        {{-- ===== INPUT BENDERA BARU ===== --}}
                        <div class="mt-4">
                            <x-input-label for="bendera" value="Bendera Negara (Kosongkan jika tidak ganti)" />
                            <input id="bendera" name="bendera" type="file" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm p-2" />
                            @if ($liga->bendera_url)
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 mb-1">Bendera saat ini:</p>
                                    <img src="{{ $liga->bendera_url }}" alt="Bendera {{ $liga->negara }}" class="h-10 w-auto border">
                                </div>
                            @endif
                        </div>
                        {{-- ===== AKHIR INPUT BENDERA ===== --}}

                        {{-- Logo Liga --}}
                        <div class="mt-4">
                            <x-input-label for="logo" value="Logo Liga (Kosongkan jika tidak ganti)" />
                            <input id="logo" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm p-2" type="file" name="logo" />
                            @if ($liga->logo_url)
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 mb-1">Logo saat ini:</p>
                                    <img src="{{ $liga->logo_url }}" alt="{{ $liga->nama }}" class="h-16 w-auto">
                                </div>
                            @endif
                        </div>
                        
                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('liga.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                            <x-primary-button>{{ __('Simpan Perubahan') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

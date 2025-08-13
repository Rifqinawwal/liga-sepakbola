<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Pemain') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 text-red-700 border border-red-400 rounded">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('pemain.update', $pemain->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mt-4">
                            <x-input-label for="klub_id" :value="__('Klub')" />
                            <select name="klub_id" id="klub_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                @foreach ($klubs as $klub)
                                    <option value="{{ $klub->id }}" {{ old('klub_id', $pemain->klub_id) == $klub->id ? 'selected' : '' }}>
                                        {{ $klub->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-4">
                            <x-input-label for="nama_pemain" :value="__('Nama Pemain')" />
                            <x-text-input id="nama_pemain" class="block mt-1 w-full" type="text" name="nama_pemain" :value="old('nama_pemain', $pemain->nama_pemain)" required />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="posisi" :value="__('Posisi')" />
                            <x-text-input id="posisi" class="block mt-1 w-full" type="text" name="posisi" :value="old('posisi', $pemain->posisi)" required />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="nomor_punggung" :value="__('Nomor Punggung')" />
                            <x-text-input id="nomor_punggung" class="block mt-1 w-full" type="number" name="nomor_punggung" :value="old('nomor_punggung', $pemain->nomor_punggung)" required />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="foto" :value="__('Foto Pemain (Kosongkan jika tidak ganti)')" />
                            <x-text-input id="foto" class="block mt-1 w-full" type="file" name="foto" />
                            @if ($pemain->foto)
                                <div class="mt-2">
                                    <img src="{{ asset($pemain->foto) }}" alt="{{ $pemain->nama_pemain }}" class="h-20 w-20 rounded-full object-cover">
                                </div>
                            @endif
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('pemain.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                            <x-primary-button>
                                {{ __('Simpan Perubahan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
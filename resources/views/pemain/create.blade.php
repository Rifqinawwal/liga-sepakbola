<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Pemain Baru') }}
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

                    <form action="{{ route('pemain.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Klub -->
                        <div class="mt-4">
                            <x-input-label for="klub_id" :value="__('Klub')" />
                            <select name="klub_id" id="klub_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Pilih Klub</option>
                                @foreach ($klubs as $klub)
                                    <option value="{{ $klub->id }}" {{ old('klub_id') == $klub->id ? 'selected' : '' }}>
                                        {{ $klub->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Nama Pemain -->
                        <div class="mt-4">
                            <x-input-label for="nama_pemain" :value="__('Nama Pemain')" />
                            <x-text-input id="nama_pemain" class="block mt-1 w-full" type="text" name="nama_pemain" :value="old('nama_pemain')" required />
                        </div>

                        <!-- Posisi -->
                        <div class="mt-4">
                            <x-input-label for="posisi" :value="__('Posisi')" />
                            <x-text-input id="posisi" class="block mt-1 w-full" type="text" name="posisi" :value="old('posisi')" required />
                        </div>

                        <!-- Nomor Punggung -->
                        <div class="mt-4">
                            <x-input-label for="nomor_punggung" :value="__('Nomor Punggung')" />
                            <x-text-input id="nomor_punggung" class="block mt-1 w-full" type="number" name="nomor_punggung" :value="old('nomor_punggung')" required />
                        </div>

                        <!-- Foto -->
                        <div class="mt-4">
                            <x-input-label for="foto" :value="__('Foto Pemain')" />
                            <x-text-input id="foto" class="block mt-1 w-full" type="file" name="foto" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('pemain.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">Batal</a>
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
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Jadwal Pertandingan Baru') }}
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

                    <form action="{{ route('pertandingan.store') }}" method="POST">
                        @csrf

                        <!-- Klub Tuan Rumah -->
                        <div class="mt-4">
                            <x-input-label for="klub_tuan_rumah_id" :value="__('Klub Tuan Rumah')" />
                            <select name="klub_tuan_rumah_id" id="klub_tuan_rumah_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">Pilih Klub</option>
                                @foreach ($klubs as $klub)
                                    <option value="{{ $klub->id }}" {{ old('klub_tuan_rumah_id') == $klub->id ? 'selected' : '' }}>
                                        {{ $klub->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Klub Tamu -->
                        <div class="mt-4">
                            <x-input-label for="klub_tamu_id" :value="__('Klub Tamu')" />
                            <select name="klub_tamu_id" id="klub_tamu_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">Pilih Klub</option>
                                @foreach ($klubs as $klub)
                                    <option value="{{ $klub->id }}" {{ old('klub_tamu_id') == $klub->id ? 'selected' : '' }}>
                                        {{ $klub->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tanggal Pertandingan -->
                        <div class="mt-4">
                            <x-input-label for="tanggal_pertandingan" :value="__('Tanggal Pertandingan')" />
                            <x-text-input id="tanggal_pertandingan" class="block mt-1 w-full" type="date" name="tanggal_pertandingan" :value="old('tanggal_pertandingan')" required />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('pertandingan.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                            <x-primary-button>
                                {{ __('Simpan Jadwal') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
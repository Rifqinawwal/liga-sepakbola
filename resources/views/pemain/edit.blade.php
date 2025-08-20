<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Pemain') }}
        </h2>

        {{-- CSS tambahan untuk memperbaiki logo besar setelah dipilih --}}
        <style>
            .select2-selection__rendered .select2-image {
                height: 25px;
                width: auto;
                object-fit: contain;
                display: inline-block;
                vertical-align: middle;
                margin-right: 10px;
                margin-top: -5px;
            }
        </style>
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

                        {{-- Dropdown Klub --}}
                        <div class="mt-4">
                            <x-input-label for="klub_id" :value="__('Klub')" />
                            <select name="klub_id" id="klub_id" class="block mt-1 w-full" required>
                                <option></option> {{-- Opsi kosong untuk placeholder --}}
                                @foreach ($klubs as $klub)
                                    <option value="{{ $klub->id }}" 
                                            data-logo="{{ asset($klub->logo) }}"
                                            {{ old('klub_id', $pemain->klub_id) == $klub->id ? 'selected' : '' }}>
                                        {{ $klub->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Nama Pemain --}}
                        <div class="mt-4">
                            <x-input-label for="nama_pemain" :value="__('Nama Pemain')" />
                            <x-text-input id="nama_pemain" class="block mt-1 w-full" type="text" name="nama_pemain" :value="old('nama_pemain', $pemain->nama_pemain)" required />
                        </div>

                        {{-- Posisi --}}
                        <div class="mt-4">
                            <x-input-label for="posisi" :value="__('Posisi')" />
                            <select class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" id="posisi" name="posisi" required>
                                @php
                                    $posisiOptions = [
                                        'Penjaga Gawang' => ['GK' => 'Goalkeeper (GK)'],
                                        'Pemain Bertahan (Defender)' => ['CB' => 'Centre-Back (CB)', 'LB' => 'Left-Back (LB)', 'RB' => 'Right-Back (RB)', 'LWB' => 'Left Wing-Back (LWB)', 'RWB' => 'Right Wing-Back (RWB)'],
                                        'Pemain Tengah (Midfielder)' => ['DM' => 'Defensive Midfielder (DM)', 'CM' => 'Central Midfielder (CM)', 'AM' => 'Attacking Midfielder (AM)', 'LM' => 'Left Midfielder (LM)', 'RM' => 'Right Midfielder (RM)'],
                                        'Pemain Depan (Forward)' => ['CF' => 'Centre-Forward (CF)', 'SS' => 'Second Striker (SS)', 'LW' => 'Left Winger (LW)', 'RW' => 'Right Winger (RW)']
                                    ];
                                @endphp
                                <option disabled value="">Pilih Posisi</option>
                                @foreach ($posisiOptions as $group => $options)
                                    <optgroup label="{{ $group }}">
                                        @foreach ($options as $value => $label)
                                            <option value="{{ $value }}" {{ old('posisi', $pemain->posisi) == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>

                        {{-- Nomor Punggung --}}
                        <div class="mt-4">
                            <x-input-label for="nomor_punggung" :value="__('Nomor Punggung')" />
                            <x-text-input id="nomor_punggung" class="block mt-1 w-full" type="number" name="nomor_punggung" :value="old('nomor_punggung', $pemain->nomor_punggung)" required />
                        </div>

                        {{-- Foto Pemain --}}
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

    @push('scripts')
    <script>
        $(document).ready(function() {
            function formatClub (club) {
                if (!club.id) { return club.text; }
                var logoPath = $(club.element).data('logo');
                if (!logoPath) { return club.text; }
                var $club = $('<span><img src="' + logoPath + '" class="select2-image" /> ' + club.text + '</span>');
                return $club;
            };

            $('#klub_id').select2({
                placeholder: "Pilih Klub",
                templateResult: formatClub,
                templateSelection: formatClub
            });
        });
    </script>
    @endpush
</x-app-layout>

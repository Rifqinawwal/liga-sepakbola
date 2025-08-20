<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Klub Baru') }}
        </h2>

        {{-- CSS tambahan khusus untuk halaman ini agar logo tidak besar --}}
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
                        <div class="mb-4">
                            <div class="font-medium text-red-600">{{ __('Whoops! Something went wrong.') }}</div>
                            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('klub.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div>
                            <x-input-label for="nama" :value="__('Nama Klub')" />
                            <x-text-input id="nama" class="block mt-1 w-full" type="text" name="nama" :value="old('nama')" required autofocus />
                        </div>

                        {{-- ===== BAGIAN YANG DIUBAH ===== --}}
                        <div class="mt-4">
                            <x-input-label for="liga_id" :value="__('Liga')" />
                            <select name="liga_id" id="liga_id" class="block mt-1 w-full" required>
                                <option></option> {{-- Dikosongkan untuk placeholder Select2 --}}
                                @foreach ($ligas as $liga)
                                    <option value="{{ $liga->id }}" 
                                            data-logo="{{ asset($liga->logo) }}"
                                            {{ old('liga_id') == $liga->id ? 'selected' : '' }}>
                                        {{ $liga->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- ===== AKHIR BAGIAN YANG DIUBAH ===== --}}

                        <div class="mt-4">
                            <x-input-label for="kota" :value="__('Kota Asal')" />
                            <x-text-input id="kota" class="block mt-1 w-full" type="text" name="kota" :value="old('kota')" required />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="stadion" :value="__('Nama Stadion')" />
                            <x-text-input id="stadion" class="block mt-1 w-full" type="text" name="stadion" :value="old('stadion')" required />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="logo" :value="__('Logo Klub')" />
                            <x-text-input id="logo" class="block mt-1 w-full" type="file" name="logo" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('klub.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
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

    {{-- ===== SCRIPT UNTUK MENGAKTIFKAN SELECT2 ===== --}}
    @push('scripts')
    <script>
        $(document).ready(function() {
            function formatLiga (liga) {
                if (!liga.id) {
                    return liga.text;
                }
                var logoPath = $(liga.element).data('logo');
                if (!logoPath) {
                    return liga.text;
                }
                var $liga = $(
                    '<span><img src="' + logoPath + '" class="select2-image" /> ' + liga.text + '</span>'
                );
                return $liga;
            };

            $('#liga_id').select2({
                placeholder: "Pilih Liga",
                templateResult: formatLiga,
                templateSelection: formatLiga
            });
        });
    </script>
    @endpush
</x-app-layout>

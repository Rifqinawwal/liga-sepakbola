@extends('layouts.public')

@section('content')
{{-- ===== CSS TAMBAHAN UNTUK MEMPERBAIKI LOGO BESAR ===== --}}
<style>
    .select2-selection__rendered .select2-image {
        height: 25px;
        width: auto;
        object-fit: contain;
        display: inline-block;
        vertical-align: middle;
        margin-right: 10px;
        margin-top: -5px; /* Penyesuaian posisi vertikal */
    }
</style>
{{-- ===== AKHIR PERBAIKAN ===== --}}

<div class="py-12 pt-28"> {{-- Menambahkan padding-top agar tidak tertutup nav --}}
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 md:p-8 text-gray-900">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
                    Tambah Pemain Baru
                </h2>

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

                    {{-- Klub --}}
                    <div class="mb-4">
                        <label for="klub_id" class="block font-medium text-sm text-gray-700 mb-1">Klub</label>
                        <select id="klub_id" name="klub_id" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            <option></option> {{-- Opsi kosong untuk placeholder --}}
                            @foreach($klubs as $klub)
                                <option value="{{ $klub->id }}" data-logo="{{ asset($klub->logo) }}">
                                    {{ $klub->nama }} ({{ $klub->liga->nama }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Nama Pemain --}}
                    <div class="mt-4">
                        <label for="nama_pemain" class="block font-medium text-sm text-gray-700 mb-1">Nama Pemain</label>
                        <input id="nama_pemain" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="text" name="nama_pemain" value="{{ old('nama_pemain') }}" required />
                    </div>

                    {{-- Posisi --}}
                    <div class="mt-4">
                        <label for="posisi" class="block font-medium text-sm text-gray-700 mb-1">Posisi</label>
                        <select id="posisi" name="posisi" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            <option selected disabled value="">Pilih Posisi</option>
                            <optgroup label="Penjaga Gawang">
                                <option value="GK">Goalkeeper (GK)</option>
                            </optgroup>
                            <optgroup label="Pemain Bertahan (Defender)">
                                <option value="CB">Centre-Back (CB)</option>
                                <option value="LB">Left-Back (LB)</option>
                                <option value="RB">Right-Back (RB)</option>
                            </optgroup>
                            <optgroup label="Pemain Tengah (Midfielder)">
                                <option value="DM">Defensive Midfielder (DM)</option>
                                <option value="CM">Central Midfielder (CM)</option>
                                <option value="AM">Attacking Midfielder (AM)</option>
                            </optgroup>
                            <optgroup label="Pemain Depan (Forward)">
                                <option value="CF">Centre-Forward (CF)</option>
                                <option value="LW">Left Winger (LW)</option>
                                <option value="RW">Right Winger (RW)</option>
                            </optgroup>
                        </select>
                    </div>

                    {{-- Nomor Punggung --}}
                    <div class="mt-4">
                        <label for="nomor_punggung" class="block font-medium text-sm text-gray-700 mb-1">Nomor Punggung</label>
                        <input id="nomor_punggung" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="number" name="nomor_punggung" value="{{ old('nomor_punggung') }}" required />
                    </div>

                    {{-- Foto Pemain --}}
                    <div class="mt-4">
                        <label for="foto" class="block font-medium text-sm text-gray-700 mb-1">Foto Pemain</label>
                        <input id="foto" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm p-2" type="file" name="foto" />
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('pemain.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            Simpan
                        </button>
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
            if (!club.id) {
                return club.text;
            }
            var logoPath = $(club.element).data('logo');
            if (!logoPath) {
                return club.text;
            }
            var $club = $(
                '<span><img src="' + logoPath + '" class="select2-image" /> ' + club.text + '</span>'
            );
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
@endsection

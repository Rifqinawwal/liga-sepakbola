<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kelola Statistik Pertandingan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('pertandingan.statistik.update', $pertandingan->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="text-center">
                            <h3 class="text-2xl font-bold">{{ $pertandingan->klubTuanRumah->nama }} vs {{ $pertandingan->klubTamu->nama }}</h3>
                            <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($pertandingan->tanggal_pertandingan)->format('l, d F Y') }}</p>
                            @if (session('error'))
                                <div class="mt-4 p-4 bg-red-100 text-red-700 border border-red-400 rounded max-w-xl mx-auto">{{ session('error') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Skor Akhir</h3>
                        <div class="grid grid-cols-2 gap-4 items-center">
                            <div class="text-center">
                                <x-input-label for="skor_tuan_rumah" :value="__($pertandingan->klubTuanRumah->nama)" />
                                <x-text-input id="skor_tuan_rumah" class="block mt-1 w-full text-center" type="number" name="skor_tuan_rumah" :value="old('skor_tuan_rumah', $pertandingan->skor_tuan_rumah)" required />
                            </div>
                            <div class="text-center">
                                <x-input-label for="skor_tamu" :value="__($pertandingan->klubTamu->nama)" />
                                <x-text-input id="skor_tamu" class="block mt-1 w-full text-center" type="number" name="skor_tamu" :value="old('skor_tamu', $pertandingan->skor_tamu)" required />
                            </div>
                        </div>
                    </div>

                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Pencetak Gol</h3>
                            <button type="button" id="tambah-gol" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800">+ Tambah Baris Gol</button>
                        </div>
                        <div id="daftar-gol" class="space-y-3">
                            @foreach($pertandingan->gols as $gol)
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center gol-row">
                                <div><select name="gols[{{$loop->index}}][pemain_id]" class="block w-full border-gray-300 rounded-md shadow-sm"><option value="">Pencetak Gol</option>@foreach($pemains as $pemain)<option value="{{ $pemain->id }}" {{$gol->pemain_id == $pemain->id ? 'selected' : ''}}>{{$pemain->nama_pemain}}</option>@endforeach</select></div>
                                <div><select name="gols[{{$loop->index}}][assist_pemain_id]" class="block w-full border-gray-300 rounded-md shadow-sm"><option value="">Pemberi Assist</option>@foreach($pemains as $pemain)<option value="{{ $pemain->id }}" {{$gol->assist_pemain_id == $pemain->id ? 'selected' : ''}}>{{$pemain->nama_pemain}}</option>@endforeach</select></div>
                                <div><x-text-input type="number" name="gols[{{$loop->index}}][menit_gol]" value="{{$gol->menit_gol}}" class="block w-full" placeholder="Menit ke-" /></div>
                                <div><button type="button" class="text-red-500 hover:text-red-700 text-sm font-semibold remove-row">Hapus</button></div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Kartu</h3>
                            <button type="button" id="tambah-kartu" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800">+ Tambah Baris Kartu</button>
                        </div>
                        <div id="daftar-kartu" class="space-y-3">
                            @foreach($pertandingan->kartus as $kartu)
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center kartu-row">
                                <div><select name="kartus[{{$loop->index}}][pemain_id]" class="block w-full border-gray-300 rounded-md shadow-sm"><option value="">Pilih Pemain</option>@foreach($pemains as $pemain)<option value="{{ $pemain->id }}" {{$kartu->pemain_id == $pemain->id ? 'selected' : ''}}>{{$pemain->nama_pemain}}</option>@endforeach</select></div>
                                <div><select name="kartus[{{$loop->index}}][jenis_kartu]" class="block w-full border-gray-300 rounded-md shadow-sm"><option value="kuning" {{$kartu->jenis_kartu == 'kuning' ? 'selected' : ''}}>Kuning</option><option value="merah" {{$kartu->jenis_kartu == 'merah' ? 'selected' : ''}}>Merah</option></select></div>
                                <div><x-text-input type="number" name="kartus[{{$loop->index}}][menit_kartu]" value="{{$kartu->menit_kartu}}" class="block w-full" placeholder="Menit ke-" /></div>
                                <div><button type="button" class="text-red-500 hover:text-red-700 text-sm font-semibold remove-row">Hapus</button></div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg flex justify-end items-center">
                         <a href="{{ route('pertandingan.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                        <x-primary-button>{{ __('Simpan Semua Perubahan') }}</x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="gol-template" style="display: none;">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center gol-row">
            <div><select name="gols[__INDEX__][pemain_id]" class="block w-full border-gray-300 rounded-md shadow-sm"><option value="">Pencetak Gol</option>@foreach($pemains as $pemain)<option value="{{ $pemain->id }}">{{$pemain->nama_pemain}}</option>@endforeach</select></div>
            <div><select name="gols[__INDEX__][assist_pemain_id]" class="block w-full border-gray-300 rounded-md shadow-sm"><option value="">Pemberi Assist</option>@foreach($pemains as $pemain)<option value="{{ $pemain->id }}">{{$pemain->nama_pemain}}</option>@endforeach</select></div>
            <div><x-text-input type="number" name="gols[__INDEX__][menit_gol]" class="block w-full" placeholder="Menit ke-" /></div>
            <div><button type="button" class="text-red-500 hover:text-red-700 text-sm font-semibold remove-row">Hapus</button></div>
        </div>
    </div>
    <div id="kartu-template" style="display: none;">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center kartu-row">
            <div><select name="kartus[__INDEX__][pemain_id]" class="block w-full border-gray-300 rounded-md shadow-sm"><option value="">Pilih Pemain</option>@foreach($pemains as $pemain)<option value="{{ $pemain->id }}">{{$pemain->nama_pemain}}</option>@endforeach</select></div>
            <div><select name="kartus[__INDEX__][jenis_kartu]" class="block w-full border-gray-300 rounded-md shadow-sm"><option value="kuning">Kuning</option><option value="merah">Merah</option></select></div>
            <div><x-text-input type="number" name="kartus[__INDEX__][menit_kartu]" class="block w-full" placeholder="Menit ke-" /></div>
            <div><button type="button" class="text-red-500 hover:text-red-700 text-sm font-semibold remove-row">Hapus</button></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Fungsi untuk menambah baris
            function addRow(containerId, templateId) {
                const container = document.getElementById(containerId);
                const template = document.getElementById(templateId).innerHTML;
                const newIndex = container.querySelectorAll('.gol-row, .kartu-row').length;
                const newRowHTML = template.replace(/__INDEX__/g, newIndex);
                container.insertAdjacentHTML('beforeend', newRowHTML);
            }

            // Fungsi untuk menghapus baris
            document.addEventListener('click', function (e) {
                if (e.target && e.target.classList.contains('remove-row')) {
                    e.target.closest('.gol-row, .kartu-row').remove();
                }
            });

            document.getElementById('tambah-gol').addEventListener('click', () => addRow('daftar-gol', 'gol-template'));
            document.getElementById('tambah-kartu').addEventListener('click', () => addRow('daftar-kartu', 'kartu-template'));
        });
    </script>
</x-app-layout>
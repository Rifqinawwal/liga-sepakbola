<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kelola Statistik Pertandingan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="text-center">
                    <h3 class="text-2xl font-bold">{{ $pertandingan->klubTuanRumah->nama }} vs {{ $pertandingan->klubTamu->nama }}</h3>
                    <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($pertandingan->tanggal_pertandingan)->format('l, d F Y') }}</p>
                    @if (session('success'))
                        <div class="mt-4 p-4 bg-green-100 text-green-700 border border-green-400 rounded max-w-xl mx-auto">
                            {{ session('success') }}
                        </div>
                    @endif
                     @if ($errors->any())
                        <div class="mt-4 p-4 bg-red-100 text-red-700 border border-red-400 rounded max-w-xl mx-auto text-left">
                            <p class="font-bold">Oops! Ada kesalahan:</p>
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Skor Akhir</h3>
                <form action="{{ route('pertandingan.statistik.updateSkor', $pertandingan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
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
                    <div class="flex items-center justify-end mt-6">
                        <x-primary-button>{{ __('Update Skor') }}</x-primary-button>
                    </div>
                </form>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Pencetak Gol</h3>
                <form action="{{ route('pertandingan.statistik.storeGol', $pertandingan->id) }}" method="POST" class="mb-6 border-b pb-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <x-input-label for="pemain_id" :value="__('Pencetak Gol')" />
                            <select name="pemain_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">Pilih Pemain</option>
                                @foreach($pemains as $pemain)
                                <option value="{{ $pemain->id }}">{{ $pemain->nama_pemain }} ({{$pemain->klub->nama}})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="assist_pemain_id" :value="__('Assist (Opsional)')" />
                            <select name="assist_pemain_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">Pilih Pemain</option>
                                @foreach($pemains as $pemain)
                                <option value="{{ $pemain->id }}">{{ $pemain->nama_pemain }} ({{$pemain->klub->nama}})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="menit_gol" :value="__('Menit ke-')" />
                            <x-text-input id="menit_gol" class="block mt-1 w-full" type="number" name="menit_gol" required />
                        </div>
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button>{{ __('+ Tambah Gol') }}</x-primary-button>
                    </div>
                </form>

                <ul class="space-y-2">
                    @forelse($gols as $gol)
                    <li class="flex justify-between items-center p-2 rounded hover:bg-gray-50">
                        <div>
                            <span class="font-semibold">{{ $gol->pemain->nama_pemain }}</span>
                            @if($gol->assistPemain)
                            <span class="text-sm text-gray-500">(Assist: {{ $gol->assistPemain->nama_pemain }})</span>
                            @endif
                        </div>
                        <div class="flex items-center">
                            <span class="text-sm text-gray-600 mr-4">Menit: {{ $gol->menit_gol }}'</span>
                            <form action="{{ route('pertandingan.statistik.destroyGol', $gol->id) }}" method="POST" onsubmit="return confirm('Hapus data gol ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-semibold">HAPUS</button>
                            </form>
                        </div>
                    </li>
                    @empty
                    <p class="text-sm text-gray-500">Belum ada data gol yang diinput.</p>
                    @endforelse
                </ul>
            </div>
            
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Kartu Kuning / Merah</h3>
                <form action="{{ route('pertandingan.statistik.storeKartu', $pertandingan->id) }}" method="POST" class="mb-6 border-b pb-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <x-input-label for="pemain_id_kartu" :value="__('Pemain')" />
                            <select name="pemain_id" id="pemain_id_kartu" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">Pilih Pemain</option>
                                @foreach($pemains as $pemain)
                                <option value="{{ $pemain->id }}">{{ $pemain->nama_pemain }} ({{$pemain->klub->nama}})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="jenis_kartu" :value="__('Jenis Kartu')" />
                            <select name="jenis_kartu" id="jenis_kartu" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="kuning">Kuning</option>
                                <option value="merah">Merah</option>
                            </select>
                        </div>
                        <div>
                            <x-input-label for="menit_kartu" :value="__('Menit ke-')" />
                            <x-text-input id="menit_kartu" class="block mt-1 w-full" type="number" name="menit_kartu" required />
                        </div>
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button>{{ __('+ Tambah Kartu') }}</x-primary-button>
                    </div>
                </form>

                <ul class="space-y-2">
                    @forelse($kartus as $kartu)
                    <li class="flex justify-between items-center p-2 rounded hover:bg-gray-50">
                        <div class="flex items-center">
                            @if($kartu->jenis_kartu == 'kuning')
                                <div class="w-4 h-5 bg-yellow-400 mr-3 rounded-sm"></div>
                            @else
                                <div class="w-4 h-5 bg-red-600 mr-3 rounded-sm"></div>
                            @endif
                            <span class="font-semibold">{{ $kartu->pemain->nama_pemain }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-sm text-gray-600 mr-4">Menit: {{ $kartu->menit_kartu }}'</span>
                            <form action="{{ route('pertandingan.statistik.destroyKartu', $kartu->id) }}" method="POST" onsubmit="return confirm('Hapus data kartu ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-semibold">HAPUS</button>
                            </form>
                        </div>
                    </li>
                    @empty
                    <p class="text-sm text-gray-500">Belum ada data kartu yang diinput.</p>
                    @endforelse
                </ul>
            </div>

            </div>
    </div>
</x-app-layout>
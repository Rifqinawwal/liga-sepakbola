<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Pertandingan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="mb-4">
                    <a href="{{ route('pertandingan.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        Tambah Jadwal Baru
                    </a>
                </div>
                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 border border-green-400 rounded">
                        {{ session('success') }}
                    </div>
                @endif
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    Pertandingan Akan Datang
                </h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Pertandingan</th>
                                <th class="relative px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($pertandinganAkanDatang as $match)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($match->tanggal_pertandingan)->format('d M Y') }}
                                    </td>
                                    {{-- Kolom Pertandingan dengan Logo --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center justify-center space-x-4">
                                            <span class="font-medium text-gray-900 text-right">{{ $match->klubTuanRumah->nama }}</span>
                                            @if($match->klubTuanRumah->logo)
                                                <img src="{{ asset($match->klubTuanRumah->logo) }}" alt="{{ $match->klubTuanRumah->nama }}" class="h-8 w-8 object-contain">
                                            @else
                                                <div class="h-8 w-8 bg-gray-200 rounded-full"></div>
                                            @endif
                                    
                                            <span class="text-gray-500">vs</span>
                                    
                                            @if($match->klubTamu->logo)
                                                <img src="{{ asset($match->klubTamu->logo) }}" alt="{{ $match->klubTamu->nama }}" class="h-8 w-8 object-contain">
                                            @else
                                                <div class="h-8 w-8 bg-gray-200 rounded-full"></div>
                                            @endif
                                            <span class="font-medium text-gray-900 text-left">{{ $match->klubTamu->nama }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm font-medium">
                                        <a href="{{ route('pertandingan.statistik.edit', $match->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                            Kelola Pertandingan
                                        </a>
                                        <form action="{{ route('pertandingan.destroy', $match->id) }}" method="POST" class="inline-block ml-4" onsubmit="return confirm('Yakin hapus jadwal ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">
                                        Tidak ada jadwal pertandingan yang akan datang.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $pertandinganAkanDatang->withQueryString()->links() }}
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    Pertandingan Selesai
                </h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Pertandingan</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Skor</th>
                                <th class="relative px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($pertandinganSelesai as $match)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($match->tanggal_pertandingan)->format('d M Y') }}
                                    </td>
                                    {{-- Kolom Pertandingan dengan Logo --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center justify-center space-x-4">
                                            <span class="font-medium text-gray-900 text-right">{{ $match->klubTuanRumah->nama }}</span>
                                            @if($match->klubTuanRumah->logo)
                                                <img src="{{ asset($match->klubTuanRumah->logo) }}" alt="{{ $match->klubTuanRumah->nama }}" class="h-8 w-8 object-contain">
                                            @else
                                                <div class="h-8 w-8 bg-gray-200 rounded-full"></div>
                                            @endif
                                    
                                            <span class="text-gray-500">vs</span>
                                    
                                            @if($match->klubTamu->logo)
                                                <img src="{{ asset($match->klubTamu->logo) }}" alt="{{ $match->klubTamu->nama }}" class="h-8 w-8 object-contain">
                                            @else
                                                <div class="h-8 w-8 bg-gray-200 rounded-full"></div>
                                            @endif
                                            <span class="font-medium text-gray-900 text-left">{{ $match->klubTamu->nama }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center font-bold text-lg">
                                        {{ $match->skor_tuan_rumah }} - {{ $match->skor_tamu }}
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm font-medium">
                                        <a href="{{ route('pertandingan.statistik.edit', $match->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                            Lihat/Edit Statistik
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                        Tidak ada data pertandingan yang sudah selesai.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $pertandinganSelesai->withQueryString()->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
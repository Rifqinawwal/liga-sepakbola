@extends('layouts.public')

@section('content')
    <div class="py-12 pt-28">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- ===== PERBAIKAN: class "overflow-hidden" dihapus dari div di bawah ini ===== --}}
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                        Klasemen Liga
                    </h2>

                    <div x-data="{ open: false }" class="relative mb-4">
                        <button @click="open = ! open" class="w-full sm:w-64 flex items-center justify-between text-left bg-white border border-gray-300 rounded-md shadow-sm px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <span>
                                @if($selectedLigaId && $ligas->firstWhere('id', $selectedLigaId))
                                    <div class="flex items-center">
                                        <img src="{{ $ligas->firstWhere('id', $selectedLigaId)->logo_url }}" class="h-5 w-5 object-contain mr-2">
                                        {{ $ligas->firstWhere('id', $selectedLigaId)->nama }}
                                    </div>
                                @else
                                    Semua Liga
                                @endif
                            </span>
                            <svg class="ml-2 -mr-1 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false" class="absolute z-10 mt-2 w-full sm:w-64 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5" style="display: none;">
                            <div class="py-1">
                                <a href="{{ route('klasemen.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Semua Liga</a>
                                @foreach ($ligas as $liga)
                                    <a href="{{ route('klasemen.index', ['liga_id' => $liga->id]) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        @if($liga->logo_url)
                                            <img src="{{ $liga->logo_url }}" alt="{{ $liga->nama }}" class="h-5 w-5 object-contain mr-2">
                                        @endif
                                        <span>{{ $liga->nama }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-2 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pos</th>
                                    <th colspan="2" class="px-2 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Klub</th>
                                    <th class="px-2 md:px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">P</th>
                                    <th class="px-2 md:px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">W</th>
                                    <th class="px-2 md:px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">D</th>
                                    <th class="px-2 md:px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">L</th>
                                    <th class="px-2 md:px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">GF</th>
                                    <th class="px-2 md:px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">GA</th>
                                    <th class="px-2 md:px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">GD</th>
                                    <th class="px-2 md:px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Pts</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($klasemen as $index => $data)
                                    <tr>
                                        <td class="px-2 md:px-6 py-4 text-center">{{ $index + 1 }}</td>
                                        <td class="px-2 py-4">
                                            @if($data['logo_klub'])
                                                @php
                                                    $logoKlubUrl = \Illuminate\Support\Str::startsWith($data['logo_klub'], 'logo_klub/')
                                                                    ? asset('storage/' . $data['logo_klub'])
                                                                    : asset($data['logo_klub']);
                                                @endphp
                                                <img src="{{ $logoKlubUrl }}" alt="{{ $data['nama_klub'] }}" class="h-8 w-8 object-contain">
                                            @endif
                                        </td>
                                        <td class="px-2 md:px-6 py-4 font-medium text-gray-900">{{ $data['nama_klub'] }}</td>
                                        <td class="px-2 md:px-6 py-4 text-center">{{ $data['main'] }}</td>
                                        <td class="px-2 md:px-6 py-4 text-center">{{ $data['menang'] }}</td>
                                        <td class="px-2 md:px-6 py-4 text-center">{{ $data['seri'] }}</td>
                                        <td class="px-2 md:px-6 py-4 text-center">{{ $data['kalah'] }}</td>
                                        <td class="px-2 md:px-6 py-4 text-center">{{ $data['gol_masuk'] }}</td>
                                        <td class="px-2 md:px-6 py-4 text-center">{{ $data['gol_kalah'] }}</td>
                                        <td class="px-2 md:px-6 py-4 text-center">{{ $data['selisih_gol'] }}</td>
                                        <td class="px-2 md:px-6 py-4 text-center font-bold">{{ $data['poin'] }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="px-6 py-4 text-center text-sm text-gray-500">
                                            Belum ada pertandingan yang selesai untuk menghitung klasemen.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

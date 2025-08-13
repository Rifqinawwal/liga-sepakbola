<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Klasemen Liga') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        Klasemen Sementara
                    </h3>
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
                                                <img src="{{ asset($data['logo_klub']) }}" alt="{{ $data['nama_klub'] }}" class="h-8 w-8 object-contain">
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
</x-app-layout>
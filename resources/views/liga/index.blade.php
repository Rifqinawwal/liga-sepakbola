<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Liga') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <a href="{{ route('liga.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">Tambah Liga</a>
                    </div>

                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
                    @endif

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Logo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Liga</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Negara</th>
                                <th class="relative px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($ligas as $liga)
                                <tr>
                                    <td class="px-6 py-4">
                                        @if($liga->logo)
                                            {{-- ===== PERBAIKAN FINAL DENGAN LOGIKA YANG BENAR ===== --}}
                                            @php
                                                // Cek apakah path dimulai dengan folder 'logo_liga/'. Jika ya, itu file baru.
                                                // Jika tidak, itu file lama.
                                                $logoUrl = \Illuminate\Support\Str::startsWith($liga->logo, 'logo_liga/')
                                                            ? asset('storage/' . $liga->logo)
                                                            : asset($liga->logo);
                                            @endphp
                                            <img src="{{ $logoUrl }}" alt="{{ $liga->nama }} Logo" class="h-8 object-contain">
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-medium">{{ $liga->nama }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            @if($liga->bendera)
                                                {{-- Logika yang sama diterapkan untuk bendera --}}
                                                @php
                                                    $benderaUrl = \Illuminate\Support\Str::startsWith($liga->bendera, 'bendera_liga/')
                                                                ? asset('storage/' . $liga->bendera)
                                                                : asset($liga->bendera);
                                                @endphp
                                                <img src="{{ $benderaUrl }}" alt="Bendera {{ $liga->negara }}" class="h-5 w-8 object-cover mr-3">
                                            @endif
                                            <span>{{ $liga->negara }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm font-medium">
                                        <a href="{{ route('liga.edit', $liga->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        <form action="{{ route('liga.destroy', $liga->id) }}" method="POST" class="inline-block ml-4" onsubmit="return confirm('Yakin hapus liga ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="px-6 py-4 text-center">Belum ada data liga.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $ligas->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

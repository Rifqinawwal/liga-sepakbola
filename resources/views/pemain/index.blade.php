@extends('layouts.public')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                        Daftar Pemain
                    </h2>

                    @auth
                    <div class="mb-4">
                        <a href="{{ route('pemain.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            Tambah Pemain Baru
                        </a>
                    </div>
                    @endauth

                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 border border-green-400 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Foto</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Pemain</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Klub</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Posisi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Punggung</th>
                                    @auth
                                    <th class="relative px-6 py-3"></th>
                                    @endauth
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($pemains as $pemain)
                                    <tr>
                                        <td class="px-6 py-4">
                                            @if($pemain->foto)
                                                <img src="{{ asset($pemain->foto) }}" alt="{{ $pemain->nama_pemain }}" class="h-10 w-10 rounded-full object-cover">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-gray-200"></div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 font-medium text-gray-900">{{ $pemain->nama_pemain }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $pemain->klub->nama ?? 'Tanpa Klub' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $pemain->posisi }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $pemain->nomor_punggung }}</td>
                                        @auth
                                        <td class="px-6 py-4 text-right text-sm font-medium">
                                            <a href="{{ route('pemain.edit', $pemain->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            <form action="{{ route('pemain.destroy', $pemain->id) }}" method="POST" class="inline-block ml-4" onsubmit="return confirm('Yakin hapus pemain ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                            </form>
                                        </td>
                                        @endauth
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ auth()->check() ? 6 : 5 }}" class="px-6 py-4 text-center text-sm text-gray-500">
                                            Belum ada data pemain.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                     <div class="mt-4">
                        {{ $pemains->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
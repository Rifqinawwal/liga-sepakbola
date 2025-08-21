@extends('layouts.public')

@section('content')
    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 text-gray-900">
                    <h2 class="font-semibold text-xl sm:text-2xl text-gray-800 leading-tight mb-4 sm:mb-6">
                        Daftar Pemain
                    </h2>

                    @auth
                    <div class="mb-4 sm:mb-6">
                        <a href="{{ route('pemain.create') }}" class="inline-flex items-center px-3 sm:px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span class="hidden sm:inline">Tambah Pemain Baru</span>
                            <span class="sm:hidden">Tambah</span>
                        </a>
                    </div>
                    @endauth

                    @if (session('success'))
                        <div class="mb-4 sm:mb-6 p-3 sm:p-4 bg-green-100 text-green-700 border border-green-400 rounded-lg text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Mobile Card Layout (hidden on md and up) -->
                    <div class="md:hidden space-y-3">
                        @forelse ($pemains as $pemain)
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <div class="flex items-start space-x-3">
                                    <!-- Foto -->
                                    <div class="flex-shrink-0">
                                        @if($pemain->foto)
                                            <img src="{{ asset($pemain->foto) }}" alt="{{ $pemain->nama_pemain }}" class="h-12 w-12 rounded-full object-cover">
                                        @else
                                            <div class="h-12 w-12 rounded-full bg-gray-300 flex items-center justify-center">
                                                <svg class="h-6 w-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Info Pemain -->
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-semibold text-gray-900 text-base leading-tight">{{ $pemain->nama_pemain }}</h3>
                                        <div class="mt-1 space-y-1">
                                            <div class="flex items-center text-sm text-gray-600">
                                                <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                </svg>
                                                <span>{{ $pemain->klub->nama ?? 'Tanpa Klub' }}</span>
                                            </div>
                                            <div class="flex items-center justify-between text-sm">
                                                <div class="flex items-center text-gray-600">
                                                    <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    </svg>
                                                    <span>{{ $pemain->posisi }}</span>
                                                </div>
                                                <div class="flex items-center text-gray-600">
                                                    <span class="text-xs font-medium bg-gray-200 px-2 py-1 rounded-full">
                                                        #{{ $pemain->nomor_punggung }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        @auth
                                        <!-- Action Buttons -->
                                        <div class="mt-3 flex items-center space-x-3">
                                            <a href="{{ route('pemain.edit', $pemain->id) }}" class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium text-indigo-600 bg-indigo-100 rounded-md hover:bg-indigo-200 transition duration-150">
                                                <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                Edit
                                            </a>
                                            <form action="{{ route('pemain.destroy', $pemain->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus pemain ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium text-red-600 bg-red-100 rounded-md hover:bg-red-200 transition duration-150">
                                                    <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">Belum ada data pemain.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Desktop Table Layout (hidden on mobile, shown on md and up) -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
                                    <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pemain</th>
                                    <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Klub</th>
                                    <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Posisi</th>
                                    <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Punggung</th>
                                    @auth
                                    <th class="relative px-3 lg:px-6 py-3">
                                        <span class="sr-only">Aksi</span>
                                    </th>
                                    @endauth
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($pemains as $pemain)
                                    <tr class="hover:bg-gray-50 transition duration-150">
                                        <td class="px-3 lg:px-6 py-4 whitespace-nowrap">
                                            @if($pemain->foto)
                                                <img src="{{ asset($pemain->foto) }}" alt="{{ $pemain->nama_pemain }}" class="h-10 w-10 rounded-full object-cover">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                    <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-3 lg:px-6 py-4 whitespace-nowrap">
                                            <div class="font-medium text-gray-900 text-sm lg:text-base">{{ $pemain->nama_pemain }}</div>
                                        </td>
                                        <td class="px-3 lg:px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">{{ $pemain->klub->nama ?? 'Tanpa Klub' }}</div>
                                        </td>
                                        <td class="px-3 lg:px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $pemain->posisi }}
                                            </span>
                                        </td>
                                        <td class="px-3 lg:px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-gray-100 text-xs font-semibold text-gray-700">
                                                {{ $pemain->nomor_punggung }}
                                            </span>
                                        </td>
                                        @auth
                                        <td class="px-3 lg:px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                            <a href="{{ route('pemain.edit', $pemain->id) }}" class="text-indigo-600 hover:text-indigo-900 transition duration-150">Edit</a>
                                            <form action="{{ route('pemain.destroy', $pemain->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus pemain ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 transition duration-150">Hapus</button>
                                            </form>
                                        </td>
                                        @endauth
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ auth()->check() ? 6 : 5 }}" class="px-6 py-8 text-center">
                                            <div class="flex flex-col items-center">
                                                <svg class="h-12 w-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                                <p class="text-sm text-gray-500">Belum ada data pemain.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($pemains->hasPages())
                    <div class="mt-4 sm:mt-6">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <div class="text-sm text-gray-700 mb-3 sm:mb-0">
                                Menampilkan {{ $pemains->firstItem() ?? 0 }} sampai {{ $pemains->lastItem() ?? 0 }} dari {{ $pemains->total() }} pemain
                            </div>
                            <div class="flex justify-center sm:justify-end">
                                {{ $pemains->links() }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
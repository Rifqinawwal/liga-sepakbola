@extends('layouts.public')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight mb-4">
                    Hasil Pencarian untuk: <span class="italic">"{{ $query }}"</span>
                </h2>

                <div class="mb-8">
                    <h3 class="text-xl font-bold text-gray-800 border-b pb-2 mb-4">Klub Ditemukan ({{ $klubs->count() }})</h3>
                    @forelse($klubs as $klub)
                        <div class="flex items-center p-3 hover:bg-gray-50 rounded-lg">
                            <img src="{{ asset($klub->logo) }}" class="h-10 w-10 object-contain mr-4 rounded-full">
                            <div>
                                <p class="font-semibold">{{ $klub->nama }}</p>
                                <p class="text-sm text-gray-500">{{ $klub->kota }} - {{ $klub->liga->nama ?? '' }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">Tidak ada klub yang ditemukan.</p>
                    @endforelse
                </div>

                <div>
                    <h3 class="text-xl font-bold text-gray-800 border-b pb-2 mb-4">Pemain Ditemukan ({{ $pemains->count() }})</h3>
                    @forelse($pemains as $pemain)
                        <div class="flex items-center p-3 hover:bg-gray-50 rounded-lg">
                            <img src="{{ asset($pemain->foto) }}" class="h-10 w-10 object-contain mr-4 rounded-full">
                            <div>
                                <p class="font-semibold">{{ $pemain->nama_pemain }}</p>
                                <p class="text-sm text-gray-500">{{ $pemain->posisi }} - {{ $pemain->klub->nama ?? 'Tanpa Klub' }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">Tidak ada pemain yang ditemukan.</p>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
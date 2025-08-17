@extends('layouts.public')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 space-y-8">
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    Hasil Pencarian untuk: <span class="italic">"{{ $query }}"</span>
                </h2>

                {{-- Cek apakah ada hasil klub --}}
                @if($klubs->isNotEmpty())
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 border-b pb-2 mb-4">Klub Ditemukan ({{ $klubs->count() }})</h3>
                        @foreach($klubs as $klub)
                            <div class="flex items-center p-3 hover:bg-gray-50 rounded-lg">
                                <img src="{{ asset($klub->logo) }}" class="h-10 w-10 object-contain mr-4 rounded-full">
                                <div>
                                    <p class="font-semibold">{{ $klub->nama }}</p>
                                    <p class="text-sm text-gray-500">{{ $klub->kota }} - {{ $klub->liga->nama ?? '' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                
                {{-- Cek apakah ada hasil pemain --}}
                @if($pemains->isNotEmpty())
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 border-b pb-2 mb-4">Pemain Ditemukan ({{ $pemains->count() }})</h3>
                        @foreach($pemains as $pemain)
                            <div class="flex items-center p-3 hover:bg-gray-50 rounded-lg">
                                <img src="{{ asset($pemain->foto) }}" class="h-10 w-10 object-contain mr-4 rounded-full">
                                <div>
                                    <p class="font-semibold">{{ $pemain->nama_pemain }}</p>
                                    <p class="text-sm text-gray-500">{{ $pemain->posisi }} - {{ $pemain->klub->nama ?? 'Tanpa Klub' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Cek apakah ada hasil berita --}}
                @if(!empty($articles))
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 border-b pb-2 mb-4">Berita Ditemukan ({{ count($articles) }})</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            @foreach($articles as $article)
                                <article class="flex flex-col items-start justify-between">
                                    <div class="relative w-full">
                                        <img src="{{ $article['urlToImage'] ?? 'https://via.placeholder.com/400x250?text=No+Image' }}" alt="" class="aspect-[16/9] w-full rounded-2xl bg-gray-100 object-cover">
                                    </div>
                                    <div class="max-w-xl">
                                        <div class="mt-4 flex items-center gap-x-4 text-xs">
                                            <time datetime="{{ \Carbon\Carbon::parse($article['publishedAt'])->toIso8601String() }}" class="text-gray-500">
                                                {{ \Carbon\Carbon::parse($article['publishedAt'])->isoFormat('D MMMM YYYY') }}
                                            </time>
                                            <span class="relative z-10 rounded-full bg-gray-50 px-3 py-1.5 font-medium text-gray-600">{{ $article['source']['name'] }}</span>
                                        </div>
                                        <div class="group relative">
                                            <h3 class="mt-2 text-base font-semibold leading-6 text-gray-900 group-hover:text-gray-600">
                                                <a href="{{ $article['url'] }}" target="_blank">
                                                    <span class="absolute inset-0"></span>
                                                    {{ $article['title'] }}
                                                </a>
                                            </h3>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                {{-- Pesan jika tidak ada hasil sama sekali --}}
                @if($klubs->isEmpty() && $pemains->isEmpty() && empty($articles))
                    <p class="text-center text-gray-500">Tidak ada hasil yang ditemukan untuk pencarian Anda.</p>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
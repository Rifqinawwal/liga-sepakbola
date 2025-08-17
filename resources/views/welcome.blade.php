@extends('layouts.public')

@section('content')
   <div class="bg-white py-12">
                <div class="max-w-7xl mx-auto px-6 lg:px-8">
                    <div class="max-w-2xl mx-auto text-center">
                        <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Berita Sepak Bola Terbaru</h2>
                        <p class="mt-2 text-lg leading-8 text-gray-600">
                            Ikuti perkembangan terbaru dari dunia olahraga.
                        </p>
                    </div>
                    <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                        @forelse ($articles as $article)
                            <article class="flex flex-col items-start justify-between">
                                <div class="relative w-full">
                                    <img src="{{ $article['urlToImage'] ?? 'https://via.placeholder.com/400x250?text=No+Image' }}" alt="" class="aspect-[16/9] w-full rounded-2xl bg-gray-100 object-cover sm:aspect-[2/1] lg:aspect-[3/2]">
                                    <div class="absolute inset-0 rounded-2xl ring-1 ring-inset ring-gray-900/10"></div>
                                </div>
                                <div class="max-w-xl">
                                    <div class="mt-8 flex items-center gap-x-4 text-xs">
                                        <time datetime="{{ \Carbon\Carbon::parse($article['publishedAt'])->toIso8601String() }}" class="text-gray-500">
                                            {{ \Carbon\Carbon::parse($article['publishedAt'])->isoFormat('D MMMM YYYY') }}
                                        </time>
                                        <span class="relative z-10 rounded-full bg-gray-50 px-3 py-1.5 font-medium text-gray-600">{{ $article['source']['name'] }}</span>
                                    </div>
                                    <div class="group relative">
                                        <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600">
                                            <a href="{{ $article['url'] }}" target="_blank">
                                                <span class="absolute inset-0"></span>
                                                {{ $article['title'] }}
                                            </a>
                                        </h3>
                                    </div>
                                </div>
                            </article>
                        @empty
                            <p class="col-span-3 text-center text-gray-500">Gagal memuat berita atau tidak ada berita tersedia.</p>
                        @endforelse
                    </div>
                </div>
            </div>
            </div>
    </body>
</html>
    
@endsection
@extends('layouts.public')

@section('content')
    <main>
        <div class="relative flex flex-col items-center justify-center pt-24 pb-32">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">Sistem Informasi Liga Sepak Bola</h1>
                    <p class="mt-6 text-lg leading-8 text-gray-600">
                        Lihat klasemen terbaru, jadwal pertandingan, dan statistik lengkap dari liga favoritmu.
                    </p>
                </div>

                {{-- Form Pencarian dipindahkan ke layout --}}
                
                <div class="mt-10 flex items-center justify-center gap-x-6">
                    <a href="{{ route('klasemen.index') }}" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Lihat Klasemen
                    </a>
                    <a href="{{ route('login') }}" class="text-sm font-semibold leading-6 text-gray-900">
                        Login Admin <span aria-hidden="true">→</span>
                    </a>
                </div>
            </div>
        </div>
    </main>
@endsection
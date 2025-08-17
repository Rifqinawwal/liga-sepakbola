<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Balbalan</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('icon/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('icon/favicon-16x16.png') }}">
        <link rel="manifest" href="/site.webmanifest">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">


        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <!-- Navigation Menu Publik -->
            <nav class="fixed top-0 w-full z-50 bg-white shadow-sm border-b border-gray-100">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <!-- Logo dan Menu Utama -->
                        <div class="flex">
                            <div class="shrink-0 flex items-center">
                                <a href="{{ url('/') }}" class="flex items-center">
                                    {{-- Tampilkan gambar favicon menggunakan tag <img> --}}
                                    <img src="{{ asset('icon/favicon-32x32.png') }}" alt="Logo Balbalan" class="block h-9 w-auto">
                                    <span class="ml-3 font-semibold text-xl text-green-900 font-poppins">
                                        Balbalan
                                    </span>
                                </a>
                            </div>
                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <x-nav-link :href="url('/')" :active="request()->is('/')"
                                    class="{{ request()->routeIs('home.*') ? 'border-green-900' : 'border-transparent' }}">
                                    {{ __('Home') }}
                                </x-nav-link>
                                <x-nav-link :href="route('klub.index')" :active="request()->routeIs('klub.index')"
                                    class="{{ request()->routeIs('klub.*') ? 'border-green-900' : 'border-transparent' }}">
                                    {{ __('Klub') }}
                                </x-nav-link>
                                <x-nav-link :href="route('pemain.index')" :active="request()->routeIs('pemain.index')"
                                   class="{{ request()->routeIs('pemain.*') ? 'border-green-900' : 'border-transparent' }}">
                                    {{ __('Pemain') }}
                                </x-nav-link>
                                <x-nav-link :href="route('pertandingan.index')" :active="request()->routeIs('pertandingan.index')"
                                    class="{{ request()->routeIs('pertandingan.*') ? 'border-green-900' : 'border-transparent' }}">
                                    {{ __('Pertandingan') }}
                                </x-nav-link>
                                <x-nav-link :href="route('klasemen.index')" :active="request()->routeIs('klasemen.index')"
                                    class="{{ request()->routeIs('klasemen.*') ? 'border-green-900' : 'border-transparent' }}">
                                    {{ __('Klasemen') }}
                                </x-nav-link>
                            </div>
                        </div>

                        <!-- Search Bar (Pusat) -->
                        <div class="flex flex-1 items-center justify-center px-2 lg:ml-6 lg:justify-end">
                             <div class="w-full max-w-lg lg:max-w-xs">
                                <form action="{{ route('search.index') }}" method="GET">
                                    <div class="relative">
                                        <input 
                                            type="text" 
                                            name="query"
                                            value="{{ request('query') }}" 
                                            class="block w-full pl-4 pr-10 py-2 text-sm text-white bg-green-900 border placeholder-white border-transparent rounded-full focus:ring-white focus:border-white" 
                                            placeholder="Cari...">
                                        <button type="submit" class="absolute inset-y-0 right-0 flex items-center pr-3">
                                            <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                            </svg>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Tombol Login/Register di Kanan -->
                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900">Register</a>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="pt-16">
                @yield('content')
            </main>
        </div>
    </body>
</html>
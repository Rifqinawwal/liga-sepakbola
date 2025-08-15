<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Liga Sepak Bola</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-gray-100">
        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white shadow-sm">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <div class="shrink-0 flex items-center">
                                <a href="{{ url('/') }}">
                                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                                </a>
                            </div>
                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <x-nav-link :href="route('klub.index')" :active="request()->routeIs('klub.index')">
                                    {{ __('Klub') }}
                                </x-nav-link>
                                <x-nav-link :href="route('pemain.index')" :active="request()->routeIs('pemain.index')">
                                    {{ __('Pemain') }}
                                </x-nav-link>
                                <x-nav-link :href="route('pertandingan.index')" :active="request()->routeIs('pertandingan.index')">
                                    {{ __('Pertandingan') }}
                                </x-nav-link>
                                <x-nav-link :href="route('klasemen.index')" :active="request()->routeIs('klasemen.index')">
                                    {{ __('Klasemen') }}
                                </x-nav-link>
                            </div>
                        </div>

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

            <main>
                <div class="relative flex flex-col items-center justify-center" style="height: 80vh;">
                    <div class="max-w-7xl mx-auto p-6 lg:p-8">
                        <div class="mt-8 text-center">
                            <h1 class="text-4xl font-bold text-gray-900">Selamat Datang di Liga Sepak Bola</h1>
                            <p class="mt-4 text-gray-600">
                                Lihat klasemen terbaru, jadwal pertandingan, dan statistik lengkap dari liga favoritmu.
                            </p>
                        </div>

                        <div class="mt-10 flex justify-center items-center gap-x-6">
                            <a href="{{ route('klasemen.index') }}" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                                Lihat Klasemen
                            </a>
                            <a href="{{ route('login') }}" class="text-sm font-semibold leading-6 text-gray-900">
                                Login Admin <span aria-hidden="true">→</span>
                            </a>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>
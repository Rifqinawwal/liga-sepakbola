<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Balbalans</title>

        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('icon/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('icon/favicon-16x16.png') }}">
        
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- TAMBAHAN UNTUK SELECT2 (CSS) --}}
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <style>
            .select2-container .select2-selection--single { height: 38px; }
            .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 36px; }
            .select2-results__option .select2-image { width: 25px; height: 25px; margin-right: 10px; border-radius: 50%; object-fit: cover; }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <nav x-data="{ 
                open: false,
                klubOpen: false,
                pemainOpen: false,
                pertandinganOpen: false,
                mobileKlubOpen: false,
                mobilePemainOpen: false,
                mobilePertandinganOpen: false
            }" class="fixed top-0 w-full z-50 bg-white shadow-sm border-b border-gray-100">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <a href="{{ url('/') }}" class="flex items-center">
                                    <img src="{{ asset('icon/favicon-32x32.png') }}" alt="Logo Balbalan" class="block h-9 w-auto">
                                    <span class="ml-2 sm:ml-3 font-semibold text-lg sm:text-xl text-green-900 font-poppins">Balbalans</span>
                                </a>
                            </div>

                            <!-- Desktop Navigation -->
                            <div class="hidden md:flex md:space-x-1 lg:space-x-4 md:ml-6 lg:ml-10 md:items-center">
                                <x-nav-link :href="url('/')" :active="request()->is('/')" class="px-2 lg:px-3 {{ request()->is('/') ? 'border-green-900' : 'border-transparent' }}">{{ __('Home') }}</x-nav-link>

                                {{-- Dropdown Klub --}}
                                <div class="relative">
                                     <button @click="klubOpen = !klubOpen; pemainOpen = false; pertandinganOpen = false" 
                                             class="inline-flex items-center px-2 lg:px-3 pt-1 border-b-2 {{ request()->routeIs('klub.*') ? 'border-green-900' : 'border-transparent' }} text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 focus:outline-none transition duration-150 ease-in-out">
                                         <div>Klub</div>
                                         <div class="ml-1">
                                             <svg class="fill-current h-4 w-4 transition-transform duration-200" 
                                                  :class="{'rotate-180': klubOpen}" viewBox="0 0 20 20">
                                                 <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                             </svg>
                                         </div>
                                     </button>
                                     <div x-show="klubOpen" 
                                          @click.away="klubOpen = false"
                                          x-transition:enter="transition ease-out duration-200"
                                          x-transition:enter-start="opacity-0 scale-95"
                                          x-transition:enter-end="opacity-100 scale-100"
                                          x-transition:leave="transition ease-in duration-150"
                                          x-transition:leave-start="opacity-100 scale-100"
                                          x-transition:leave-end="opacity-0 scale-95" 
                                          class="absolute z-50 mt-2 w-48 rounded-md shadow-lg origin-top-left left-0 top-full">
                                         <div class="rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-white">
                                             <a href="{{ route('klub.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-900 hover:text-white transition duration-150">Semua Klub</a>
                                             @foreach($ligasForMenu as $liga)
                                                 <a href="{{ route('klub.liga', $liga->id) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-green-900 hover:text-white transition duration-150">
                                                     @if($liga->logo_url)<img src="{{ $liga->logo_url }}" class="h-5 w-5 object-contain mr-2">@endif
                                                     <span>{{ $liga->nama }}</span>
                                                 </a>
                                             @endforeach
                                         </div>
                                     </div>
                                </div>
                                
                                {{-- Dropdown Pemain --}}
                                <div class="relative">
                                     <button @click="pemainOpen = !pemainOpen; klubOpen = false; pertandinganOpen = false" 
                                             class="inline-flex items-center px-2 lg:px-3 pt-1 border-b-2 {{ request()->routeIs('pemain.*') ? 'border-green-900' : 'border-transparent' }} text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 focus:outline-none transition duration-150 ease-in-out">
                                         <div>Pemain</div>
                                         <div class="ml-1">
                                             <svg class="fill-current h-4 w-4 transition-transform duration-200" 
                                                  :class="{'rotate-180': pemainOpen}" viewBox="0 0 20 20">
                                                 <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                             </svg>
                                         </div>
                                     </button>
                                     <div x-show="pemainOpen" 
                                          @click.away="pemainOpen = false"
                                          x-transition:enter="transition ease-out duration-200"
                                          x-transition:enter-start="opacity-0 scale-95"
                                          x-transition:enter-end="opacity-100 scale-100"
                                          x-transition:leave="transition ease-in duration-150"
                                          x-transition:leave-start="opacity-100 scale-100"
                                          x-transition:leave-end="opacity-0 scale-95" 
                                          class="absolute z-50 mt-2 w-56 rounded-md shadow-lg origin-top-left left-0 top-full">
                                         <div class="rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-white max-h-80 overflow-y-auto">
                                             <a href="{{ route('pemain.index') }}" class="block px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-green-900 hover:text-white transition duration-150">Semua Pemain</a>
                                             @foreach($ligasForMenu as $liga)
                                                 <div x-data="{ openLiga: false }">
                                                     <button @click="openLiga = !openLiga" class="w-full text-left flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-green-900 hover:text-white transition duration-150">
                                                         <span class="flex items-center">
                                                             @if($liga->logo_url)<img src="{{ $liga->logo_url }}" class="h-5 w-5 object-contain mr-2">@endif
                                                             <span>{{ $liga->nama }}</span>
                                                         </span>
                                                         <svg class="h-4 w-4 transition-transform duration-200" 
                                                              :class="{'rotate-90': openLiga}" 
                                                              viewBox="0 0 20 20" fill="currentColor">
                                                             <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                                         </svg>
                                                     </button>
                                                     <div x-show="openLiga" 
                                                          x-collapse
                                                          class="pl-4">
                                                         @foreach($liga->klubs as $klub)
                                                         <a href="{{ route('pemain.klub', $klub->id) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-green-900 hover:text-white transition duration-150">
                                                             @if($klub->logo_url)<img src="{{ $klub->logo_url }}" class="h-5 w-5 object-contain mr-2 rounded-full">@endif
                                                             <span>{{ $klub->nama }}</span>
                                                         </a>
                                                         @endforeach
                                                     </div>
                                                 </div>
                                             @endforeach
                                         </div>
                                     </div>
                                </div>

                                {{-- Dropdown Pertandingan --}}
                                <div class="relative">
                                     <button @click="pertandinganOpen = !pertandinganOpen; klubOpen = false; pemainOpen = false" 
                                             class="inline-flex items-center px-2 lg:px-3 pt-1 border-b-2 {{ request()->routeIs('pertandingan.*') ? 'border-green-900' : 'border-transparent' }} text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 focus:outline-none transition duration-150 ease-in-out">
                                         <div>Pertandingan</div>
                                         <div class="ml-1">
                                             <svg class="fill-current h-4 w-4 transition-transform duration-200" 
                                                  :class="{'rotate-180': pertandinganOpen}" viewBox="0 0 20 20">
                                                 <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                             </svg>
                                         </div>
                                     </button>
                                     <div x-show="pertandinganOpen" 
                                          @click.away="pertandinganOpen = false"
                                          x-transition:enter="transition ease-out duration-200"
                                          x-transition:enter-start="opacity-0 scale-95"
                                          x-transition:enter-end="opacity-100 scale-100"
                                          x-transition:leave="transition ease-in duration-150"
                                          x-transition:leave-start="opacity-100 scale-100"
                                          x-transition:leave-end="opacity-0 scale-95" 
                                          class="absolute z-50 mt-2 w-48 rounded-md shadow-lg origin-top-left left-0 top-full">
                                         <div class="rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-white">
                                             <a href="{{ route('pertandingan.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-900 hover:text-white transition duration-150">Semua Pertandingan</a>
                                             @foreach($ligasForMenu as $liga)
                                                 <a href="{{ route('pertandingan.liga', $liga->id) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-green-900 hover:text-white transition duration-150">
                                                     @if($liga->logo_url)<img src="{{ $liga->logo_url }}" class="h-5 w-5 object-contain mr-2">@endif
                                                     <span>{{ $liga->nama }}</span>
                                                 </a>
                                             @endforeach
                                         </div>
                                     </div>
                                </div>
                                
                                {{-- Link Klasemen --}}
                                <x-nav-link :href="route('klasemen.index')" :active="request()->routeIs('klasemen.*')" class="px-2 lg:px-3 {{ request()->routeIs('klasemen.*') ? 'border-green-900' : 'border-transparent' }}">{{ __('Klasemen') }}</x-nav-link>
                            </div>
                        </div>

                        {{-- Bagian Kanan Navigasi (Search & Auth) --}}
                        <div class="flex items-center">
                            <!-- Search Desktop -->
                            <div class="hidden lg:block mr-4">
                                <form action="{{ route('search.index') }}" method="GET">
                                    <div class="relative">
                                        <input type="text" name="query" value="{{ request('query') }}" 
                                               class="block w-full pl-4 pr-10 py-2 text-sm text-gray-700 bg-gray-100 border-gray-300 rounded-full focus:ring-green-900 focus:border-green-900" 
                                               placeholder="Cari...">
                                        <button type="submit" class="absolute inset-y-0 right-0 flex items-center pr-3">
                                            <svg class="w-5 h-5 text-gray-400" viewBox="0 0 24 24">
                                                <path fill="currentColor" d="m19.6 21l-6.3-6.3q-.75.6-1.725.95T9.5 16q-2.725 0-4.612-1.888T3 9.5q0-2.725 1.888-4.612T9.5 3q2.725 0 4.612 1.888T16 9.5q0 1.1-.35 2.075T14.7 13.3l6.3 6.3zM9.5 14q1.875 0 3.188-1.313T14 9.5q0-1.875-1.313-3.188T9.5 5Q7.625 5 6.312 6.313T5 9.5q0 1.875 1.313 3.188T9.5 14"/>
                                            </svg>
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Auth Links -->
                            <div class="hidden sm:block">
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 text-sm">Dashboard</a>
                                @endauth
                            </div>

                            <!-- Mobile Menu Button -->
                            <div class="md:hidden">
                                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-green-900 hover:text-gray-500 focus:outline-none transition duration-150 ease-in-out">
                                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile Navigation Menu -->
                <div :class="{'block': open, 'hidden': !open}" class="hidden md:hidden bg-white border-t">
                    <div class="px-4 pt-2 pb-3 space-y-1">
                        <!-- Search Mobile (dalam menu) -->
                        <div class="py-2">
                            <form action="{{ route('search.index') }}" method="GET">
                                <div class="relative">
                                    <input type="text" name="query" value="{{ request('query') }}" 
                                           class="block w-full pl-4 pr-10 py-2 text-sm text-gray-700 bg-gray-100 border-gray-300 rounded-full focus:ring-green-900 focus:border-green-900" 
                                           placeholder="Cari...">
                                    <button type="submit" class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <svg class="w-5 h-5 text-gray-400" viewBox="0 0 24 24">
                                            <path fill="currentColor" d="m19.6 21l-6.3-6.3q-.75.6-1.725.95T9.5 16q-2.725 0-4.612-1.888T3 9.5q0-2.725 1.888-4.612T9.5 3q2.725 0 4.612 1.888T16 9.5q0 1.1-.35 2.075T14.7 13.3l6.3 6.3zM9.5 14q1.875 0 3.188-1.313T14 9.5q0-1.875-1.313-3.188T9.5 5Q7.625 5 6.312 6.313T5 9.5q0 1.875 1.313 3.188T9.5 14"/>
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <x-responsive-nav-link :href="url('/')" :active="request()->is('/')" class="text-green-900 hover:bg-green-900 hover:text-white">Home</x-responsive-nav-link>
                        
                        <!-- Mobile Klub Dropdown -->
                        <div>
                            <button @click="mobileKlubOpen = !mobileKlubOpen" class="w-full flex items-center justify-between px-3 py-2 rounded-md text-base font-medium text-green-900 hover:text-white hover:bg-green-900 focus:outline-none transition duration-150 ease-in-out">
                                <span>Klub</span>
                                <svg class="h-4 w-4 transition-transform duration-200" :class="{'rotate-180': mobileKlubOpen}" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div x-show="mobileKlubOpen" x-collapse class="pl-4 space-y-1">
                                <a href="{{ route('klub.index') }}" class="block px-3 py-2 text-sm text-green-900 hover:bg-green-900 hover:text-white rounded-md">Semua Klub</a>
                                @foreach($ligasForMenu as $liga)
                                    <a href="{{ route('klub.liga', $liga->id) }}" class="flex items-center px-3 py-2 text-sm text-green-900 hover:bg-green-900 hover:text-white rounded-md">
                                        @if($liga->logo_url)<img src="{{ $liga->logo_url }}" class="h-4 w-4 object-contain mr-2">@endif
                                        <span>{{ $liga->nama }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <!-- Mobile Pemain Dropdown -->
                        <div>
                            <button @click="mobilePemainOpen = !mobilePemainOpen" class="w-full flex items-center justify-between px-3 py-2 rounded-md text-base font-medium text-green-900 hover:bg-green-900 hover:text-white focus:outline-none transition duration-150 ease-in-out">
                                <span>Pemain</span>
                                <svg class="h-4 w-4 transition-transform duration-200" :class="{'rotate-180': mobilePemainOpen}" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div x-show="mobilePemainOpen" x-collapse class="pl-4 space-y-1 max-h-60 overflow-y-auto">
                                <a href="{{ route('pemain.index') }}" class="block px-3 py-2 text-sm font-semibold text-green-900 hover:bg-green-900 hover:text-white rounded-md">Semua Pemain</a>
                                @foreach($ligasForMenu as $liga)
                                    <div x-data="{ openLiga: false }">
                                        <button @click="openLiga = !openLiga" class="w-full text-left flex items-center justify-between px-3 py-2 text-sm text-green-900 hover:bg-green-900 hover:text-white rounded-md">
                                            <span class="flex items-center">
                                                @if($liga->logo_url)<img src="{{ $liga->logo_url }}" class="h-4 w-4 object-contain mr-2">@endif
                                                <span>{{ $liga->nama }}</span>
                                            </span>
                                            <svg class="h-3 w-3 transition-transform duration-200" :class="{'rotate-90': openLiga}" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                        <div x-show="openLiga" x-collapse class="pl-4 space-y-1">
                                            @foreach($liga->klubs as $klub)
                                            <a href="{{ route('pemain.klub', $klub->id) }}" class="flex items-center px-3 py-1 text-xs text-green-900 hover:bg-green-900 hover:text-white rounded-md">
                                                @if($klub->logo_url)<img src="{{ $klub->logo_url }}" class="h-3 w-3 object-contain mr-2 rounded-full">@endif
                                                <span>{{ $klub->nama }}</span>
                                            </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Mobile Pertandingan Dropdown -->
                        <div>
                            <button @click="mobilePertandinganOpen = !mobilePertandinganOpen" class="w-full flex items-center justify-between px-3 py-2 rounded-md text-base font-medium text-green-900 hover:bg-green-900 hover:text-white focus:outline-none transition duration-150 ease-in-out">
                                <span>Pertandingan</span>
                                <svg class="h-4 w-4 transition-transform duration-200" :class="{'rotate-180': mobilePertandinganOpen}" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div x-show="mobilePertandinganOpen" x-collapse class="pl-4 space-y-1">
                                <a href="{{ route('pertandingan.index') }}" class="block px-3 py-2 text-sm text-green-900 hover:bg-green-900 hover:text-white rounded-md">Semua Pertandingan</a>
                                @foreach($ligasForMenu as $liga)
                                    <a href="{{ route('pertandingan.liga', $liga->id) }}" class="flex items-center px-3 py-2 text-sm text-green-900 hover:bg-green-900 hover:text-white rounded-md">
                                        @if($liga->logo_url)<img src="{{ $liga->logo_url }}" class="h-4 w-4 object-contain mr-2">@endif
                                        <span>{{ $liga->nama }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <x-responsive-nav-link :href="route('klasemen.index')" :active="request()->routeIs('klasemen.*')" class="text-green-900 hover:bg-green-900 hover:text-white">Klasemen</x-responsive-nav-link>
                        
                        @auth
                            <x-responsive-nav-link :href="url('/dashboard')">Dashboard</x-responsive-nav-link>
                        @endauth
                    </div>
                </div>
            </nav>

            <main class="pt-16">
                @yield('content')
            </main>
        </div>

        {{-- TAMBAHAN UNTUK SELECT2 (JS) --}}
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2
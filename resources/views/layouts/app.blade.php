<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Lore') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,700;1,500&family=DM+Sans:wght@300;400;500&family=JetBrains+Mono:wght@400&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-[#1A1814] bg-[#FAF9F6]">
        <div class="min-h-screen flex flex-col">
            <!-- Navbar -->
            <nav class="bg-white border-b border-[#E5E0D8]">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <a href="/" class="font-serif italic font-medium text-2xl text-[#D4542A]">
                                    Lore
                                </a>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex items-center">
                                <a href="/" class="font-sans font-normal text-[#1A1814] hover:text-[#D4542A] transition duration-150 ease-in-out">
                                    Browse
                                </a>
                                <a href="#" class="font-sans font-normal text-[#1A1814] hover:text-[#D4542A] transition duration-150 ease-in-out">
                                    Entrepreneurs
                                </a>
                            </div>
                        </div>

                        <!-- Full Width Search on Mobile, Constrained on Desktop -->
                        <div class="flex-1 flex justify-center px-2 lg:ml-6 lg:justify-end py-3">
                            <div class="max-w-lg w-full lg:max-w-xs relative text-gray-400 focus-within:text-[#D4542A]">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <form method="GET" action="{{ route('search') }}">
                                    <input id="search" name="q" value="{{ request('q') }}" class="block w-full pl-10 pr-3 py-2 border border-[#E5E0D8] rounded-md leading-5 bg-white placeholder-[#A09890] font-serif focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-[#D4542A] focus:border-[#D4542A] sm:text-sm transition duration-150 ease-in-out" placeholder="Search Lore..." type="search">
                                </form>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            @auth
                                <div class="relative">
                                    <x-dropdown align="right" width="48">
                                        <x-slot name="trigger">
                                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-[#1A1814] bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                                <div class="flex items-center gap-2">
                                                    @if(Auth::user()->avatar)
                                                        <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" class="h-8 w-8 rounded-full object-cover">
                                                    @else
                                                        <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-semibold">
                                                            {{ substr(Auth::user()->name, 0, 1) }}
                                                        </div>
                                                    @endif
                                                    <span>{{ Auth::user()->name }}</span>
                                                </div>
                                                <div class="ms-1">
                                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            </button>
                                        </x-slot>

                                        <x-slot name="content">
                                            <x-dropdown-link :href="route('dashboard')">
                                                {{ __('Dashboard') }}
                                            </x-dropdown-link>
                                            <x-dropdown-link :href="route('profile.edit')">
                                                {{ __('Profile') }}
                                            </x-dropdown-link>

                                            <!-- Authentication -->
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf

                                                <x-dropdown-link :href="route('logout')"
                                                        onclick="event.preventDefault();
                                                                    this.closest('form').submit();">
                                                    {{ __('Log Out') }}
                                                </x-dropdown-link>
                                            </form>
                                        </x-slot>
                                    </x-dropdown>
                                </div>
                            @else
                                <div class="flex items-center space-x-6">
                                    <a href="{{ route('login') }}" class="font-sans font-normal text-[#1A1814] hover:text-[#D4542A] transition duration-150 ease-in-out">
                                        Login
                                    </a>
                                    <a href="{{ route('register') }}" class="font-sans font-medium bg-[#D4542A] text-white px-5 py-2 rounded-lg hover:bg-[#b8431e] transition duration-150 ease-in-out">
                                        Join Free
                                    </a>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-grow">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-[#FAF9F6] border-t border-[#E5E0D8] py-8 mt-12">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-center items-center">
                    <p class="font-sans text-sm text-[#6B6560]">
                        &copy; {{ date('Y') }} Lore. All rights reserved.
                    </p>
                </div>
            </footer>
        </div>
    </body>
</html>

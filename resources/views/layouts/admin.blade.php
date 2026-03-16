<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Admin — {{ config('app.name', 'Lore') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,700;1,500&family=DM+Sans:wght@300;400;500&family=JetBrains+Mono:wght@400&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-[#1A1814] bg-[#FAF9F6]">
        <div class="min-h-screen flex">

            <!-- Sidebar -->
            <aside class="w-64 bg-[#1A1814] min-h-screen flex flex-col fixed inset-y-0 left-0 z-30">
                <!-- Logo -->
                <div class="h-16 flex items-center px-6 border-b border-white/10">
                    <a href="{{ route('admin.dashboard') }}" class="font-serif italic font-medium text-2xl text-[#D4542A]">
                        Lore
                    </a>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 py-6 px-3 space-y-1">
                    <a href="{{ route('admin.dashboard') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-sans transition-colors
                              {{ request()->routeIs('admin.dashboard')
                                  ? 'bg-white/10 text-white border-l-[3px] border-[#D4542A]'
                                  : 'text-gray-400 hover:text-white hover:bg-white/5 border-l-[3px] border-transparent' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Dashboard
                    </a>

                    <a href="#"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-sans transition-colors
                              {{ request()->routeIs('admin.videos*')
                                  ? 'bg-white/10 text-white border-l-[3px] border-[#D4542A]'
                                  : 'text-gray-400 hover:text-white hover:bg-white/5 border-l-[3px] border-transparent' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        Videos
                    </a>

                    <a href="#"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-sans transition-colors
                              {{ request()->routeIs('admin.users*')
                                  ? 'bg-white/10 text-white border-l-[3px] border-[#D4542A]'
                                  : 'text-gray-400 hover:text-white hover:bg-white/5 border-l-[3px] border-transparent' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        Users
                    </a>
                </nav>

                <!-- User Info -->
                <div class="border-t border-white/10 p-4">
                    <div class="flex items-center gap-3">
                        <div class="h-8 w-8 rounded-full bg-[#D4542A] flex items-center justify-center text-white font-sans text-sm font-medium">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-sans text-white truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs font-sans text-gray-500 truncate">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="mt-3">
                        @csrf
                        <button type="submit" class="w-full text-left text-xs font-sans text-gray-500 hover:text-white transition-colors">
                            Sign out
                        </button>
                    </form>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="flex-1 ml-64">
                <!-- Top Bar -->
                <header class="h-16 bg-white border-b border-[#E5E0D8] flex items-center px-8">
                    <h1 class="font-serif text-xl text-[#1A1814]">@yield('title', 'Admin')</h1>
                    <div class="ml-auto">
                        <a href="{{ route('home') }}" class="font-sans text-sm text-[#6B6560] hover:text-[#D4542A] transition-colors">
                            ← Back to site
                        </a>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="p-8">
                    @yield('content')
                </main>
            </div>
        </div>
    </body>
</html>

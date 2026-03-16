@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <!-- Welcome -->
    <div class="mb-8">
        <h2 class="font-serif text-2xl text-[#1A1814]">Welcome back, {{ Auth::user()->name }}</h2>
        <p class="font-sans text-sm text-[#6B6560] mt-1">Here's what's happening with Lore today.</p>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Videos -->
        <div class="bg-white rounded-xl border border-[#E5E0D8] p-6 shadow-[0_2px_12px_rgba(26,24,20,0.04)]">
            <div class="flex items-center justify-between mb-4">
                <span class="font-sans text-sm text-[#6B6560]">Total Videos</span>
                <div class="h-10 w-10 rounded-lg bg-[#FDF0EC] flex items-center justify-center">
                    <svg class="w-5 h-5 text-[#D4542A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
            <p class="font-serif text-3xl text-[#1A1814]">{{ number_format($videoCount) }}</p>
        </div>

        <!-- Total Users -->
        <div class="bg-white rounded-xl border border-[#E5E0D8] p-6 shadow-[0_2px_12px_rgba(26,24,20,0.04)]">
            <div class="flex items-center justify-between mb-4">
                <span class="font-sans text-sm text-[#6B6560]">Total Users</span>
                <div class="h-10 w-10 rounded-lg bg-[#EDF7ED] flex items-center justify-center">
                    <svg class="w-5 h-5 text-[#3A7D44]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
            <p class="font-serif text-3xl text-[#1A1814]">{{ number_format($userCount) }}</p>
        </div>

        <!-- Total Views -->
        <div class="bg-white rounded-xl border border-[#E5E0D8] p-6 shadow-[0_2px_12px_rgba(26,24,20,0.04)]">
            <div class="flex items-center justify-between mb-4">
                <span class="font-sans text-sm text-[#6B6560]">Total Views</span>
                <div class="h-10 w-10 rounded-lg bg-[#EBF0FA] flex items-center justify-center">
                    <svg class="w-5 h-5 text-[#4A6FA5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
            </div>
            <p class="font-serif text-3xl text-[#1A1814]">{{ number_format($totalViews) }}</p>
        </div>

        <!-- Featured Videos -->
        <div class="bg-white rounded-xl border border-[#E5E0D8] p-6 shadow-[0_2px_12px_rgba(26,24,20,0.04)]">
            <div class="flex items-center justify-between mb-4">
                <span class="font-sans text-sm text-[#6B6560]">Featured Videos</span>
                <div class="h-10 w-10 rounded-lg bg-[#FFF8E7] flex items-center justify-center">
                    <svg class="w-5 h-5 text-[#C49B2A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                </div>
            </div>
            <p class="font-serif text-3xl text-[#1A1814]">{{ number_format($featuredCount) }}</p>
        </div>
    </div>
@endsection

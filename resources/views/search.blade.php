<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 mb-12">

        <!-- Large Search Header -->
        <div class="flex flex-col items-center justify-center py-10">
            <form action="{{ route('search') }}" method="GET" class="w-full max-w-2xl relative">
                <input type="text" name="q" value="{{ $query }}"
                    placeholder="Search for ideas, frameworks, or founders..."
                    class="w-full px-6 py-4 text-xl font-serif border-2 border-[#E5E0D8] rounded-[12px] focus:outline-none focus:border-[#D4542A] focus:ring-0 transition-colors shadow-sm text-[#1A1814] placeholder-[#A09890]"
                    autofocus>
                @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                @if(request('tag'))
                <input type="hidden" name="tag" value="{{ request('tag') }}">
                @endif
                <button type="submit"
                    class="absolute right-3 top-3 bottom-3 bg-[#D4542A] hover:bg-[#b8431e] text-white px-6 rounded-lg font-sans font-medium transition duration-150 ease-in-out flex items-center justify-center">
                    Search
                </button>
            </form>
            @if($query)
            <div class="mt-8 text-center text-[#6B6560] font-sans text-[15px]">
                {{ $videos->total() }} result{{ $videos->total() !== 1 ? 's' : '' }} for <span
                    class="text-[#1A1814] font-medium">'{{ $query }}'</span>
            </div>
            @endif
        </div>

        @if($videos->isEmpty())
        <!-- Empty State -->
        <div class="flex flex-col items-center justify-center py-16 px-4 text-center">
            <div class="w-20 h-20 rounded-full bg-[#F2EFE9] flex items-center justify-center mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[#A09890]" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <h3 class="font-serif text-2xl text-[#1A1814] mb-3">Nothing here yet</h3>
            <p class="font-sans text-[16px] text-[#6B6560] max-w-md mx-auto">
                We couldn't find any videos matching your search. Try searching for broader terms like 'fundraising',
                'growth', or 'pivot'.
            </p>
            <a href="/" class="mt-8 text-[#D4542A] hover:underline font-sans font-medium">
                &larr; Back to all videos
            </a>
        </div>
        @else
        <!-- Search Results Grid -->
        <div class="columns-1 md:columns-2 lg:columns-3 gap-5 space-y-5">
            @foreach($videos as $video)
            <div class="break-inside-avoid w-full bg-white rounded-[12px] overflow-hidden shadow-[0_2px_12px_rgba(26,24,20,0.07)] hover:-translate-y-[3px] transition-transform duration-[250ms] ease-in-out group cursor-pointer"
                onclick="window.location.href='{{ route('videos.show', $video->slug) }}'">
                <div class="relative w-full aspect-video bg-gray-100 overflow-hidden">
                    <img src="https://img.youtube.com/vi/{{ $video->youtube_id }}/mqdefault.jpg" onerror="this.src='https://img.youtube.com/vi/{{ $video->youtube_id }}/0.jpg'"
                        alt="{{ $video->title }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
                </div>
                <div class="p-[14px]">
                    <h3
                        class="font-serif text-[16px] text-[#1A1814] leading-snug mb-1 group-hover:text-[#D4542A] transition-colors">
                        {{ $video->title }}
                    </h3>
                    <div class="flex items-center justify-between mt-3">
                        <span class="font-sans text-[13px] text-[#6B6560]">
                            {{ $video->user->name ?? 'Unknown Creator' }}
                        </span>
                        @if($video->categories->isNotEmpty())
                        <span class="font-mono text-[10px] bg-[#F2EFE9] text-[#6B6560] rounded px-2 py-0.5">
                            {{ $video->categories->first()->name }}
                        </span>
                        @endif
                    </div>
                    <div class="mt-2 text-[#6B6560] font-sans text-xs">
                        {{ number_format($video->views) }} views
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-12 flex justify-center">
            {{ $videos->links() }}
        </div>
        @endif

    </div>
</x-app-layout>
<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

        <!-- Entrepreneur Profile Header -->
        <div class="flex flex-col items-center justify-center text-center mb-16 relative">

            @if(auth()->id() === $user->id)
            <a href="{{ route('profile.edit') }}"
                class="absolute top-0 right-0 inline-block px-4 py-2 border border-[#E5E0D8] rounded-md text-sm font-sans font-medium text-[#6B6560] hover:text-[#D4542A] hover:border-[#D4542A] transition bg-white">
                Edit Profile
            </a>
            @endif

            <img src="https://img.youtube.com/vi/{{ $video->youtube_id }}/maxresdefault.jpg"
     onerror="this.onerror=null; this.src='https://img.youtube.com/vi/{{ $video->youtube_id }}/hqdefault.jpg';"
     alt="{{ $video->title }}"
     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">

            <h1 class="font-serif text-[36px] text-[#1A1814] mb-4">{{ $user->name }}</h1>

            <p class="font-sans text-[16px] text-[#6B6560] max-w-2xl leading-[1.7] mb-6">
                {{ $user->bio ?? 'Entrepreneur and creator on Lore.' }}
            </p>

            <div class="font-sans text-[14px] text-[#A09890] mb-8 font-medium">
                {{ $videos->count() }} video{{ $videos->count() !== 1 ? 's' : '' }} &middot; {{
                number_format($totalViews) }} total view{{ $totalViews !== 1 ? 's' : '' }}
            </div>

            @if($user->social_links && count($user->social_links) > 0)
            <div class="flex gap-4">
                @foreach($user->social_links as $platform => $url)
                <a href="{{ $url }}" target="_blank" rel="noopener noreferrer"
                    class="text-[#A09890] hover:text-[#D4542A] transition transform hover:scale-105">
                    @if(strtolower($platform) === 'twitter' || strtolower($platform) === 'x')
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path
                            d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 22.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.008 5.961H5.078z">
                        </path>
                    </svg>
                    @elseif(strtolower($platform) === 'linkedin')
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"
                            clip-rule="evenodd"></path>
                    </svg>
                    @elseif(strtolower($platform) === 'website' || strtolower($platform) === 'portfolio')
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9">
                        </path>
                    </svg>
                    @else
                    <span class="font-mono text-sm capitalize">{{ $platform }}</span>
                    @endif
                </a>
                @endforeach
            </div>
            @endif
        </div>

        <hr class="border-[#E5E0D8] mb-12 max-w-3xl mx-auto">

        <!-- Entrepreneur Videos Grid -->
        @if($videos->isEmpty())
        <div class="text-center py-12">
            <p class="font-sans text-[#6B6560]">This creator hasn't published any videos yet.</p>
        </div>
        @else
        <div class="columns-1 md:columns-2 lg:columns-3 gap-5 space-y-5">
            @foreach($videos as $video)
            <div class="break-inside-avoid w-full bg-white rounded-[12px] overflow-hidden shadow-[0_2px_12px_rgba(26,24,20,0.07)] hover:-translate-y-[3px] transition-transform duration-[250ms] ease-in-out group cursor-pointer"
                onclick="window.location.href='{{ route('videos.show', $video->slug) }}'">
                <div class="relative w-full aspect-video bg-gray-100 overflow-hidden">
                    <img src="https://img.youtube.com/vi/{{ $video->youtube_id }}/maxresdefault.jpg"
     onerror="this.onerror=null; this.src='https://img.youtube.com/vi/{{ $video->youtube_id }}/hqdefault.jpg';"
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
                            {{ $video->created_at->diffForHumans() }}
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
        @endif

    </div>
</x-app-layout>

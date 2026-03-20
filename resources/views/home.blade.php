<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- HERO BANNER -->
        @if($featuredVideo)
        <div class="relative w-full h-[480px] rounded-xl overflow-hidden mb-12 shadow-[0_2px_12px_rgba(26,24,20,0.07)]">
            <div class="absolute inset-0 bg-cover bg-center"
                style="background-image: url('https://img.youtube.com/vi/{{ $featuredVideo->youtube_id }}/mqdefault.jpg');">
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>

            <div class="absolute bottom-0 left-0 p-8 md:p-12 w-full">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                    <div class="max-w-3xl">
                        @if($featuredVideo->categories->isNotEmpty())
                        <span
                            class="inline-block font-mono text-xs bg-white/20 text-white backdrop-blur-md rounded px-2 py-1 mb-3">
                            {{ $featuredVideo->categories->first()->name }}
                        </span>
                        @endif
                        <h1 class="font-serif text-white text-3xl md:text-[42px] leading-tight mb-2">
                            {{ $featuredVideo->title }}
                        </h1>
                        <p class="font-sans text-gray-200 text-lg">
                            {{ $featuredVideo->user->name ?? 'Unknown Creator' }}
                        </p>
                    </div>
                    <div>
                        <a href="{{ route('videos.show', $featuredVideo->slug) }}"
                            class="inline-block font-sans font-medium bg-[#D4542A] text-white px-6 py-3 rounded-lg hover:bg-[#b8431e] transition duration-150 ease-in-out whitespace-nowrap">
                            Watch Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- CATEGORY FILTER ROW -->
        <div class="flex overflow-x-auto hide-scrollbar gap-3 mb-10 pb-2">
            <a href="/"
                class="shrink-0 px-4 py-2 rounded-full font-sans text-sm transition-colors {{ !$activeCategory ? 'bg-[#D4542A] text-white border border-[#D4542A]' : 'bg-transparent text-[#1A1814] border border-[#E5E0D8] hover:border-[#D4542A]' }}">
                All
            </a>
            @foreach($categories as $category)
            <a href="/?category={{ $category->slug }}"
                class="shrink-0 px-4 py-2 rounded-full font-sans text-sm transition-colors {{ $activeCategory === $category->slug ? 'bg-[#D4542A] text-white border border-[#D4542A]' : 'bg-transparent text-[#1A1814] border border-[#E5E0D8] hover:border-[#D4542A]' }}">
                {{ $category->name }}
            </a>
            @endforeach
        </div>

        <style>
            .hide-scrollbar::-webkit-scrollbar {
                display: none;
            }

            .hide-scrollbar {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }
        </style>

        <!-- MASONRY GRID -->
        <div class="mb-6">
            <h2 class="font-serif text-[28px] text-[#1A1814]">Latest from Founders</h2>
        </div>

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

    </div>
</x-app-layout>
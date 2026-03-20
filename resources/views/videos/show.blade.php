<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if(session('status'))
        <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-[12px] border border-green-200">
            {{ session('status') }}
        </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-12">
            <!-- LEFT COLUMN -->
            <div class="w-full lg:w-[70%]">
                <!-- YouTube Embed -->
                <div class="mb-8">
                    <iframe width="100%" height="430" src="https://www.youtube.com/embed/{{ $video->youtube_id }}"
                        frameborder="0" allowfullscreen style="border-radius:12px"></iframe>
                </div>

                <!-- Title & Meta -->
                <div class="mb-8 relative pr-16">
                    <h1 class="font-serif text-[32px] text-[#1A1814] leading-tight mb-2">{{ $video->title }}</h1>

                    <div class="font-sans text-[13px] text-[#6B6560]">
                        {{ number_format($video->views) }} views &bull; Published {{ $video->created_at->format('M j,
                        Y') }}
                    </div>

                    <!-- Bookmark Button -->
                    <div class="absolute top-0 right-0">
                        @auth
                        @if(auth()->user()->bookmarkedVideos->contains($video->id))
                        <form action="{{ route('bookmarks.destroy', $video) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-12 h-12 rounded-[12px] flex items-center justify-center bg-[#FEE2E2] text-red-500 border border-transparent transition hover:scale-105"
                                title="Remove Bookmark">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </form>
                        @else
                        <form action="{{ route('bookmarks.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="video_id" value="{{ $video->id }}">
                            <button type="submit"
                                class="w-12 h-12 rounded-[12px] flex items-center justify-center bg-white border border-[#E5E0D8] text-[#1A1814] transition hover:scale-105"
                                title="Bookmark Video">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </button>
                        </form>
                        @endif
                        @else
                        <a href="{{ route('login') }}"
                            class="w-12 h-12 rounded-[12px] flex items-center justify-center bg-white border border-[#E5E0D8] text-[#1A1814] transition hover:scale-105"
                            title="Login to Bookmark">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </a>
                        @endauth
                    </div>
                </div>

                <!-- Entrepreneur Card -->
                <div
                    class="flex items-start gap-4 mb-8 p-6 bg-white border border-[#E5E0D8] rounded-[12px] shadow-[0_2px_12px_rgba(26,24,20,0.03)]">
                    <img src="{{ $video->user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($video->user->name).'&color=D4542A&background=FAF9F6' }}"
                        alt="{{ $video->user->name }}"
                        class="w-16 h-16 rounded-full object-cover shrink-0 border border-[#E5E0D8]">
                    <div>
                        <a href="/entrepreneurs/{{ $video->user->username ?? $video->user->id }}"
                            class="font-serif text-[18px] text-[#1A1814] hover:text-[#D4542A] transition">
                            {{ $video->user->name }}
                        </a>
                        <p class="font-sans text-[14px] text-[#6B6560] mt-1 leading-snug">
                            {{ $video->user->bio ?? 'Entrepreneur and creator on Lore.' }}
                        </p>
                        @if($video->user->social_links)
                        <div class="flex gap-3 mt-3 text-[#A09890]">
                            @foreach($video->user->social_links as $platform => $url)
                            <a href="{{ $url }}" target="_blank" rel="noopener noreferrer"
                                class="hover:text-[#D4542A] text-sm capitalize font-mono">
                                {{ $platform }}
                            </a>
                            @endforeach
                        </div>
                        @else
                        <div class="flex gap-3 mt-3 text-[#A09890]">
                            <a href="#" class="hover:text-[#D4542A] text-sm font-mono">Twitter</a>
                            <a href="#" class="hover:text-[#D4542A] text-sm font-mono">LinkedIn</a>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Tags Row -->
                @if($video->tags->count() > 0)
                <div class="flex flex-wrap gap-2 mb-6">
                    @foreach($video->tags as $tag)
                    <span
                        class="font-mono text-[11px] bg-[#F2EFE9] border border-[#E5E0D8] rounded-md px-2 py-1 text-[#6B6560]">
                        #{{ $tag->name }}
                    </span>
                    @endforeach
                </div>
                @endif

                <!-- Description -->
                <div class="font-sans text-[#1A1814] text-[16px] leading-[1.7] whitespace-pre-wrap">
                    {{ $video->description }}
                </div>
            </div>

            <!-- RIGHT COLUMN -->
            <div class="w-full lg:w-[30%] pt-2">
                <h3 class="font-mono text-[10px] uppercase text-[#A09890] tracking-wider mb-6">More from Founders</h3>

                <div class="flex flex-col gap-6">
                    @foreach($relatedVideos as $related)
                    <a href="{{ route('videos.show', $related->slug) }}" class="group flex gap-4 items-start">
                        <div class="w-[100px] aspect-video shrink-0 rounded-md overflow-hidden bg-[#E5E0D8] relative">
                            <img src="https://img.youtube.com/vi/{{ $related->youtube_id }}/mqdefault.jpg" onerror="this.src='https://img.youtube.com/vi/{{ $related->youtube_id }}/0.jpg'"
                                alt="{{ $related->title }}" class="absolute inset-0 w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0 pt-0.5">
                            <h4
                                class="font-serif text-[#1A1814] text-[15px] leading-snug break-words group-hover:text-[#D4542A] transition line-clamp-2">
                                {{ $related->title }}
                            </h4>
                            <p class="font-sans text-[#6B6560] text-[12px] truncate mt-1">
                                {{ $related->user->name }}
                            </p>
                        </div>
                    </a>
                    @endforeach

                    @if($relatedVideos->isEmpty())
                    <div
                        class="text-[#6B6560] text-[13px] font-sans italic bg-white p-4 rounded-[12px] border border-[#E5E0D8]">
                        No related videos found.
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
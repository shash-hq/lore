<x-app-layout>
    <div style="max-width:1200px; margin:0 auto; padding:40px 24px;">

        {{-- Greeting --}}
        <div style="margin-bottom:40px;">
            <h1
                style="font-family:'Playfair Display',serif; font-size:28px; font-weight:500; color:#1A1814; margin:0 0 6px;">
                Good morning, {{ auth()->user()->name }} 👋
            </h1>
            <p style="font-family:'DM Sans',sans-serif; font-size:15px; color:#6B6560; margin:0;">
                Here's what you've saved and what's trending.
            </p>
        </div>

        {{-- Watchlist --}}
        <div style="margin-bottom:56px;">
            <div style="display:flex; align-items:baseline; justify-content:space-between; margin-bottom:24px;">
                <h2
                    style="font-family:'Playfair Display',serif; font-size:22px; font-weight:500; color:#1A1814; margin:0;">
                    Your Watchlist
                </h2>
                <span
                    style="font-family:'JetBrains Mono',monospace; font-size:11px; color:#A09890; letter-spacing:1px;">
                    {{ $bookmarks->count() }} {{ Str::plural('video', $bookmarks->count()) }} saved
                </span>
            </div>

            @if($bookmarks->isEmpty())
            {{-- Empty state --}}
            <div
                style="text-align:center; padding:60px 24px; background:#F2EFE9; border-radius:16px; border:1px dashed #D4C4B8;">
                <div style="font-size:40px; margin-bottom:16px;">🎬</div>
                <h3 style="font-family:'Playfair Display',serif; font-size:20px; color:#1A1814; margin:0 0 8px;">Your
                    watchlist is empty</h3>
                <p style="font-family:'DM Sans',sans-serif; font-size:14px; color:#6B6560; margin:0 0 24px;">Start
                    saving
                    videos you love and they'll appear here.</p>
                <a href="{{ route('home') }}"
                    style="background:#D4542A; color:white; padding:10px 24px; border-radius:8px; font-family:'DM Sans',sans-serif; font-size:14px; font-weight:500; text-decoration:none;">
                    Browse Videos →
                </a>
            </div>
            @else
            <div style="columns:3; column-gap:20px;">
                @foreach($bookmarks as $video)
                <div style="break-inside:avoid; margin-bottom:20px; background:white; border-radius:12px; overflow:hidden; box-shadow:0 2px 12px rgba(26,24,20,0.07); position:relative; transition:transform 0.25s ease;"
                    onmouseover="this.style.transform='translateY(-3px)'"
                    onmouseout="this.style.transform='translateY(0)'">

                    {{-- Remove bookmark button --}}
                    <form method="POST" action="{{ route('bookmarks.destroy', $video->id) }}"
                        style="position:absolute; top:10px; right:10px; z-index:10;">
                        @csrf @method('DELETE')
                        <button type="submit" title="Remove from watchlist"
                            style="background:rgba(255,255,255,0.9); border:none; border-radius:50%; width:32px; height:32px; cursor:pointer; font-size:16px; display:flex; align-items:center; justify-content:center; box-shadow:0 1px 4px rgba(0,0,0,0.15);">
                            ♥
                        </button>
                    </form>

                    <a href="{{ route('videos.show', $video->slug) }}" style="text-decoration:none;">
                        <img src="https://img.youtube.com/vi/{{ $video->youtube_id }}/hqdefault.jpg"
                            style="width:100%; display:block;" alt="{{ $video->title }}">
                        <div style="padding:14px;">
                            <h3
                                style="font-family:'Playfair Display',serif; font-size:15px; color:#1A1814; margin:0 0 6px; line-height:1.4;">
                                {{ $video->title }}
                            </h3>
                            <div style="display:flex; align-items:center; justify-content:space-between;">
                                <span style="font-family:'DM Sans',sans-serif; font-size:12px; color:#6B6560;">
                                    {{ $video->user->name ?? 'Unknown' }}
                                </span>
                                @if($video->categories->first())
                                <span
                                    style="font-family:'JetBrains Mono',monospace; font-size:10px; color:#A09890; background:#F2EFE9; padding:2px 8px; border-radius:4px;">
                                    {{ $video->categories->first()->name }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Recommended --}}
        @if($recommended->isNotEmpty())
        <div>
            <h2
                style="font-family:'Playfair Display',serif; font-size:22px; font-weight:500; color:#1A1814; margin:0 0 24px;">
                You might enjoy
            </h2>
            <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:20px;">
                @foreach($recommended as $video)
                <a href="{{ route('videos.show', $video->slug) }}" style="text-decoration:none;">
                    <div style="background:white; border-radius:12px; overflow:hidden; box-shadow:0 2px 12px rgba(26,24,20,0.07); transition:transform 0.25s ease;"
                        onmouseover="this.style.transform='translateY(-3px)'"
                        onmouseout="this.style.transform='translateY(0)'">
                        <img src="https://img.youtube.com/vi/{{ $video->youtube_id }}/hqdefault.jpg"
                            style="width:100%; display:block;" alt="{{ $video->title }}">
                        <div style="padding:14px;">
                            <h3
                                style="font-family:'Playfair Display',serif; font-size:14px; color:#1A1814; margin:0 0 4px; line-height:1.4;">
                                {{ $video->title }}
                            </h3>
                            <span style="font-family:'DM Sans',sans-serif; font-size:12px; color:#6B6560;">
                                {{ $video->user->name ?? 'Unknown' }}
                            </span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</x-app-layout>
<x-app-layout>
    <div style="font-family:'DM Sans',sans-serif;">

        {{-- HERO --}}
        <section style="min-height:100vh; background:#FAF9F6; display:flex; align-items:center; padding:80px 24px;">
            <div
                style="max-width:1200px; margin:0 auto; display:grid; grid-template-columns:1fr 1fr; gap:60px; align-items:center; width:100%;">

                {{-- Left --}}
                <div>
                    <div
                        style="font-family:'JetBrains Mono',monospace; font-size:11px; letter-spacing:3px; color:#D4542A; text-transform:uppercase; margin-bottom:20px;">
                        For Founders. By Founders.
                    </div>
                    <h1
                        style="font-family:'Playfair Display',serif; font-size:clamp(36px,4vw,56px); font-weight:500; color:#1A1814; line-height:1.15; letter-spacing:-1px; margin:0 0 20px;">
                        Where Founders<br><em>Tell Their Stories</em>
                    </h1>
                    <p style="font-size:18px; color:#6B6560; line-height:1.6; margin:0 0 36px; max-width:440px;">
                        Real journeys. Honest failures. What actually works. Learn from entrepreneurs who've been
                        through it.
                    </p>
                    <div style="display:flex; gap:14px; flex-wrap:wrap;">
                        <a href="{{ route('home') }}"
                            style="background:#D4542A; color:white; padding:14px 28px; border-radius:8px; font-size:15px; font-weight:500; text-decoration:none; display:inline-block; transition:opacity 0.2s;"
                            onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                            Explore Free →
                        </a>
                        <a href="{{ route('login') }}"
                            style="border:1.5px solid #D4542A; color:#D4542A; padding:14px 28px; border-radius:8px; font-size:15px; font-weight:500; text-decoration:none; display:inline-block; background:transparent; transition:all 0.2s;"
                            onmouseover="this.style.background='#FEF8F5'"
                            onmouseout="this.style.background='transparent'">
                            Sign In
                        </a>
                    </div>
                </div>

                {{-- Right: thumbnail collage --}}
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; position:relative;">
                    @php $collage = App\Models\Video::where('is_published', true)->inRandomOrder()->limit(4)->get();
                    @endphp
                    @foreach($collage as $i => $video)
                    <div style="border-radius:12px; overflow:hidden; box-shadow:0 8px 30px rgba(26,24,20,0.12);
                    transform:{{ $i === 0 ? 'rotate(-2deg)' : ($i === 1 ? 'rotate(1.5deg)' : ($i === 2 ? 'rotate(1deg)' : 'rotate(-1.5deg)')) }};
                    transition:transform 0.3s ease;" onmouseover="this.style.transform='rotate(0deg) scale(1.03)'"
                        onmouseout="this.style.transform='{{ $i === 0 ? 'rotate(-2deg)' : ($i === 1 ? 'rotate(1.5deg)' : ($i === 2 ? 'rotate(1deg)' : 'rotate(-1.5deg)')) }}'">
                        <img src="https://img.youtube.com/vi/{{ $video->youtube_id }}/maxresdefault.jpg"
     onerror="this.onerror=null; this.src='https://img.youtube.com/vi/{{ $video->youtube_id }}/hqdefault.jpg';"
     style="width:100%; display:block;"
     alt="{{ $video->title }}">
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- STATS BAR --}}
        <section
            style="background:#F2EFE9; border-top:1px solid #E5E0D8; border-bottom:1px solid #E5E0D8; padding:28px 24px;">
            <div
                style="max-width:1200px; margin:0 auto; display:flex; justify-content:center; align-items:center; gap:48px; flex-wrap:wrap;">
                @php
                $videoCount = App\Models\Video::where('is_published', true)->count();
                $creatorCount = App\Models\User::whereIn('role', ['creator','admin'])->count();
                @endphp
                <div style="text-align:center;">
                    <div style="font-family:'Playfair Display',serif; font-size:32px; color:#D4542A; font-weight:500;">
                        {{ $videoCount }}</div>
                    <div style="font-family:'DM Sans',sans-serif; font-size:13px; color:#6B6560; margin-top:2px;">Videos
                    </div>
                </div>
                <div style="width:1px; height:40px; background:#D4C4B8;"></div>
                <div style="text-align:center;">
                    <div style="font-family:'Playfair Display',serif; font-size:32px; color:#D4542A; font-weight:500;">
                        {{ $creatorCount }}</div>
                    <div style="font-family:'DM Sans',sans-serif; font-size:13px; color:#6B6560; margin-top:2px;">
                        Entrepreneurs</div>
                </div>
                <div style="width:1px; height:40px; background:#D4C4B8;"></div>
                <div style="text-align:center;">
                    <div style="font-family:'Playfair Display',serif; font-size:32px; color:#2D5F4F; font-weight:500;">
                        Free</div>
                    <div style="font-family:'DM Sans',sans-serif; font-size:13px; color:#6B6560; margin-top:2px;">
                        Forever</div>
                </div>
            </div>
        </section>

        {{-- CATEGORIES --}}
        <section style="padding:80px 24px; background:#FAF9F6;">
            <div style="max-width:1200px; margin:0 auto;">
                <h2
                    style="font-family:'Playfair Display',serif; font-size:32px; font-weight:500; color:#1A1814; text-align:center; margin:0 0 40px;">
                    Explore by Topic
                </h2>
                <div style="display:flex; flex-wrap:wrap; gap:16px; justify-content:center;">
                    @foreach(App\Models\Category::withCount('videos')->get() as $cat)
                    <a href="{{ route('home') }}?category={{ $cat->slug }}"
                        style="background:white; border:1px solid #E5E0D8; border-radius:10px; padding:20px 28px; text-decoration:none; text-align:center; min-width:140px; transition:all 0.2s;"
                        onmouseover="this.style.borderColor='#D4542A'; this.style.transform='translateY(-2px)'"
                        onmouseout="this.style.borderColor='#E5E0D8'; this.style.transform='translateY(0)'">
                        <div
                            style="font-family:'Playfair Display',serif; font-size:16px; color:#1A1814; margin-bottom:4px;">
                            {{ $cat->name }}</div>
                        <div style="font-family:'JetBrains Mono',monospace; font-size:11px; color:#A09890;">{{
                            $cat->videos_count }} videos</div>
                    </a>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- FINAL CTA --}}
        <section style="background:#1A1814; padding:100px 24px; text-align:center;">
            <div style="max-width:600px; margin:0 auto;">
                <h2
                    style="font-family:'Playfair Display',serif; font-size:clamp(28px,3vw,42px); font-weight:500; color:#FAF9F6; margin:0 0 16px; line-height:1.2;">
                    Ready to learn from<br><em>real founders?</em>
                </h2>
                <p
                    style="font-family:'DM Sans',sans-serif; font-size:16px; color:#6B6560; margin:0 0 36px; line-height:1.6;">
                    Join thousands of builders watching honest founder stories.
                </p>
                <a href="{{ route('register') }}"
                    style="background:#D4542A; color:white; padding:16px 36px; border-radius:8px; font-family:'DM Sans',sans-serif; font-size:16px; font-weight:500; text-decoration:none; display:inline-block; transition:opacity 0.2s;"
                    onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                    Join Free Today
                </a>
            </div>
        </section>

    </div>
</x-app-layout>

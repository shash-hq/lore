@extends('layouts.admin')

@section('title', 'Manage Videos')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 style="font-family:'Playfair Display',serif; font-size:24px; color:#1A1814;">Videos</h1>
    <a href="{{ route('admin.videos.create') }}"
       style="background:#D4542A; color:white; padding:8px 20px; border-radius:8px; font-family:'DM Sans',sans-serif; font-size:14px; text-decoration:none;">
        + Add Video
    </a>
</div>

@if(session('success'))
    <div style="background:#ECFDF5; border:1px solid #A7F3D0; color:#065F46; padding:12px 16px; border-radius:8px; margin-bottom:20px; font-family:'DM Sans',sans-serif; font-size:14px;">
        {{ session('success') }}
    </div>
@endif

<div style="background:white; border:1px solid #E5E0D8; border-radius:12px; overflow:hidden;">
    <table style="width:100%; border-collapse:collapse;">
        <thead>
            <tr style="background:#FAF9F6; border-bottom:1px solid #E5E0D8;">
                <th style="padding:12px 16px; text-align:left; font-family:'DM Sans',sans-serif; font-size:11px; letter-spacing:1px; text-transform:uppercase; color:#6B6560;">Video</th>
                <th style="padding:12px 16px; text-align:left; font-family:'DM Sans',sans-serif; font-size:11px; letter-spacing:1px; text-transform:uppercase; color:#6B6560;">Creator</th>
                <th style="padding:12px 16px; text-align:left; font-family:'DM Sans',sans-serif; font-size:11px; letter-spacing:1px; text-transform:uppercase; color:#6B6560;">Views</th>
                <th style="padding:12px 16px; text-align:center; font-family:'DM Sans',sans-serif; font-size:11px; letter-spacing:1px; text-transform:uppercase; color:#6B6560;">Published</th>
                <th style="padding:12px 16px; text-align:center; font-family:'DM Sans',sans-serif; font-size:11px; letter-spacing:1px; text-transform:uppercase; color:#6B6560;">Featured</th>
                <th style="padding:12px 16px; text-align:center; font-family:'DM Sans',sans-serif; font-size:11px; letter-spacing:1px; text-transform:uppercase; color:#6B6560;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($videos as $video)
            <tr style="border-bottom:1px solid #F2EFE9;">
                <td style="padding:12px 16px;">
                    <div style="display:flex; align-items:center; gap:12px;">
                        <img src="https://img.youtube.com/vi/{{ $video->youtube_id }}/mqdefault.jpg" onerror="this.src='https://img.youtube.com/vi/{{ $video->youtube_id }}/0.jpg'"
                             style="width:60px; height:45px; object-fit:cover; border-radius:6px;" alt="">
                        <span style="font-family:'DM Sans',sans-serif; font-size:13px; color:#1A1814; max-width:280px; display:block; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                            {{ $video->title }}
                        </span>
                    </div>
                </td>
                <td style="padding:12px 16px; font-family:'DM Sans',sans-serif; font-size:13px; color:#6B6560;">
                    {{ $video->user->name ?? '—' }}
                </td>
                <td style="padding:12px 16px; font-family:'JetBrains Mono',monospace; font-size:13px; color:#1A1814;">
                    {{ number_format($video->views) }}
                </td>
                <td style="padding:12px 16px; text-align:center;">
                    <form method="POST" action="{{ route('admin.videos.toggle-published', $video) }}">
                        @csrf @method('PATCH')
                        <button type="submit" style="padding:4px 12px; border-radius:20px; border:none; cursor:pointer; font-family:'DM Sans',sans-serif; font-size:11px; font-weight:500;
                            background:{{ $video->is_published ? '#ECFDF5' : '#FEE2E2' }};
                            color:{{ $video->is_published ? '#065F46' : '#991B1B' }};">
                            {{ $video->is_published ? 'Live' : 'Hidden' }}
                        </button>
                    </form>
                </td>
                <td style="padding:12px 16px; text-align:center;">
                    <form method="POST" action="{{ route('admin.videos.toggle-featured', $video) }}">
                        @csrf @method('PATCH')
                        <button type="submit" style="padding:4px 12px; border-radius:20px; border:none; cursor:pointer; font-family:'DM Sans',sans-serif; font-size:11px; font-weight:500;
                            background:{{ $video->is_featured ? '#FEF3E2' : '#F2EFE9' }};
                            color:{{ $video->is_featured ? '#92400E' : '#6B6560' }};">
                            {{ $video->is_featured ? '★ Featured' : 'Normal' }}
                        </button>
                    </form>
                </td>
                <td style="padding:12px 16px; text-align:center;">
                    <form method="POST" action="{{ route('admin.videos.destroy', $video) }}"
                          onsubmit="return confirm('Delete this video?')">
                        @csrf @method('DELETE')
                        <button type="submit" style="padding:4px 12px; border-radius:6px; border:1px solid #FCA5A5; background:white; color:#991B1B; cursor:pointer; font-family:'DM Sans',sans-serif; font-size:12px;">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div style="margin-top:20px;">
    {{ $videos->links() }}
</div>
@endsection
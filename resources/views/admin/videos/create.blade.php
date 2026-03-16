@extends('layouts.admin')

@section('title', 'Add Video')

@section('content')
<div class="flex items-center gap-4 mb-6">
    <a href="{{ route('admin.videos.index') }}"
        style="color:#D4542A; font-family:'DM Sans',sans-serif; font-size:14px;">← Back to Videos</a>
    <h1 style="font-family:'Playfair Display',serif; font-size:24px; color:#1A1814;">Add New Video</h1>
</div>

<div style="background:white; border:1px solid #E5E0D8; border-radius:12px; padding:28px; max-width:640px;">
    <form method="POST" action="{{ route('admin.videos.store') }}">
        @csrf

        <div style="margin-bottom:20px;">
            <label
                style="display:block; font-family:'DM Sans',sans-serif; font-size:13px; color:#1A1814; margin-bottom:6px; font-weight:500;">Title</label>
            <input type="text" name="title" value="{{ old('title') }}" required
                style="width:100%; padding:10px 14px; border:1px solid #E5E0D8; border-radius:8px; font-family:'DM Sans',sans-serif; font-size:14px; color:#1A1814; outline:none; box-sizing:border-box;">
            @error('title') <p style="color:#D4542A; font-size:12px; margin-top:4px;">{{ $message }}</p> @enderror
        </div>

        <div style="margin-bottom:20px;">
            <label
                style="display:block; font-family:'DM Sans',sans-serif; font-size:13px; color:#1A1814; margin-bottom:6px; font-weight:500;">YouTube
                Video ID</label>
            <input type="text" name="youtube_id" value="{{ old('youtube_id') }}" required placeholder="e.g. dQw4w9WgXcQ"
                style="width:100%; padding:10px 14px; border:1px solid #E5E0D8; border-radius:8px; font-family:'JetBrains Mono',monospace; font-size:13px; color:#1A1814; outline:none; box-sizing:border-box;">
            @error('youtube_id') <p style="color:#D4542A; font-size:12px; margin-top:4px;">{{ $message }}</p> @enderror
        </div>

        <div style="margin-bottom:20px;">
            <label
                style="display:block; font-family:'DM Sans',sans-serif; font-size:13px; color:#1A1814; margin-bottom:6px; font-weight:500;">Description</label>
            <textarea name="description" rows="4" required
                style="width:100%; padding:10px 14px; border:1px solid #E5E0D8; border-radius:8px; font-family:'DM Sans',sans-serif; font-size:14px; color:#1A1814; outline:none; resize:vertical; box-sizing:border-box;">{{ old('description') }}</textarea>
            @error('description') <p style="color:#D4542A; font-size:12px; margin-top:4px;">{{ $message }}</p> @enderror
        </div>

        <div style="margin-bottom:20px;">
            <label
                style="display:block; font-family:'DM Sans',sans-serif; font-size:13px; color:#1A1814; margin-bottom:10px; font-weight:500;">Categories</label>
            <div style="display:flex; flex-wrap:wrap; gap:8px;">
                @foreach($categories as $category)
                <label style="display:flex; align-items:center; gap:6px; cursor:pointer;">
                    <input type="checkbox" name="categories[]" value="{{ $category->id }}" {{ in_array($category->id,
                    old('categories', [])) ? 'checked' : '' }}>
                    <span style="font-family:'DM Sans',sans-serif; font-size:13px; color:#1A1814;">{{ $category->name
                        }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <div style="margin-bottom:28px;">
            <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}>
                <span style="font-family:'DM Sans',sans-serif; font-size:13px; color:#1A1814;">Publish
                    immediately</span>
            </label>
        </div>

        <button type="submit"
            style="background:#D4542A; color:white; padding:10px 28px; border:none; border-radius:8px; font-family:'DM Sans',sans-serif; font-size:14px; font-weight:500; cursor:pointer;">
            Add Video
        </button>
    </form>
</div>
@endsection
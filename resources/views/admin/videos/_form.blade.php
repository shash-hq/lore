@php
    $selectedCategoryIds = old('categories', isset($video) ? $video->categories->pluck('id')->all() : []);
    $selectedTagIds = old('tags', isset($video) ? $video->tags->pluck('id')->all() : []);
@endphp

<div style="background:white; border:1px solid #E5E0D8; border-radius:12px; padding:28px; max-width:760px;">
    <form method="POST" action="{{ $action }}">
        @csrf
        @if($method !== 'POST')
            @method($method)
        @endif

        <div style="margin-bottom:20px;">
            <label style="display:block; font-family:'DM Sans',sans-serif; font-size:13px; color:#1A1814; margin-bottom:6px; font-weight:500;">Title</label>
            <input type="text" name="title" value="{{ old('title', isset($video) ? $video->title : '') }}" required
                style="width:100%; padding:10px 14px; border:1px solid #E5E0D8; border-radius:8px; font-family:'DM Sans',sans-serif; font-size:14px; color:#1A1814; outline:none; box-sizing:border-box;">
            @error('title') <p style="color:#D4542A; font-size:12px; margin-top:4px;">{{ $message }}</p> @enderror
        </div>

        <div style="margin-bottom:20px;">
            <label style="display:block; font-family:'DM Sans',sans-serif; font-size:13px; color:#1A1814; margin-bottom:6px; font-weight:500;">YouTube Video URL or ID</label>
            <input type="text" name="youtube_id" value="{{ old('youtube_id', isset($video) ? $video->youtube_id : '') }}" required placeholder="e.g. dQw4w9WgXcQ or https://youtu.be/dQw4w9WgXcQ"
                style="width:100%; padding:10px 14px; border:1px solid #E5E0D8; border-radius:8px; font-family:'JetBrains Mono',monospace; font-size:13px; color:#1A1814; outline:none; box-sizing:border-box;">
            <p style="margin-top:6px; font-family:'DM Sans',sans-serif; font-size:12px; color:#6B6560;">
                Lore will normalize either a full YouTube URL or a plain 11-character video ID.
            </p>
            @error('youtube_id') <p style="color:#D4542A; font-size:12px; margin-top:4px;">{{ $message }}</p> @enderror
        </div>

        <div style="margin-bottom:20px;">
            <label style="display:block; font-family:'DM Sans',sans-serif; font-size:13px; color:#1A1814; margin-bottom:6px; font-weight:500;">Description</label>
            <textarea name="description" rows="5" required
                style="width:100%; padding:10px 14px; border:1px solid #E5E0D8; border-radius:8px; font-family:'DM Sans',sans-serif; font-size:14px; color:#1A1814; outline:none; resize:vertical; box-sizing:border-box;">{{ old('description', isset($video) ? $video->description : '') }}</textarea>
            @error('description') <p style="color:#D4542A; font-size:12px; margin-top:4px;">{{ $message }}</p> @enderror
        </div>

        <div style="margin-bottom:20px;">
            <label style="display:block; font-family:'DM Sans',sans-serif; font-size:13px; color:#1A1814; margin-bottom:10px; font-weight:500;">Categories</label>
            <div style="display:flex; flex-wrap:wrap; gap:8px;">
                @foreach($categories as $category)
                    <label style="display:flex; align-items:center; gap:6px; cursor:pointer; background:#FAF9F6; border:1px solid #E5E0D8; border-radius:999px; padding:8px 12px;">
                        <input type="checkbox" name="categories[]" value="{{ $category->id }}" {{ in_array($category->id, $selectedCategoryIds) ? 'checked' : '' }}>
                        <span style="font-family:'DM Sans',sans-serif; font-size:13px; color:#1A1814;">{{ $category->name }}</span>
                    </label>
                @endforeach
            </div>
            @error('categories') <p style="color:#D4542A; font-size:12px; margin-top:4px;">{{ $message }}</p> @enderror
            @error('categories.*') <p style="color:#D4542A; font-size:12px; margin-top:4px;">{{ $message }}</p> @enderror
        </div>

        <div style="margin-bottom:20px;">
            <label style="display:block; font-family:'DM Sans',sans-serif; font-size:13px; color:#1A1814; margin-bottom:10px; font-weight:500;">Tags</label>
            <div style="display:flex; flex-wrap:wrap; gap:8px;">
                @foreach($tags as $tag)
                    <label style="display:flex; align-items:center; gap:6px; cursor:pointer; background:#FAF9F6; border:1px solid #E5E0D8; border-radius:999px; padding:8px 12px;">
                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ in_array($tag->id, $selectedTagIds) ? 'checked' : '' }}>
                        <span style="font-family:'JetBrains Mono',monospace; font-size:12px; color:#1A1814;">#{{ $tag->name }}</span>
                    </label>
                @endforeach
            </div>
            @error('tags') <p style="color:#D4542A; font-size:12px; margin-top:4px;">{{ $message }}</p> @enderror
            @error('tags.*') <p style="color:#D4542A; font-size:12px; margin-top:4px;">{{ $message }}</p> @enderror
        </div>

        <div style="display:flex; flex-wrap:wrap; gap:18px; margin-bottom:28px;">
            <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                <input type="checkbox" name="is_published" value="1" {{ old('is_published', isset($video) ? $video->is_published : true) ? 'checked' : '' }}>
                <span style="font-family:'DM Sans',sans-serif; font-size:13px; color:#1A1814;">Publish immediately</span>
            </label>

            <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', isset($video) ? $video->is_featured : false) ? 'checked' : '' }}>
                <span style="font-family:'DM Sans',sans-serif; font-size:13px; color:#1A1814;">Make featured story</span>
            </label>
        </div>

        <button type="submit"
            style="background:#D4542A; color:white; padding:10px 28px; border:none; border-radius:8px; font-family:'DM Sans',sans-serif; font-size:14px; font-weight:500; cursor:pointer;">
            {{ $submitLabel }}
        </button>
    </form>
</div>

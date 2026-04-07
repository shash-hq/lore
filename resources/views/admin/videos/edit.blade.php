@extends('layouts.admin')

@section('title', 'Edit Video')

@section('content')
<div class="flex items-center gap-4 mb-6">
    <a href="{{ route('admin.videos.index') }}"
        style="color:#D4542A; font-family:'DM Sans',sans-serif; font-size:14px;">← Back to Videos</a>
    <h1 style="font-family:'Playfair Display',serif; font-size:24px; color:#1A1814;">Edit Video</h1>
</div>

@include('admin.videos._form', [
    'action' => route('admin.videos.update', $video),
    'method' => 'PUT',
    'submitLabel' => 'Save Changes',
    'video' => $video,
])
@endsection

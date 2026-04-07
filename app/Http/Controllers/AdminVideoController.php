<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminVideoRequest;
use App\Models\Tag;
use App\Models\Video;
use App\Models\Category;

class AdminVideoController extends Controller
{
    public function index()
    {
        $videos = Video::with('user', 'categories', 'tags')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.videos.index', compact('videos'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();

        return view('admin.videos.create', compact('categories', 'tags'));
    }

    public function store(AdminVideoRequest $request)
    {
        $video = Video::create([
            'user_id' => auth()->id(),
            ...$request->validatedVideoAttributes(),
        ]);

        $video->categories()->sync($request->input('categories', []));
        $video->tags()->sync($request->input('tags', []));

        return redirect()->route('admin.videos.index')
            ->with('success', 'Video added successfully.');
    }

    public function edit(Video $video)
    {
        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();

        return view('admin.videos.edit', compact('video', 'categories', 'tags'));
    }

    public function update(AdminVideoRequest $request, Video $video)
    {
        $video->update($request->validatedVideoAttributes());
        $video->categories()->sync($request->input('categories', []));
        $video->tags()->sync($request->input('tags', []));

        return redirect()
            ->route('admin.videos.index')
            ->with('success', 'Video updated successfully.');
    }

    public function togglePublished(Video $video)
    {
        $video->update(['is_published' => !$video->is_published]);
        return back()->with('success', 'Video visibility updated.');
    }

    public function toggleFeatured(Video $video)
    {
        $video->update(['is_featured' => !$video->is_featured]);
        return back()->with('success', 'Featured status updated.');
    }

    public function destroy(Video $video)
    {
        $video->delete();
        return back()->with('success', 'Video deleted.');
    }
}

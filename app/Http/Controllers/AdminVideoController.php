<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminVideoController extends Controller
{
    public function index()
    {
        $videos = Video::with('user', 'categories')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        return view('admin.videos.index', compact('videos'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.videos.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'youtube_id' => 'required|string|max:50',
            'description' => 'required|string',
            'is_published' => 'boolean',
        ]);

        $video = Video::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'youtube_id' => $validated['youtube_id'],
            'description' => $validated['description'],
            'thumbnail_url' => 'https://img.youtube.com/vi/' . $validated['youtube_id'] . '/hqdefault.jpg',
            'is_published' => $request->boolean('is_published'),
            'is_featured' => false,
        ]);

        if ($request->has('categories')) {
            $video->categories()->sync($request->categories);
        }

        return redirect()->route('admin.videos.index')
            ->with('success', 'Video added successfully.');
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
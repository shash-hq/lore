<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');
        
        $videos = Video::where('is_published', true);

        if ($query) {
            $videos->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            });
        }

        if ($request->has('category')) {
            $videos->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.slug', $request->category);
            });
        }
        
        if ($request->has('tag')) {
            $videos->whereHas('tags', function ($q) use ($request) {
                $q->where('tags.name', $request->tag);
            });
        }

        $videos = $videos->with(['user', 'categories'])->paginate(18)->withQueryString();

        return view('search', compact('videos', 'query'));
    }
}

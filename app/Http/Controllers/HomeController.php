<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\Category;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $featuredVideo = Video::where('is_featured', true)
                              ->where('is_published', true)
                              ->with(['user', 'categories'])
                              ->first();

        $query = Video::with(['user', 'categories', 'tags'])
                      ->where('is_published', true);

        $activeCategory = $request->query('category');
        if ($activeCategory) {
            $query->whereHas('categories', function ($q) use ($activeCategory) {
                $q->where('slug', $activeCategory);
            });
        }

        $videos = $query->latest()->paginate(15)->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('home', compact('featuredVideo', 'videos', 'categories', 'activeCategory'));
    }
}

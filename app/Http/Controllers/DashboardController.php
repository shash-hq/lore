<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $bookmarks = $user->bookmarkedVideos()
            ->with('categories', 'tags', 'user')
            ->latest('bookmarks.created_at')
            ->get();

        $bookmarkedIds = $bookmarks->pluck('id');
        $recommended = \App\Models\Video::with('categories', 'user')
            ->where('is_published', true)
            ->when($bookmarkedIds->isNotEmpty(), fn ($query) => $query->whereNotIn('id', $bookmarkedIds))
            ->orderBy('views', 'desc')
            ->limit(6)
            ->get();

        return view('dashboard', compact('bookmarks', 'recommended'));
    }
}

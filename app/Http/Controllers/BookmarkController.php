<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'video_id' => 'required|exists:videos,id',
        ]);

        $user = Auth::user();
        $changes = $user->bookmarkedVideos()->syncWithoutDetaching([$request->video_id]);

        if (!empty($changes['attached'])) {
            return back()->with('status', 'Video bookmarked!');
        }

        return back()->with('status', 'This video is already in your watchlist.');
    }

    public function destroy(Video $video)
    {
        $user = Auth::user();
        $user->bookmarkedVideos()->detach($video->id);
        
        return back()->with('status', 'Bookmark removed!');
    }
}

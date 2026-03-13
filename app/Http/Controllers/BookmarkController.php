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
        if (!$user->bookmarkedVideos()->where('video_id', $request->video_id)->exists()) {
            $user->bookmarkedVideos()->attach($request->video_id);
            return back()->with('status', 'Video bookmarked!');
        }

        return back();
    }

    public function destroy(Video $video)
    {
        $user = Auth::user();
        $user->bookmarkedVideos()->detach($video->id);
        
        return back()->with('status', 'Bookmark removed!');
    }
}

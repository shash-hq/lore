<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function show(Request $request, $slug)
    {
        $video = Video::with(['user', 'categories', 'tags'])->where('slug', $slug)->firstOrFail();

        $sessionKey = 'viewed_' . $video->id;
        if (!$request->session()->has($sessionKey)) {
            $video->increment('views');
            $request->session()->put($sessionKey, true);
        }

        $firstCategory = $video->categories->first();
        
        if ($firstCategory) {
            $relatedVideos = $firstCategory->videos()
                ->where('videos.id', '!=', $video->id)
                ->where('is_published', true)
                ->with(['user'])
                ->take(6)
                ->get();
        } else {
            $relatedVideos = collect();
        }

        return view('videos.show', compact('video', 'relatedVideos'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $videoCount = Video::count();
        $userCount = User::count();
        $totalViews = Video::sum('views');
        $featuredCount = Video::where('is_featured', true)->count();

        return view('admin.dashboard', compact(
            'videoCount',
            'userCount',
            'totalViews',
            'featuredCount'
        ));
    }
}

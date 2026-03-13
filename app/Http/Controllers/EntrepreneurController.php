<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class EntrepreneurController extends Controller
{
    public function show($username)
    {
        $user = User::where('username', $username)
                    ->whereIn('role', ['creator', 'admin'])
                    ->firstOrFail();

        $videos = $user->videos()
                       ->where('is_published', true)
                       ->with('categories')
                       ->latest()
                       ->get();

        $totalViews = $videos->sum('views');

        return view('entrepreneurs.show', compact('user', 'videos', 'totalViews'));
    }
}

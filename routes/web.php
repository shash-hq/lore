<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\EntrepreneurController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class , 'index'])->name('home');
Route::get('/search', [SearchController::class , 'index'])->name('search');
Route::get('/videos/{slug}', [VideoController::class , 'show'])->name('videos.show');
Route::get('/entrepreneurs/{username}', [EntrepreneurController::class , 'show'])->name('entrepreneurs.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class , 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class , 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class , 'destroy'])->name('profile.destroy');

    Route::post('/bookmarks', [BookmarkController::class , 'store'])->name('bookmarks.store');
    Route::delete('/bookmarks/{video}', [BookmarkController::class , 'destroy'])->name('bookmarks.destroy');
});

require __DIR__ . '/auth.php';

use App\Http\Controllers\SocialiteController;
use Laravel\Socialite\Facades\Socialite;

Route::get('/auth/google', [SocialiteController::class , 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [SocialiteController::class , 'handleGoogleCallback']);

use App\Http\Controllers\AdminController;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class , 'dashboard'])->name('dashboard');
    Route::get('/videos', [App\Http\Controllers\AdminVideoController::class , 'index'])->name('videos.index');
    Route::get('/videos/create', [App\Http\Controllers\AdminVideoController::class , 'create'])->name('videos.create');
    Route::post('/videos', [App\Http\Controllers\AdminVideoController::class , 'store'])->name('videos.store');
    Route::patch('/videos/{video}/toggle-published', [App\Http\Controllers\AdminVideoController::class , 'togglePublished'])->name('videos.toggle-published');
    Route::patch('/videos/{video}/toggle-featured', [App\Http\Controllers\AdminVideoController::class , 'toggleFeatured'])->name('videos.toggle-featured');
    Route::delete('/videos/{video}', [App\Http\Controllers\AdminVideoController::class , 'destroy'])->name('videos.destroy');
});
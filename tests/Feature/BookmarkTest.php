<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookmarkTest extends TestCase
{
    use RefreshDatabase;

    public function test_duplicate_bookmarks_are_not_created(): void
    {
        $user = User::factory()->create();
        $video = Video::factory()->create();

        $this->actingAs($user)->post('/bookmarks', [
            'video_id' => $video->id,
        ]);

        $response = $this->actingAs($user)->from('/videos/'.$video->slug)->post('/bookmarks', [
            'video_id' => $video->id,
        ]);

        $response->assertSessionHas('status', 'This video is already in your watchlist.');
        $this->assertDatabaseCount('bookmarks', 1);
    }
}

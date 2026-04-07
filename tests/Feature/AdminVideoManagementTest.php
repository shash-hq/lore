<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminVideoManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_a_video_with_categories_tags_and_a_normalized_youtube_id(): void
    {
        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create();
        $tag = Tag::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.videos.store'), [
            'title' => 'How to Survive the First 100 Customers',
            'youtube_id' => 'https://youtu.be/dQw4w9WgXcQ',
            'description' => 'A field report on early distribution.',
            'categories' => [$category->id],
            'tags' => [$tag->id],
            'is_published' => '1',
            'is_featured' => '1',
        ]);

        $response->assertRedirect(route('admin.videos.index'));

        $video = Video::first();

        $this->assertSame('dQw4w9WgXcQ', $video->youtube_id);
        $this->assertTrue($video->is_featured);
        $this->assertTrue($video->is_published);
        $this->assertDatabaseHas('category_video', [
            'category_id' => $category->id,
            'video_id' => $video->id,
        ]);
        $this->assertDatabaseHas('tag_video', [
            'tag_id' => $tag->id,
            'video_id' => $video->id,
        ]);
    }

    public function test_admin_video_update_validates_youtube_and_related_ids(): void
    {
        $admin = User::factory()->admin()->create();
        $video = Video::factory()->create();

        $response = $this->actingAs($admin)
            ->from(route('admin.videos.edit', $video))
            ->put(route('admin.videos.update', $video), [
                'title' => 'Updated Title',
                'youtube_id' => 'not-a-valid-youtube-id',
                'description' => 'Updated description',
                'categories' => [9999],
                'tags' => [9999],
            ]);

        $response
            ->assertRedirect(route('admin.videos.edit', $video))
            ->assertSessionHasErrors(['youtube_id', 'categories.0', 'tags.0']);
    }

    public function test_featuring_a_video_unfeatures_the_previous_featured_video(): void
    {
        $admin = User::factory()->admin()->create();
        $original = Video::factory()->featured()->create();
        $replacement = Video::factory()->create();

        $this->actingAs($admin)->patch(route('admin.videos.toggle-featured', $replacement));

        $this->assertTrue($replacement->fresh()->is_featured);
        $this->assertFalse($original->fresh()->is_featured);
    }
}

<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_displays_featured_and_latest_videos(): void
    {
        $category = Category::factory()->create([
            'name' => 'Growth',
            'slug' => 'growth',
        ]);

        $featuredVideo = Video::factory()->featured()->create([
            'title' => 'Featured Founder Story',
        ]);
        $featuredVideo->categories()->sync([$category->id]);

        $latestVideo = Video::factory()->create([
            'title' => 'Latest Founder Story',
        ]);
        $latestVideo->categories()->sync([$category->id]);

        $response = $this->get('/');

        $response
            ->assertOk()
            ->assertSee('Featured Founder Story')
            ->assertSee('Latest Founder Story')
            ->assertSee('Growth');
    }

    public function test_homepage_can_filter_by_category(): void
    {
        $growth = Category::factory()->create([
            'name' => 'Growth',
            'slug' => 'growth',
        ]);

        $product = Category::factory()->create([
            'name' => 'Product',
            'slug' => 'product',
        ]);

        $growthVideo = Video::factory()->featured()->create([
            'title' => 'Growth Strategy Deep Dive',
        ]);
        $growthVideo->categories()->sync([$growth->id]);

        $productVideo = Video::factory()->create([
            'title' => 'Product Teardown',
        ]);
        $productVideo->categories()->sync([$product->id]);

        $response = $this->get('/?category=growth');

        $response
            ->assertOk()
            ->assertSee('Growth Strategy Deep Dive')
            ->assertDontSee('Product Teardown');
    }
}

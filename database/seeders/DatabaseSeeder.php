<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Video;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1 admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@lore.com'],
            [
                'name' => 'Admin User',
                'username' => 'admin',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );

        // 3 creator users
        $creators = [];
        for ($i = 1; $i <= 3; $i++) {
            $creators[] = User::firstOrCreate(
                ['email' => "creator{$i}@lore.com"],
                [
                    'name' => "Creator {$i}",
                    'username' => "creator{$i}",
                    'password' => bcrypt('password'),
                    'role' => 'creator',
                ]
            );
        }

        // 5 categories
        $categoriesData = [
            ['name' => 'Fundraising', 'slug' => 'fundraising', 'description' => 'Guides and stories about raising capital.'],
            ['name' => 'Product', 'slug' => 'product', 'description' => 'Building and managing products.'],
            ['name' => 'Failure Stories', 'slug' => 'failure-stories', 'description' => 'Learning from past mistakes.'],
            ['name' => 'Growth', 'slug' => 'growth', 'description' => 'Scaling and growth strategies.'],
            ['name' => 'Mindset', 'slug' => 'mindset', 'description' => 'Entrepreneurial mindset and psychology.']
        ];
        $categories = collect();
        foreach ($categoriesData as $data) {
            $categories->push(Category::firstOrCreate(['slug' => $data['slug']], $data));
        }

        // 10 tags
        $tagsData = ['bootstrap', 'saas', 'b2b', 'marketplace', 'deeptech', 'climate', 'fintech', 'solofounder', 'pivot', 'ipo'];
        $tags = collect();
        foreach ($tagsData as $tagName) {
            $tags->push(Tag::firstOrCreate(['slug' => Str::slug($tagName)], ['name' => $tagName]));
        }

        // 20 real YouTube videos
        $youtubeVideos = [
            ['id' => '0lN0C9W27fM', 'title' => 'How to Talk to Users - Eric Migicovsky'],
            ['id' => 'DOtCl5PU8F0', 'title' => 'How to Get Startup Ideas - Jared Friedman'],
            ['id' => 'wzZIfT7eB6w', 'title' => 'How to Evaluate Startup Ideas - Kevin Hale'],
            ['id' => 'ii1jcLg-eIQ', 'title' => 'How to Plan an MVP - Michael Seibel'],
            ['id' => 'bIQZ1I9L1L4', 'title' => 'Sam Altman - How to Succeed with a Startup'],
            ['id' => 'C8vOEvg_x-g', 'title' => 'How to Start a Startup - Sam Altman'],
            ['id' => 'CBYhVcO4WgI', 'title' => 'Competition is for Losers - Peter Thiel'],
            ['id' => '9vIe6o_X5G0', 'title' => 'Elon Musk: SpaceX, Mars, Tesla Autopilot | Lex Fridman'],
            ['id' => 'gzGIfg82UWM', 'title' => 'Marc Andreessen: Future of the Internet, Technology, and AI'],
            ['id' => '8f4yD2Fv5y0', 'title' => 'Brian Chesky - How to Build the Future'],
            ['id' => 'WwR-zY49XwA', 'title' => 'Reid Hoffman - How to be a Great Founder'],
            ['id' => 'yGqLaK_7bUQ', 'title' => 'Fundraising Fundamentals - Aaron Epstein'],
            ['id' => 'ZRvYqbM9Hns', 'title' => 'All About Pivoting - Dalton Caldwell'],
            ['id' => 'y2pC318fXgM', 'title' => 'Building Culture - Tim Brady'],
            ['id' => 'K048kYd1dNE', 'title' => 'How to Be a Great Founder - Paul Buchheit'],
            ['id' => 'xYpWItd8Uv4', 'title' => 'Pricing Your Product - A16z'],
            ['id' => '1A61IiyvHns', 'title' => 'Building and Managing a Team - Jason Calacanis'],
            ['id' => 'w2oG9Z-0m3A', 'title' => 'How to Build a Product - Adora Cheung'],
            ['id' => 'ZTkYmFkOtsQ', 'title' => 'Building a MVP - Michael Seibel'],
            ['id' => 'J-GVd_pehWM', 'title' => 'How to Start a Startup - Dustin Moskovitz']
        ];

        foreach ($youtubeVideos as $index => $v) {
            $creator = $creators[array_rand($creators)];
            
            $video = Video::create([
                'user_id' => $creator->id,
                'title' => $v['title'],
                'slug' => Str::slug($v['title'] . '-' . Str::random(5)), // Ensure unique slug
                'description' => 'A great talk about entrepreneurship, startups, and building products. Highly recommended for founders trying to learn the ropes of building a successful company.',
                'youtube_id' => $v['id'],
                'thumbnail_url' => "https://img.youtube.com/vi/{$v['id']}/maxresdefault.jpg",
                'views' => rand(100, 10000),
                'is_featured' => ($index === 0), // Set first video as featured
                'is_published' => true,
            ]);

            // Assign 1 random category
            $video->categories()->attach($categories->random()->id);

            // Assign 2-4 random tags
            $randomTags = $tags->random(rand(2, 4))->pluck('id');
            $video->tags()->attach($randomTags);
        }
    }
}

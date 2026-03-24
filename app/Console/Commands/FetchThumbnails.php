<?php

namespace App\Console\Commands;

use App\Models\Video;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchThumbnails extends Command
{
    protected $signature   = 'videos:fetch-thumbnails';
    protected $description = 'Fetch real thumbnail URLs from YouTube oEmbed API';

    public function handle(): void
    {
        $videos = Video::all();
        $bar    = $this->output->createProgressBar($videos->count());

        foreach ($videos as $video) {
            try {
                $response = Http::timeout(5)->get(
                    'https://www.youtube.com/oembed',
                    [
                        'url'    => 'https://www.youtube.com/watch?v=' . $video->youtube_id,
                        'format' => 'json',
                    ]
                );

                if ($response->successful()) {
                    $video->update([
                        'thumbnail_url' => $response->json('thumbnail_url')
                    ]);
                    $this->line(" ✓ {$video->title}");
                } else {
                    $this->warn(" ✗ Failed: {$video->title} (HTTP {$response->status()})");
                }

            } catch (\Exception $e) {
                $this->warn(" ✗ Error: {$video->title} — {$e->getMessage()}");
            }

            $bar->advance();
            usleep(200000); // 200ms delay — be polite to YouTube's API
        }

        $bar->finish();
        $this->newLine();
        $this->info('Done. Thumbnail URLs updated.');
    }
}

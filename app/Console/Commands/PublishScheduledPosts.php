<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;

class PublishScheduledPosts extends Command
{
     protected $signature = 'posts:publish-scheduled';
    protected $description = 'Command for publishing scheduled posts';

    public function handle()
    {
        $now = now();

        Post::where('status', 'scheduled')
            ->where('scheduled_time', '<=', $now)
            ->chunkById(50, function ($posts) {
                foreach ($posts as $post) {
                    $post->update(['status' => 'published']);

                    foreach ($post->platforms as $platform) {
                        $post->platforms()->updateExistingPivot($platform->id, [
                            'platform_status' => 'published',
                        ]);
                    }
                }
            });

        $this->info('Scheduled posts processed.');
    }
}

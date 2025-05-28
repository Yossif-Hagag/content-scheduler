<?php

namespace Database\Seeders;

use App\Models\Platform;
use App\Models\User;
use Arr;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Enums\UserType;
use Illuminate\Database\Seeder;
use App\Models\Post;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //3 posts for every user & every post has random platform and random platform_status
        // depens on scheduled_time and status of post

        User::all()->each(function ($user) {
            // Skip admin users, they don't need active platforms
            if ($user->type === UserType::Admin) {
                return;
            }

            Post::factory()
                ->count(3)
                ->create([
                    'user_id' => $user->id,
                ])
                ->each(function ($post) {
                    $platforms = Platform::inRandomOrder()->take(rand(1, 4))->pluck('id');

                    $platformStatuses = $platforms->mapWithKeys(function ($id) use ($post) {
                        $status = match ($post->status) {
                            'draft' => 'draft',
                            'scheduled' => 'scheduled',
                            'published' => Arr::random(['published', 'failed']),
                            default => 'draft',
                        };

                        return [
                            $id => [
                                'platform_status' => $status,
                                'published_at' => $status === 'published' ? now()->subMinutes(rand(1, 120)) : null,
                            ],
                        ];
                    });

                    //attach every post with platform
                    $post->platforms()->attach($platformStatuses);
                });
        });
    }
}

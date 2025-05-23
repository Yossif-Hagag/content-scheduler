<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Post::class;

    public function definition(): array
    {
        $scheduledTime = now()->addDays(rand(-10, 10));
        return [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'image_url' => $this->faker->imageUrl,
            'scheduled_time' => $scheduledTime,
            'status' => $scheduledTime->isFuture() ?
                $this->faker->randomElement(['scheduled', 'draft']) :
                'published',
            'user_id' => null,
        ];
    }
}

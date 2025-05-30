<?php

namespace App\Http\Controllers\Api;
use App\ApiResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Platform;

class AnalyticsController extends Controller
{
    use ApiResponseTrait;
    public function posts(Request $request)
    {
        $user = $request->user();

        // 1. Posts per platform
        $postsPerPlatform = Platform::withCount([
            'posts' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }
        ])->get(['id', 'name']);

        // 2. Success rate (published / total)
        $totalPosts = Post::where('user_id', $user->id)->count();
        $publishedPosts = Post::where('user_id', $user->id)->where('status', 'published')->count();
        $successRate = $totalPosts > 0 ? round(($publishedPosts / $totalPosts) * 100, 2) : 0;

        // 3. Scheduled vs Published
        $scheduledCount = Post::where('user_id', $user->id)->where('status', 'scheduled')->count();

        return $this->apiResponse(
            [
                'posts_per_platform' => $postsPerPlatform,
                'success_rate' => $successRate,
                'scheduled_count' => $scheduledCount,
                'published_count' => $publishedPosts,
            ],
            200,
            'Analytics data fetched successfully'
        );
    }
}

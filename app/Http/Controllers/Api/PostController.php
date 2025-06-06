<?php

namespace App\Http\Controllers\Api;

use App\Services\ActivityLogger;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Platform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use App\ApiResponseTrait;
use Carbon\Carbon;

class PostController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request)
    {
        $user = $request->user();

        $query = Post::with('platforms')
            ->where('user_id', $user->id);

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('date')) {
            $date = Carbon::parse($request->date);
            $query->whereDate('scheduled_time', $date);
        }

        $posts = $query->latest()->get();

        return $this->apiResponse($posts, Response::HTTP_OK, 'User posts fetched successfully');
    }

    public function store(Request $request)
    {
        if (!is_array($request->platforms)) {
            $request->merge([
                'platforms' => (array) $request->platforms
            ]);
        }
        $rules = [
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:2000',
            'scheduled_time' => 'nullable|date',
            'status' => 'in:draft,scheduled,published',
            'platforms' => 'required|array',
            'platforms.*' => 'exists:platforms,id',
        ];

        if ($request->hasFile('image_url')) {
            $rules['image_url'] = 'nullable|image|max:2048';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->apiResponse(null, 422, $validator->errors()->first());
        }

        //Draft posts cannot have a scheduled time
        if ($request->status === 'draft' && $request->scheduled_time) {
            return $this->apiResponse(null, 422, 'Draft posts cannot have a scheduled time.');
        }
        // Check if the user has reached the daily limit for scheduled posts
        if ($request->status === 'scheduled' && $request->scheduled_time) {
            $scheduledDate = Carbon::parse($request->scheduled_time)->toDateString();

            $scheduledCount = Post::where('user_id', $request->user()->id)
                ->where('status', 'scheduled')
                ->whereDate('scheduled_time', $scheduledDate)
                ->count();

            if ($scheduledCount >= 10) {
                return $this->apiResponse(null, 422, 'You can only schedule up to 10 posts per day.');
            }
        }

        $platforms = Platform::whereIn('id', $request->platforms)->get();

        foreach ($platforms as $platform) {
            if ($platform->name === 'Twitter' && strlen($request->content) > 280) {
                return $this->apiResponse(null, 422, 'Content exceeds Twitter limit (280 characters).');
            }
            if ($platform->name === 'LinkedIn' && strlen($request->content) > 1300) {
                return $this->apiResponse(null, 422, 'Content exceeds LinkedIn limit (1300 characters).');
            }
            if ($platform->name === 'Facebook' && strlen($request->content) > 5000) {
                return $this->apiResponse(null, 422, 'Content exceeds Facebook limit (5000 characters).');
            }
            if ($platform->name === 'Instagram' && strlen($request->content) > 2200) {
                return $this->apiResponse(null, 422, 'Content exceeds Instagram limit (2200 characters).');
            }
        }

        $post = new Post();
        $post->user_id = $request->user()->id;
        $post->title = $request->title;
        $post->content = $request->content;
        $post->scheduled_time = $request->scheduled_time;
        $post->status = $request->status ?? 'draft';

        if ($request->hasFile('image_url')) {
            $post->image_url = $request->file('image_url')->store('posts', 'public');
        }

        $post->save();
        $post->platforms()->sync($request->platforms);

        ActivityLogger::log(auth()->id(), 'Created Post', 'User created a new post titled "' . $post->title . '"');

        return $this->apiResponse($post->load('platforms'), 201, 'Post created successfully');
    }

    public function show(Post $post, Request $request)
    {
        if ($post->user_id !== $request->user()->id) {
            return $this->apiResponse(null, Response::HTTP_FORBIDDEN, 'Unauthorized');
        }

        return $this->apiResponse($post->load('platforms'), Response::HTTP_OK, 'Post details');
    }

    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== $request->user()->id) {
            return $this->apiResponse(null, 403, 'Unauthorized');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string|max:2000',
            'scheduled_time' => 'nullable|sometimes|date',
            'status' => 'in:draft,scheduled,published',
            'platforms' => 'sometimes|array',
            'platforms.*' => 'exists:platforms,id',
            'image_url' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(null, 422, $validator->errors()->first());
        }

        $content = $request->content ?? $post->content;

        //Draft posts cannot have a scheduled time
        if ($request->status === 'draft' && $request->scheduled_time) {
            return $this->apiResponse(null, 422, 'Draft posts cannot have a scheduled time.');
        }
        // Check if the user has reached the daily limit for scheduled posts
        if ($request->status === 'scheduled' && $request->scheduled_time) {
            $scheduledDate = Carbon::parse($request->scheduled_time)->toDateString();

            $scheduledCount = Post::where('user_id', $request->user()->id)
                ->where('status', 'scheduled')
                ->whereDate('scheduled_time', $scheduledDate)
                ->count();

            if ($scheduledCount >= 10) {
                return $this->apiResponse(null, 422, 'You can only schedule up to 10 posts per day.');
            }
        }

        if ($request->has('platforms')) {
            $platforms = Platform::whereIn('id', $request->platforms)->get();
        } else {
            $platforms = $post->platforms;
        }

        foreach ($platforms as $platform) {
            if ($platform->name === 'Twitter' && strlen($content) > 280) {
                return $this->apiResponse(null, 422, 'Content exceeds Twitter limit (280 characters).');
            }
            if ($platform->name === 'LinkedIn' && strlen($content) > 1300) {
                return $this->apiResponse(null, 422, 'Content exceeds LinkedIn limit (1300 characters).');
            }
            if ($platform->name === 'Facebook' && strlen($content) > 5000) {
                return $this->apiResponse(null, 422, 'Content exceeds Facebook limit (5000 characters).');
            }
            if ($platform->name === 'Instagram' && strlen($content) > 2200) {
                return $this->apiResponse(null, 422, 'Content exceeds Instagram limit (2200 characters).');
            }
        }

        $post->fill($request->only(['title', 'content', 'scheduled_time', 'status']));

        if ($request->hasFile('image_url')) {
            $post->image_url = $request->file('image_url')->store('posts', 'public');
        }

        $post->save();

        if ($request->has('platforms')) {
            $post->platforms()->sync($request->platforms);
        }

        ActivityLogger::log(auth()->id(), 'Updated Post', 'User updated the post titled "' . $post->title . '"');

        return $this->apiResponse($post->load('platforms'), 200, 'Post updated successfully');
    }

    public function destroy(Post $post, Request $request)
    {
        if ($post->user_id !== $request->user()->id) {
            return $this->apiResponse(null, Response::HTTP_FORBIDDEN, 'Unauthorized');
        }

        $post->platforms()->detach();
        $post->delete();

        ActivityLogger::log(auth()->id(), 'Deleted Post', 'User deleted the post titled "' . $post->title . '"');

        return $this->apiResponse(null, Response::HTTP_OK, 'Post deleted successfully');
    }
}

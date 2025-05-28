<?php

namespace App\Http\Controllers\Api;

use App\ApiResponseTrait;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use App\Models\Platform;
use Illuminate\Http\Request;

class PlatformController extends Controller
{
    use ApiResponseTrait;
    public function index()
    {
        $platforms = Platform::select('id', 'name')->get();
        return $this->apiResponse($platforms, 200, 'Available platforms');
    }

    public function showActivePlatformsToUsaer(Request $request)
    {
        $user = $request->user();
        $activePlatforms = $user->activePlatforms()->select('id', 'name')->get();
        return $this->apiResponse($activePlatforms, 200, 'Active platforms');
    }

    public function toggleActivePlatform(Request $request)
    {
        $request->validate([
            'platform_id' => 'required|exists:platforms,id',
            'action' => 'required|in:attach,detach',
        ]);

        $user = $request->user();
        $platformId = $request->input('platform_id');
        $action = $request->input('action');

        if ($action === 'attach') {
            $user->activePlatforms()->syncWithoutDetaching([$platformId]);
        } else {
            $user->activePlatforms()->detach($platformId);
        }

        $activePlatforms = $user->activePlatforms()->pluck('id');
        return $this->apiResponse($activePlatforms, Response::HTTP_OK, 'Platform Status updated succesfully');
    }
}

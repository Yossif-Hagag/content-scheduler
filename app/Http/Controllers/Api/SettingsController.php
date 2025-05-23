<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Platform;

class SettingsController extends Controller
{
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

        return response()->json([
            'message' => 'Platform Status updated succesfully',
            'active_platforms' => $user->activePlatforms()->pluck('id'),
        ]);
    }
}
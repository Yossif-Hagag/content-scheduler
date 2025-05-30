<?php

namespace App\Services;

use App\Models\ActivityLog;

class ActivityLogger
{
    public static function log($userId, $action, $description = null)
    {
        ActivityLog::create([
            'user_id' => $userId,
            'action' => $action,
            'description' => $description,
        ]);
    }
}
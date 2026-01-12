<?php

namespace App\Services;

use App\Models\Activities;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ActivityLogger
{
    public static function log(string $action): void
    {
        if (!Auth::check()) {
            return;
        }

        $userId = Auth::id();
        $cacheKey = "activity_log_{$userId}_{$action}";

        if (Cache::has($cacheKey)) {
            return;
        }

        Cache::put($cacheKey, true, now()->addSeconds(3));

        Activities::create([
            'user_id' => $userId,
            'action'  => $action,
        ]);
    }
}

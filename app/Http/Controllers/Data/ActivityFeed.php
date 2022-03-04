<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class ActivityFeed extends Controller
{
    /**
     * Return the activity feed.
     */
    public function __invoke(): \Illuminate\Http\JsonResponse
    {
        // Get the cached activity feed
        $activity = Cache::get('github_activity_feed');

        // Get the cached insights feed
        $insights  = Cache::get('github_insights_languages');

        // Return available data
        return response()->json([
            'activity' => $activity,
            'insights' => $insights,
        ]);
    }
}

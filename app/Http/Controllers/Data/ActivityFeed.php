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
        // Get the cached GitHub response
        $item = Cache::get('github_activity_feed');

        if (empty($item) || $item === null) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to retrieve data.',
            ]);
        }

        return response()->json($item);
    }
}

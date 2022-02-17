<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ActivityFeed extends Controller
{
    public function __invoke()
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

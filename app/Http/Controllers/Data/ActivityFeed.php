<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class ActivityFeed extends Controller
{
    /**
     * @inheritDoc
     */
    public function __invoke(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'activity' => Cache::get('github_activity_feed'),
            'insights' => Cache::get('github_insights_languages'),
        ]);
    }
}

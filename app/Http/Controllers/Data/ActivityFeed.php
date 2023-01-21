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
            'activity' => Cache::get(\App\Console\Commands\Cache\ActivityFeed::CACHE_KEY),
            'insights' => Cache::get(\App\Console\Commands\Cache\Insights::CACHE_KEY),
        ]);
    }
}

<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;

class ActivityFeed extends Controller
{
    public function __construct(
        protected \App\Services\Data\ActivityFeedService $activityFeedService,
        protected \App\Services\Data\InsightsFeedService $insightsFeedService,
    ) {
    }

    /**
     * Return feed data
     */
    public function __invoke(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'activity' => $this->activityFeedService->getCached(),
            'insights' => $this->insightsFeedService->getCached(),
        ]);
    }
}

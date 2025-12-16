<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CacheActivityFeed extends Command
{
    /**
     * @inheritDoc
     */
    protected $signature = 'cache:activityfeed';

    /**
     * @inheritDoc
     */
    protected $description = 'Caches activity feed API requests to GitHub';

    /**
     * @inheritDoc
     */
    public function __construct(
        protected \App\Services\Data\ActivityFeedService $activityFeedService
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->activityFeedService->cache();

        return 0;
    }
}

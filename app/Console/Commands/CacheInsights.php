<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CacheInsights extends Command
{
    /**
     * @inheritDoc
     */
    protected $signature = 'cache:insights';

    /**
     * @inheritDoc
     */
    protected $description = 'Caches insights data from API requests to GitHub';

    /**
     * @inheritDoc
     */
    public function __construct(
        protected \App\Services\Data\InsightsFeedService $insightsFeedService
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->insightsFeedService->cache();

        return 0;
    }
}

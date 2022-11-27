<?php

namespace App\Console\Commands\Cache;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\{
    Cache,
    Http
};

class ActivityFeed extends Command
{
    public const CACHE_KEY = 'github_activity_feed';

    /**
     * @var string
     */
    protected $signature = 'cache:activityfeed';

    /**
     * @var string
     */
    protected $description = 'Caches activity feed API requests to GitHub';

    /**
     * @inheritDoc
     */
    public function handle(): int
    {
        // GitHub API response
        $response = Http::withHeaders(['content-type' => 'application/json'])
            ->get('https://api.github.com/search/commits?', [
                'q'        => 'author:gibbs is:public',
                'sort'     => 'author-date',
                'order'    => 'desc',
                'page'     => 1,
                'per_page' => 10,
            ])
            ->throw()
            ->json();

        $items = [];

        foreach($response['items'] as $item) {
            $items[] = [
                'author' => [
                    'avatar_url' => $item['author']['avatar_url'],
                    'login'      => $item['author']['login'],
                ],
                'commit' => [
                    'author'  => [
                        'date' => $item['commit']['author']['date'],
                    ],
                    'message' => $item['commit']['message'],
                    'url'     => $item['commit']['url'],
                ],
                'repository' => [
                    'name'     => $item['repository']['name'],
                    'html_url' => $item['repository']['html_url'],
                ],
                'html_url' => $item['html_url'],
                'sha' => $item['sha'],
            ];
        }

        // Cache the data
        if (isset($items)) {
            Cache::forever(self::CACHE_KEY, ['items' => $items]);
        }

        return 0;
    }
}

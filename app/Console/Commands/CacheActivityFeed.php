<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class CacheActivityFeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:activityfeed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Caches activity feed API requests to GitHub';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $url = 'https://api.github.com/search/commits?';
        $url_parameters = [
            'q'        => 'author:gibbs is:public',
            'sort'     => 'author-date',
            'order'    => 'desc',
            'page'     => 1,
            'per_page' => 10,
        ];

        // GitHub API response
        $response = Http::withHeaders(['content-type' => 'application/json'])
            ->get($url, $url_parameters)
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
            Cache::forever('github_activity_feed', ['items' => $items]);
        }

        return 0;
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class CacheInsights extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:insights';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Caches insights data from API requests to GitHub';

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
     */
    public function handle(): int
    {
        $url = 'https://api.github.com';

        // Repositories cache key
        $repositories_key = 'github_repositories';

        // Get repositories data
        if (!$repositories = Cache::get($repositories_key)) {
            $repositories = Http::withHeaders(['content-type' => 'application/json'])
                ->withBasicAuth(config('api.github_username'), config('api.github_access_token'))
                ->get(sprintf('%s/users/gibbs/repos', $url), [
                    'order'    => 'desc',
                    'page'     => 1,
                    'per_page' => 100,
                ])
                ->throw()
                ->json();

            // Cache response
            Cache::put($repositories_key, $repositories, now()->addDays(1));
        }

        $language_data = [];

        // Iterate repository data
        foreach($repositories as $repository) {
            if ($repository['fork']) {
                continue;
            }

            $language_key = sprintf('github_repository_languages_%s', $repository['full_name']);

            // Get language data from cache
            if (!$languages = Cache::get($language_key)) {
                $languages = Http::withHeaders(['content-type' => 'application/json'])
                    ->withBasicAuth(config('api.github_username'), config('api.github_access_token'))
                    ->get(sprintf('%s/repos/%s/languages', $url, $repository['full_name']))
                    ->throw()
                    ->json();

                Cache::put($language_key, $languages, now()->addDays(7));
            }

            // Create the language data
            foreach($languages as $language => $bytes) {
                if (!array_key_exists($language, $language_data)) {
                    $language_data[$language] = [
                        'name'  => $language,
                        'count' => 1,
                        'bytes' => $bytes,
                    ];

                    continue;
                }

                $language_data[$language]['count'] += 1;
                $language_data[$language]['bytes'] += $bytes;
            }
        }

        // Default sort by count
        uasort($language_data, function($x, $y) {
            return $y['count'] <=> $x['count'];
        });

        // Cache general data
        Cache::put('github_insights_languages', [
            'usage'     => $language_data,
            'languages' => array_keys($language_data),
        ], now()->addDays(1));

        return 0;
    }
}

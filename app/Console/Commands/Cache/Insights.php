<?php

namespace App\Console\Commands\Cache;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\{
    Cache,
    Http
};

class Insights extends Command
{
    public const CACHE_KEY = 'github_repositories';

    /**
     * @var string
     */
    protected $signature = 'cache:insights';

    /**
     * @var string
     */
    protected $description = 'Caches insights data from API requests to GitHub';

    /**
     * @inheritDoc
     */
    public function handle(): int
    {
        // Get repositories data
        $repositories = Http::withBasicAuth(config('api.github_username'), config('api.github_access_token'))
            ->get('https://api.github.com/users/gibbs/repos', [
                'order'    => 'desc',
                'page'     => 1,
                'per_page' => 100,
            ])
            ->throw()
            ->json();

        // Cache response
        Cache::forever(self::CACHE_KEY, $repositories);

        $language_data = [];

        foreach($repositories as $repository) {
            if ($repository['fork']) {
                continue;
            }

            $language_key = sprintf('github_repository_languages_%s', $repository['full_name']);

            // Get language data
            $languages = Http::withHeaders(['content-type' => 'application/json'])
                ->withBasicAuth(config('api.github_username'), config('api.github_access_token'))
                ->get(sprintf('https://api.github.com/repos/%s/languages', $repository['full_name']))
                ->throw()
                ->json();

            Cache::forever($language_key, $languages);

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
        Cache::forever('github_insights_languages', [
            'usage'     => $language_data,
            'languages' => array_keys($language_data),
        ]);

        return 0;
    }
}

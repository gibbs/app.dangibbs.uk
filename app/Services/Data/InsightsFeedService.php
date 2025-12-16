<?php

namespace App\Services\Data;

use App\Interfaces\Services\FeedServiceInterface;

class InsightsFeedService implements FeedServiceInterface
{
    public string $cacheKey = 'github_insights_languages';

    public function __construct(
        protected \Illuminate\Contracts\Cache\Repository $cache,
        protected \Illuminate\Http\Client\Factory $http,
        protected \Illuminate\Contracts\Config\Repository $config,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function cache(): void
    {
        $data = $this->getRaw();
        $languages = $this->getProcessed($data);

        if (isset($languages)) {
            $this->cache->forever($this->cacheKey, $languages);
        }
    }

    /**
     * @inheritDoc
     */
    public function getCached(): ?array
    {
        $cached = $this->cache->get($this->cacheKey);

        return is_array($cached) ? $cached : null;
    }

    /**
     * @inheritDoc
     */
    public function getRaw(): array
    {
        $user = $this->config->get('api.github_username');
        $pass = $this->config->get('api.github_access_token');

        $repositories = $this->http->withBasicAuth($user, $pass)
            ->get('https://api.github.com/users/gibbs/repos', [
                'order'    => 'desc',
                'page'     => 1,
                'per_page' => 100,
            ])
            ->throw()
            ->json();

        $languages = [];

        foreach ($repositories as $repository) {
            // Ignore forks
            if ($repository['fork']) {
                continue;
            }

            // Get the repository language data
            $languages[] = $this->http->withBasicAuth($user, $pass)
                ->withHeaders([
                    'content-type' => 'application/json',
                ])
                ->get(sprintf('https://api.github.com/repos/%s/languages', $repository['full_name']))
                ->throw()
                ->json();
        }

        return [
            'repositories' => $repositories,
            'languages' => $languages,
        ];
    }

    /**
     * Process data from feeds
     */
    public function getProcessed(array $data): array
    {
        $processed = [];

        foreach ($data['languages'] as $response) {
            foreach ($response as $language => $bytes) {
                if (!array_key_exists($language, $processed)) {
                    $processed[$language] = [
                        'name'  => $language,
                        'count' => 1,
                        'bytes' => $bytes,
                    ];

                    continue;
                }

                $processed[$language]['count'] += 1;
                $processed[$language]['bytes'] += $bytes;
            }
        }

        // Default sort by count
        uasort($processed, function($x, $y) {
            return $y['count'] <=> $x['count'];
        });

        return [
            'usage'     => $processed,
            'languages' => array_keys($processed),
        ];
    }
}

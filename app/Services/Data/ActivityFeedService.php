<?php

namespace App\Services\Data;

use App\Interfaces\Services\FeedServiceInterface;

class ActivityFeedService implements FeedServiceInterface
{
    public string $cacheKey = 'github_activity_feed';

    public function __construct(
        protected \Illuminate\Contracts\Cache\Repository $cache,
        protected \Illuminate\Http\Client\Factory $http
    ) {
    }

    /**
     * @inheritDoc
     */
    public function cache(): void
    {
        $data = $this->getRaw();
        $items = $this->getProcessed($data);

        if (isset($items)) {
            $this->cache->forever($this->cacheKey, [
                'items' => $items,
            ]);
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
        $response = $this->http->withHeaders([
                'content-type' => 'application/json',
            ])
            ->get('https://api.github.com/search/commits?', [
                'q'        => 'author:gibbs is:public',
                'sort'     => 'author-date',
                'order'    => 'desc',
                'page'     => 1,
                'per_page' => 10,
            ])
            ->throw()
            ->json();

        return $response;
    }

    /**
     * Processed data from feed JSON array
     */
    protected function getProcessed(array $data): array
    {
        $items = [];

        foreach($data['items'] as $item) {
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

        return $items;
    }
}

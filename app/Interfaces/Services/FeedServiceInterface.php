<?php

namespace App\Interfaces\Services;

interface FeedServiceInterface
{
    /**
     * The cache key
     */
    public string $cacheKey { get; }

    /**
     * Cache the feed
     */
    public function cache(): void;

    /**
     * Get a cached feed
     */
    public function getCached(): array|null;

    /**
     * Request and return a raw feed
     *
     * @throws \Illuminate\Http\Client\HttpClientException
     */
    public function getRaw(): array;
}

<?php

namespace App\Services\Tool;

class UuidService
{
    public function __construct(
        protected \Illuminate\Http\Client\Factory $http,
        protected \Illuminate\Contracts\Config\Repository $config
    ) {
    }

    /**
     * Generate a UUID.
     */
    public function generateUuid(array $data): array
    {
        // Create the request url
        $request_url = sprintf('%s/tools/uuidgen', $this->config->get('app.webhook_url'));

        // Service response
        $response = $this->http->withHeaders(['content-type' => 'application/json'])
            ->post($request_url, [
                'random' => (bool) $data['random'],
                'time'   => (bool) $data['time'],
            ])
            ->throw()
            ->json();

        return $response;
    }
}

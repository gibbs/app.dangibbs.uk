<?php

namespace App\Services\Tool;

class MkpasswdService
{
    public function __construct(
        protected \Illuminate\Http\Client\Factory $http,
        protected \Illuminate\Contracts\Config\Repository $config
    ) {
    }

    /**
     * Generate an encrypted password.
     */
    public function generatePassword(array $data): array
    {
        // Create the request url
        $request_url = sprintf('%s/tools/mkpasswd', $this->config->get('app.webhook_url'));

        // Service response
        $response = $this->http->withHeaders(['content-type' => 'application/json'])
            ->post($request_url, [
                'input'  => (string) $data['input'],
                'salt'   => (string) $data['salt'],
                'method' => (string) $data['method'],
                'rounds' => (int) $data['rounds'],
            ])
            ->throw()
            ->json();

        return $response;
    }
}

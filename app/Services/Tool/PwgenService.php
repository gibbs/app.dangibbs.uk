<?php

namespace App\Services\Tool;

class PwgenService
{
    public function __construct(
        protected \Illuminate\Http\Client\Factory $http,
        protected \Illuminate\Contracts\Config\Repository $config
    ) {
    }

    /**
     * Generate random passwords.
     */
    public function generatePasswords(array $data): array
    {
        // Create the request url
        $request_url = sprintf('%s/tools/pwgen', $this->config->get('app.webhook_url'));

        // Service response
        $response = $this->http->withHeaders(['content-type' => 'application/json'])
            ->post($request_url, [
                'no-numerals'   => (bool) $data['no-numerals'],
                'no-capitalize' => (bool) $data['no-capitalize'],
                'ambiguous'     => (bool) $data['ambiguous'],
                'capitalize'    => (bool) $data['capitalize'],
                'num-passwords' => (int) $data['num-passwords'],
                'numerals'      => (bool) $data['numerals'],
                'remove-chars'  => (string) $data['remove-chars'],
                'secure'        => (bool) $data['secure'],
                'no-vowels'     => (bool) $data['no-vowels'],
                'symbols'       => (bool) $data['symbols'],
                'length'        => (int) $data['length'],
            ])
            ->throw()
            ->json();

        return $response;
    }
}

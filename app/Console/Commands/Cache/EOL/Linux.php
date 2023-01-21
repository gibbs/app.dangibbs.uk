<?php

namespace App\Console\Commands\Cache\EOL;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\{
    Cache,
    Http
};
use DateTime;

class Linux extends Command
{
    /**
     * @var string
     */
    public const CACHE_KEY = 'eol_linux_data';

    /**
     * @var string
     */
    protected $signature = 'cache:eol-linux';

    /**
     * @var string
     */
    protected $description = 'Caches Linux EOL API requests';

    /**
     * @inheritDoc
     */
    public function handle(): int
    {
        $eolEndpoints = [
            'alma'   => 'almalinux',
            'alpine' => 'alpine',
            'centos' => 'centos',
            'debian' => 'debian',
            'kernel' => 'linux',
            'rocky'  => 'rocky-linux',
            'ubuntu' => 'ubuntu',
        ];

        $data = [];

        foreach ($eolEndpoints as $name => $endpoint) {
            $url = sprintf('%s/%s.json', 'https://endoflife.date/api/', $endpoint);

            $response = Http::withHeaders(['content-type' => 'application/json'])
                ->get($url)
                ->throw()
                ->json();

            // Set the respose data
            $data[$name] = $response;

            // This is an open API service. Limit the request rate
            sleep(2);
        }

        // Cache the data
        if (!empty($data)) {
            Cache::forever(self::CACHE_KEY, [
                'date'  => (new DateTime())->format(DateTime::ATOM),
                'items' => $data,
            ]);
        }

        return 0;
    }
}

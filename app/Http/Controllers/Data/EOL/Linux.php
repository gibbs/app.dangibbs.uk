<?php

namespace App\Http\Controllers\Data\EOL;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Http\Resources\EOL as Resource;

class Linux extends Controller
{
    /**
     * @inheritDoc
     */
    public function __invoke(Request $request): \Illuminate\Http\JsonResponse
    {
        $cache = Cache::get(\App\Console\Commands\Cache\EOL\Linux::CACHE_KEY);
        $items = $cache['items'];

        $resource = [
            'alma'   => new Resource\AlmaResource(collect($items['alma'])),
            'alpine' => new Resource\AlpineResource(collect($items['alpine'])),
            'centos' => new Resource\CentOSResource(collect($items['centos'])),
            'debian' => new Resource\DebianResource(collect($items['debian'])),
            'linux'  => new Resource\LinuxResource(collect($items['kernel'])),
            'rocky'  => new Resource\RockyResource(collect($items['rocky'])),
            'ubuntu' => new Resource\UbuntuResource(collect($items['ubuntu'])),
        ];

        return response()->json([
            'alma'   => $resource['alma']->toArray($request),
            'alpine' => $resource['alpine']->toArray($request),
            'centos' => $resource['centos']->toArray($request),
            'debian' => $resource['debian']->toArray($request),
            'linux'  => $resource['linux']->toArray($request),
            'rocky'  => $resource['rocky']->toArray($request),
            'ubuntu' => $resource['ubuntu']->toArray($request),
        ]);
    }
}

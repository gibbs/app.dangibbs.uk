<?php

namespace App\Http\Controllers\Tool;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tool\UuidRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;

class Uuid extends Controller
{
    /**
     * Return a UUID generated from a webhook.
     */
    public function __invoke(UuidRequest $request): JsonResponse
    {
        // Create the webhook request url
        $request_url = sprintf('%s/tools/uuidgen', env('WEBHOOK_URL'));

        // Webhook response
        $response = Http::withHeaders(['content-type' => 'application/json'])
            ->post($request_url, [
                'random' => (bool) $request->get('random'),
                'time'   => (bool) $request->get('time'),
            ])
            ->throw()
            ->json();

        return response()->json($response);
    }
}

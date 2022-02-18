<?php

namespace App\Http\Controllers\Tool;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tool\UuidRequest;
use Illuminate\Support\Facades\Http;

class Uuid extends Controller
{
    /**
     * Return a UUID generated from a webhook.
     */
    public function __invoke(UuidRequest $request): \Illuminate\Http\JsonResponse
    {
        // Create the webhook request url
        $request_url = sprintf('%s/hooks/uuidgen?token=%s', env('WEBHOOK_URL'), env('WEBHOOK_TOKEN'));

        // Webhook response
        $response = Http::withHeaders(['content-type' => 'application/json'])
            ->post($request_url, [
                'random' => $request->get('random') ?? false,
                'time' => $request->get('time') ?? false,
            ])
            ->throw()
            ->json();

        return response()->json($response);
    }
}

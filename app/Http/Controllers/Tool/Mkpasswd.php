<?php

namespace App\Http\Controllers\Tool;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tool\MkpasswdRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;

class Mkpasswd extends Controller
{
    /**
     * Return an encrypted password returned via a service URL
     */
    public function __invoke(MkpasswdRequest $request): JsonResponse
    {
        // Create the request url
        $request_url = sprintf('%s/tools/mkpasswd', config('app.webhook_url'));

        // Service response
        $response = Http::withHeaders(['content-type' => 'application/json'])
            ->post($request_url, [
                'input'  => (string) $request->get('input'),
                'salt'   => (string) $request->get('salt'),
                'method' => (string) $request->get('method'),
                'rounds' => (int) $request->get('rounds'),
            ])
            ->throw()
            ->json();

        return response()->json($response);
    }
}

<?php

namespace App\Http\Controllers\Tool;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tool\PwgenRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;

class Pwgen extends Controller
{
    /**
     * Return randomly generated passwords from a service
     */
    public function __invoke(PwgenRequest $request): JsonResponse
    {
        // Create the request url
        $request_url = sprintf('%s/tools/pwgen', config('app.webhook_url'));

        // Service response
        $response = Http::withHeaders(['content-type' => 'application/json'])
            ->post($request_url, [
                'no-numerals'   => (bool) $request->get('no-numerals'),
                'no-capitalize' => (bool) $request->get('no-capitalize'),
                'ambiguous'     => (bool) $request->get('ambiguous'),
                'capitalize'    => (bool) $request->get('capitalize'),
                'num-passwords' => (int) $request->get('num-passwords'),
                'numerals'      => (bool) $request->get('numerals'),
                'remove-chars'  => (string) $request->get('remove-chars'),
                'secure'        => (bool) $request->get('secure'),
                'no-vowels'     => (bool) $request->get('no-vowels'),
                'symbols'       => (bool) $request->get('symbols'),
                'length'        => (int) $request->get('length') ?? 16,
            ])
            ->throw()
            ->json();

        return response()->json($response);
    }
}

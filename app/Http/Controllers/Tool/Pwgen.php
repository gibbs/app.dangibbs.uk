<?php

namespace App\Http\Controllers\Tool;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tool\PwgenRequest;
use Illuminate\Http\JsonResponse;

class Pwgen extends Controller
{
    public function __construct(
        protected \App\Services\Tool\PwgenService $pwgenService
    ) {
    }

    /**
     * Return generated password
     */
    public function __invoke(PwgenRequest $request): JsonResponse
    {
        $data = $this->pwgenService->generatePasswords([
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
        ]);

        return response()->json($data);
    }
}

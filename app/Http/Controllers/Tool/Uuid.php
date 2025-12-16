<?php

namespace App\Http\Controllers\Tool;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tool\UuidRequest;
use Illuminate\Http\JsonResponse;

class Uuid extends Controller
{
    public function __construct(
        protected \App\Services\Tool\UuidService $uuidService
    ) {
    }

    /**
     * Return a generated UUID
     */
    public function __invoke(UuidRequest $request): JsonResponse
    {
        $data = $this->uuidService->generateUuid([
            'random' => (bool) $request->get('random'),
            'time'   => (bool) $request->get('time'),
        ]);

        return response()->json($data);
    }
}

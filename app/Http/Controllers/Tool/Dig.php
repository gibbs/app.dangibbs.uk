<?php

namespace App\Http\Controllers\Tool;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tool\DigRequest;
use Illuminate\Http\JsonResponse;

class Dig extends Controller
{
    public function __construct(
        protected \App\Services\Tool\DigService $digService
    ) {
    }

    /**
     * Return dig request data
     */
    public function __invoke(DigRequest $request): JsonResponse
    {
        $data = $this->digService->performDig([
            'name'       => (string) $request->get('name'),
            'nameserver' => (string) $request->get('nameserver'),
            'types'      => $request->get('types'),
        ]);

        return response()->json($data);
    }
}

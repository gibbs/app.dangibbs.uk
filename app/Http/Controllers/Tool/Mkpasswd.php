<?php

namespace App\Http\Controllers\Tool;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tool\MkpasswdRequest;
use Illuminate\Http\JsonResponse;

class Mkpasswd extends Controller
{
    public function __construct(
        protected \App\Services\Tool\MkpasswdService $mkpasswdService
    ) {
    }

    /**
     * Return generated mkpasswd
     */
    public function __invoke(MkpasswdRequest $request): JsonResponse
    {
        $data = $this->mkpasswdService->generatePassword([
            'input'  => (string) $request->get('input'),
            'salt'   => (string) $request->get('salt'),
            'method' => (string) $request->get('method'),
            'rounds' => (int) $request->get('rounds'),
        ]);

        return response()->json($data);
    }
}

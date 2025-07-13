<?php

namespace App\Modules\Shared\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class Controller
{
    protected function response($data, int $status = 200): JsonResponse
    {
        return response()->json($data, $status);
    }
}

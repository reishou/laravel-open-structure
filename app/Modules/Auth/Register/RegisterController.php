<?php

namespace App\Modules\Auth\Register;

use App\Infrastructure\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $dto = $request->dto();

        return response()->json([$dto]);
    }
}

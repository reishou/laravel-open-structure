<?php

namespace App\Modules\Auth\Register;

use App\Infrastructure\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request): RegisterResource
    {
        $dto = $request->dto();

        return new RegisterResource($dto->toArray());
    }
}

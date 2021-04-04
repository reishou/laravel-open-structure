<?php

namespace App\Modules\Auth\Register;

use App\Infrastructure\Http\Controllers\Controller;

class RegisterController extends Controller
{
    /**
     * @var RegisterCommandHandler
     */
    private RegisterCommandHandler $commandHandler;

    public function __construct(RegisterCommandHandler $commandHandler)
    {
        $this->commandHandler = $commandHandler;
    }

    public function __invoke(RegisterRequest $request): RegisterResource
    {
        $dto = $request->dto();

        $this->commandHandler->handle($dto);

        return new RegisterResource($dto->toArray());
    }
}

<?php

namespace App\Modules\Auth\Register;

use App\Core\Events\Registered;
use App\Core\Models\User;
use Illuminate\Events\Dispatcher;

class RegisterCommandHandler
{
    /**
     * @var Dispatcher
     */
    private Dispatcher $dispatcher;

    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function handle(RegisterDTO $dto)
    {
        $user = User::create($dto->toArray());

        $this->dispatcher->dispatch(new Registered($user->id, $dto->getEmail()));
    }
}

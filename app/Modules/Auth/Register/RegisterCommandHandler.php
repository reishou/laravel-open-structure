<?php

namespace App\Modules\Auth\Register;

use App\Infrastructure\CommandHandlers\CommandHandler;

class RegisterCommandHandler extends CommandHandler
{
    /**
     * @var RegisterDTO
     */
    private RegisterDTO $dto;

    public function __construct(RegisterDTO $dto)
    {
        $this->dto = $dto;
    }

    public function handler()
    {

    }
}

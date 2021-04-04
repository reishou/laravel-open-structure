<?php

namespace App\Core\Events;

class Registered
{
    private int $userId;
    private string $email;

    public function __construct(int $userId, string $email)
    {
        $this->userId = $userId;
        $this->email  = $email;
    }
}

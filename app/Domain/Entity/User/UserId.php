<?php

namespace App\Domain\Entity\User;

class UserId
{
    private string $value;

    public function __construct(string $uuid)
    {
        $this->value = $uuid;
    }

    public function value(): string
    {
        return $this->value;
    }
}

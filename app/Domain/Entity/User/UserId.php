<?php

namespace App\Domain\Entity\User;

use App\Exceptions\DomainException;

class UserId
{
    private string $value;

    public function __construct(string $uuid)
    {
        if (is_null($uuid)) {
            throw new DomainException("user_id", "user_id is required");
        }
        $this->value = $uuid;
    }

    public function value(): string
    {
        return $this->value;
    }
}

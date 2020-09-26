<?php

namespace App\Domain\Entity\User;

class UserEmail
{
    private string $value;
    public function __construct(String $email)
    {
        $this->value = $email; //DomainServiceをつかってEmailの重複Validation
    }

    public function value(): string
    {
        return $this->value;
    }
}

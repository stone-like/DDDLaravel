<?php

namespace App\Domain\Entity\User;

use App\Exceptions\DomainException;



class UserName
{
    private string $value;

    public function __construct(string $name)
    {
        if (is_null($name)) {
            throw new DomainException("name", "name is required");
        }
        //もしかしたらspecificationPatternのがいいかも？
        if (strlen($name) < 3 || strlen($name) > 15) {
            throw new DomainException("name", "name is between 3~15 characters");
        }

        $this->value = $name;
    }

    public function value(): string
    {
        return $this->value;
    }
}

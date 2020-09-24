<?php

namespace App\Domain\Entity\User;

use App\Domain\Entity\User\UserId;
use App\Exceptions\DomainException;
use App\Domain\Entity\User\UserName;


class User
{
    private UserId $id;
    private UserName $name;


    public function __construct(UserId $id, UserName $name)
    {

        $this->id = $id;
        $this->name = $name;
    }

    public function changeUserName(UserName $name): void
    {
        $this->name = $name;
    }

    public function equals(User $user): bool
    {
        return $this->id->value() === $user->id->value();
    }

    public function Id(): string
    {
        return $this->id->value();
    }

    public function Name(): string
    {
        return $this->name->value();
    }
}

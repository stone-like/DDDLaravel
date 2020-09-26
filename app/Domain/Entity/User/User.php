<?php

namespace App\Domain\Entity\User;

use App\Domain\Entity\User\UserId;
use App\Exceptions\DomainException;
use App\Domain\Entity\User\UserName;


class User
{
    private UserId $id;
    private UserName $name;
    private UserEmail $email;
    private UserPassword $password;

    private function __construct()
    {
    }

    public static function New(UserId $id, UserName $name, UserEmail $email, UserPassword $password)
    {
        $instance = new self();
        $instance->id  = $id;
        $instance->name = $name;
        $instance->email = $email;
        $instance->password = $password;
        return $instance;
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

    public function Email(): string
    {
        return $this->email->value();
    }
    public function Password(): string
    {
        return $this->password->value();
    }
}

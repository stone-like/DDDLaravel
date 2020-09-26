<?php

namespace App\Domain\Entity\User;

use App\Exceptions\DomainException;

class UserPassword
{
    private string $value;
    private function __construct()
    {
    }

    public static function New(string $password, string $password_confirmation)
    {

        if (is_null($password)) {
            throw new DomainException("password", "password is required");
        }
        if (is_null($password_confirmation)) {
            throw new DomainException("password", "password_confirmation is required");
        }
        if (strlen($password)  < 8 || strlen($password) > 20) {
            throw new DomainException("password", "password is between 8 and 20 charactors");
        }
        if ($password !== $password_confirmation) {
            throw new DomainException("password", "password = password_confirmarion is required");
        }

        $instance = new self();
        $instance->value = password_hash($password, PASSWORD_BCRYPT);
        return $instance;
    }
    public static function FromRepository(string $bcryptedPassword)
    {
        $instance = new self();
        $instance->value = $bcryptedPassword;
        return $instance;
    }
    public function value(): string
    {
        return $this->value;
    }
}

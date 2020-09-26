<?php

namespace Tests\Unit;

use App\Domain\Entity\User\UserPassword;
use App\Exceptions\DomainException;
use Tests\TestCase;


class UserPasswordTest extends TestCase
{
    /** @test */
    public function can_create_password()
    {
        $password = UserPassword::New("password", "password");
        $this->assertTrue(password_verify("password", $password->value()));
    }
    /** @test */
    public function can_create_from_repository()
    {
        $hash = password_hash("password", PASSWORD_BCRYPT);
        $password = UserPassword::FromRepository($hash);
        $this->assertTrue(password_verify("password", $password->value()));
    }
    /** @test */
    public function error_when_password_under_8()
    {
        $this->expectException(DomainException::class);
        $password = UserPassword::New("pass", "pass");
    }
    /** @test */
    public function error_when_password_over_20()
    {
        $this->expectException(DomainException::class);
        $password = UserPassword::New("passwordpasswordpasswordpassword", "passwordpasswordpasswordpassword");
    }
    /** @test */
    public function error_when_password_is_not_equal_password_confirmation()
    {
        $this->expectException(DomainException::class);
        $password = UserPassword::New("passwordpasswordpasswordpassword", "passwordpasswordpasswordpasswor");
    }
}

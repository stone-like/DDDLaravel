<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Domain\Entity\User\User;
use App\Domain\Entity\User\UserId;
use App\Domain\Entity\User\UserName;
use App\Domain\Entity\User\UserEmail;
use App\Domain\Entity\User\UserPassword;



class UserEntityTest extends TestCase
{
    /** @test */
    public function can_make_user_entity()
    {
        $user = User::New(new UserId("aaa"), new UserName("bbb"), new UserEmail("test"), UserPassword::New("password", "password"));
        $this->assertEquals("aaa", $user->Id());
        $this->assertEquals("bbb", $user->Name());
        $this->assertEquals("test", $user->Email());
        $this->assertTrue(password_verify("password", $user->Password()));
    }
}

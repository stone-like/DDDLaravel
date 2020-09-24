<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Domain\Entity\User\User;
use App\Domain\Entity\User\UserId;
use App\Domain\Entity\User\UserName;



class UserEntityTest extends TestCase
{
    /** @test */
    public function can_make_user_entity()
    {
        $user = new User(new UserId("aaa"), new UserName("bbb"));
        $this->assertEquals("aaa", $user->Id());
        $this->assertEquals("bbb", $user->Name());
    }
}

<?php

namespace Tests\Unit;

use App\Domain\Entity\User\UserId;
use Tests\TestCase;


class UserIdTest extends TestCase
{
    /** @test */
    public function can_create_Id()
    {
        $userId = new UserId("aaa");
        $this->assertEquals("aaa", $userId->value());
    }
}

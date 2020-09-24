<?php

namespace Tests\Unit;

use App\Domain\Entity\User\UserName;
use App\Exceptions\DomainException;
use Tests\TestCase;


class UserNameTest extends TestCase
{
    /** @test */
    public function can_create_name()
    {
        $name = new UserName("aaa");
        $this->assertEquals("aaa", $name->value());
    }

    /** @test */
    public function error_when_name_is_under_3()
    {
        $this->expectException(DomainException::class);
        new UserName("aa");
    }
    /** @test */
    public function error_when_name_is_over_15()
    {
        $this->expectException(DomainException::class);
        new UserName("aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa");
    }
}

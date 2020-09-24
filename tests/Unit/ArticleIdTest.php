<?php

namespace Tests\Unit;

use App\Domain\Entity\Article\ArticleId;
use Tests\TestCase;


class ArticleIdTest extends TestCase
{
    /** @test */
    public function can_create_id()
    {
        $id = new ArticleId("aaa");
        $this->assertEquals("aaa", $id->value());
    }
}

<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Domain\Entity\Article\ArticleTitle;
use App\Exceptions\DomainException;

class ArticleTitleTest extends TestCase
{
    /** @test */
    public function can_create_title()
    {
        $title = new ArticleTitle("aaa");
        $this->assertEquals("aaa", $title->value());
    }


    /** @test */
    public function error_when_title_is_under_2()
    {
        $this->expectException(DomainException::class);
        new ArticleTitle("a");
    }

    /** @test */
    public function error_when_title_is_over_15()
    {
        $this->expectException(DomainException::class);
        new ArticleTitle("aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa");
    }
}

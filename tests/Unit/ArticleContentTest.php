<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Domain\Entity\Article\ArticleContent;


class ArticleContentTest extends TestCase
{
    /** @test */
    public function can_create_content()
    {
        $content = new ArticleContent("aaa");
        $this->assertEquals("aaa", $content->value());
    }
}

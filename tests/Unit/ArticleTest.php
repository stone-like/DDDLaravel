<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Domain\Entity\User\UserId;
use App\Domain\Entity\Article\Article;
use App\Domain\Entity\Article\ArticleId;
use App\Domain\Entity\Article\ArticleTitle;
use App\Domain\Entity\Article\ArticleContent;

class ArticleTest extends TestCase
{
    /** @test */
    public function can_create_article()
    {
        $article = new Article(new ArticleId("aaa"), new ArticleTitle("bbb"), new ArticleContent("ccc"), new UserId("xxx"));
        $this->assertEquals("aaa", $article->Id());
        $this->assertEquals("bbb", $article->Title());
        $this->assertEquals("ccc", $article->Content());
    }
}

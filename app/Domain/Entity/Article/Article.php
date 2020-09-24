<?php

namespace App\Domain\Entity\Article;

use App\Domain\Entity\Article\ArticleId;
use App\Domain\Entity\Article\ArticleTitle;
use App\Domain\Entity\Article\ArticleContent;
use App\Domain\Entity\User\UserId;

class Article
{
    private ArticleId $id;
    private ArticleTitle $title;
    private ArticleContent $content;
    private UserId $user_id;

    public function __construct(ArticleId $id, ArticleTitle $title, ArticleContent $content, UserId $user_id)
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->user_id = $user_id;
    }

    public function Id(): string
    {
        return $this->id->value();
    }
    public function Title(): string
    {
        return $this->title->value();
    }
    public function Content(): string
    {
        return $this->content->value();
    }
    public function AuthorId(): string
    {
        return $this->user_id->value();
    }
}

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

    private function __construct()
    {
    }

    public static function New(ArticleId $id, ArticleTitle $title, ArticleContent $content, UserId $user_id)
    {
        $instance = new self();
        $instance->id = $id;
        $instance->title = $title;
        $instance->content = $content;
        $instance->user_id = $user_id;
        return $instance;
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
    public function isAuthor(UserId $user_id): bool
    {
        return $this->user_id->value() === $user_id->value();
    }
}

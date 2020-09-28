<?php

namespace App\Infrastructure\QueryService\Article\DTO;



class ArticleDTO
{
    private string $article_id;
    private string $title;
    private string $content;
    private int $likeCount;
    private string $username;
    private string $user_id;

    public function __construct(string $article_id, string $title, string $content, int $likeCount, string $username, string $user_id)
    {
        $this->article_id = $article_id;
        $this->title = $title;
        $this->content = $content;
        $this->likeCount = $likeCount;
        $this->username = $username;
        $this->user_id = $user_id;
    }

    public function ArticleId(): string
    {
        return $this->article_id;
    }
    public function Title(): string
    {
        return $this->title;
    }
    public function Content(): string
    {
        return $this->content;
    }
    public function likeCount(): string
    {
        return $this->likeCount;
    }
    public function UserName(): string
    {
        return $this->username;
    }
    public function UserId(): string
    {
        return $this->user_id;
    }
}

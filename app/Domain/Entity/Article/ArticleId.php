<?php

namespace App\Domain\Entity\Article;

use App\Exceptions\DomainException;


class ArticleId
{
    private string $value;

    public function __construct(string $uuid)
    {
        if (is_null($uuid)) {
            throw new DomainException("article_id", "article_id is required");
        }
        $this->value = $uuid;
    }

    public function value(): string
    {
        return $this->value;
    }
}

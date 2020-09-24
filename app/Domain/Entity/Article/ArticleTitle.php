<?php

namespace App\Domain\Entity\Article;

use App\Exceptions\DomainException;

class ArticleTitle
{
    private string $value;

    public function __construct(string $title)
    {
        if (is_null($title)) {
            throw new DomainException("title", "title is required");
        }

        if (strlen($title) < 2 || strlen($title) > 15) {
            throw new DomainException("title", "title is between 2~15");
        }
        $this->value = $title;
    }

    public function value(): string
    {
        return $this->value;
    }
}

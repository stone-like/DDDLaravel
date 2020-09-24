<?php

namespace App\Domain\Entity\Article;

use App\Exceptions\DomainException;

class ArticleContent
{
    private string $value;

    public function __construct(string $content)
    {
        if (is_null($content)) {
            throw new DomainException("content", "content is required");
        }

        $this->value = $content;
    }

    public function value(): string
    {
        return $this->value;
    }
}

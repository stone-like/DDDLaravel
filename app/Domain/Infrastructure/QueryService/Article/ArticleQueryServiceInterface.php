<?php

namespace App\Domain\Infrastructure\QueryService\Article;

use Illuminate\Support\Collection;

interface ArticleQueryServiceInterface
{
    public function getAllList(): Collection;
}

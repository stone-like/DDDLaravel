<?php

namespace App\Domain\Service\Article;

use App\Domain\Entity\Article\ArticleId;
use App\Domain\Infrastructure\Repository\Article\ArticleRepositoryInterface;

class ArticleService
{
    private $articleRepo;
    public function __construct(ArticleRepositoryInterface $articleRepo)
    {
        $this->articleRepo = $articleRepo;
    }

    public function isExists(ArticleId $article_id): bool
    {
        $article = $this->articleRepo->findById($article_id);

        return $article !== null;
    }
}

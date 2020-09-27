<?php

namespace App\Usecase\Article;

use App\Domain\Entity\Article\Article;
use App\Domain\Entity\Article\ArticleId;
use App\Domain\Service\Article\ArticleService;
use App\Domain\Infrastructure\Repository\Article\ArticleRepositoryInterface;

class FindArticleByIdUseCase
{
    private $articleRepo;
    private $articleService;

    public function __construct(ArticleRepositoryInterface $articleRepo, ArticleService $articleService)
    {
        $this->articleRepo = $articleRepo;
        $this->articleService = $articleService;
    }

    public function execute(string $id): ?Article
    {
        $article_id = new ArticleId($id);
        return $this->articleRepo->findById($article_id);
    }
}

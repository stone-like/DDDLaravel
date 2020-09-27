<?php

namespace App\Usecase\Article;

use App\Exceptions\UseCaseException;
use App\Domain\Entity\Article\ArticleId;
use App\Domain\Service\Article\ArticleService;
use App\Domain\Infrastructure\Repository\Article\ArticleRepositoryInterface;

class DeleteArticleUseCase
{
    private $articleRepo;
    private $articleService;

    public function __construct(ArticleRepositoryInterface $articleRepo, ArticleService $articleService)
    {
        $this->articleRepo = $articleRepo;
        $this->articleService = $articleService;
    }

    public function execute(string $article_id): void
    {
        if (!$this->articleService->isExists(new ArticleId($article_id))) {
            throw new UseCaseException("article_id", "this article_id is invalid");
        };

        $this->articleRepo->deleteArticle(new ArticleId($article_id));
    }
}

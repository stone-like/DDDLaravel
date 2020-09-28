<?php

namespace App\Usecase\Article;

use App\Domain\Entity\User\UserId;
use App\Exceptions\UseCaseException;
use App\Domain\Entity\Article\Article;
use App\Domain\Entity\Article\ArticleId;
use App\Domain\Service\User\UserService;
use App\Domain\Entity\Article\ArticleTitle;
use App\Domain\Entity\Article\ArticleContent;
use App\Domain\Service\Article\ArticleService;
use App\Infrastructure\Repository\Article\ArticleRepositoryInterface;

class UpdateArticleUseCase
{
    private $articleRepo;
    private $userService;
    private $articleService;

    public function __construct(ArticleRepositoryInterface $articleRepo, UserService $userService, ArticleService $articleService)
    {
        $this->articleRepo = $articleRepo;
        $this->userService = $userService;
        $this->articleService = $articleService;
    }

    public function execute(string $article_id = null, string $title, string $content, string $user_id): void
    {
        if (!$this->userService->isExists(new UserId($user_id))) {
            throw new UseCaseException("user_id", "this user_id is invalid");
        };
        if (!$this->articleService->isExists(new ArticleId($article_id))) {
            throw new UseCaseException("article_id", "this article_id is invalid");
        };

        $article = Article::New(new ArticleId($article_id), new ArticleTitle($title), new ArticleContent($content), new UserId($user_id));

        $this->articleRepo->updateArticle($article);
    }
}

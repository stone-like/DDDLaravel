<?php

namespace App\Usecase\Article;

use Ramsey\Uuid\Uuid;
use App\Domain\Entity\User\UserId;
use App\Exceptions\UseCaseException;
use App\Domain\Entity\Article\Article;
use App\Domain\Entity\Article\ArticleId;
use App\Domain\Service\User\UserService;
use App\Domain\Entity\Article\ArticleTitle;
use App\Domain\Entity\Article\ArticleContent;
use App\Infrastructure\Repository\User\UserRepositoryInterface;
use App\Infrastructure\Repository\Article\ArticleRepositoryInterface;

class CreateArticleUseCase
{
    private $articleRepo;
    private $userService;

    public function __construct(ArticleRepositoryInterface $articleRepo, UserService $userService)
    {
        $this->articleRepo = $articleRepo;
        $this->userService = $userService;
    }

    public function execute(string $article_id = null, string $title, string $content, string $user_id): void
    {
        $uuid = $article_id ?? Uuid::uuid4()->toString();

        //userIdのvalidation
        if (!$this->userService->isExists(new UserId($user_id))) {
            throw new UseCaseException("user_id", "this user_id is invalid");
        };

        $article = Article::New(new ArticleId($uuid), new ArticleTitle($title), new ArticleContent($content), new UserId($user_id));

        $this->articleRepo->createArticle($article);
    }
}

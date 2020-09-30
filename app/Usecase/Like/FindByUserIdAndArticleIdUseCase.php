<?php

namespace App\Usecase\Like;

use App\Domain\Entity\Like\Like;
use App\Domain\Entity\User\UserId;
use App\Exceptions\UseCaseException;
use App\Domain\Entity\Article\ArticleId;
use App\Domain\Service\User\UserService;
use App\Domain\Service\Article\ArticleService;
use App\Infrastructure\Repository\Like\LikeRepositoryInterface;

class FindByUserIdAndArticleIdUseCase
{
    private $likeRepo;
    private $articleService;
    private $userService;

    public function __construct(LikeRepositoryInterface $likeRepo, ArticleService $articleService, UserService $userService)
    {
        $this->likeRepo = $likeRepo;
        $this->articleService = $articleService;
        $this->userService = $userService;
    }
    public function execute(string $userId, string $articleId): ?Like
    {
        if (!$this->articleService->isExists(new ArticleId($articleId))) {
            throw new UseCaseException("article_id", "this article_id is invalid");
        }
        if (!$this->userService->isExists(new UserId($userId))) {
            throw new UseCaseException("user_id", "this user_id is invalid");
        }

        return $this->likeRepo->findByUserIdAndArticleId(new UserId($userId), new ArticleId($articleId));
    }
}

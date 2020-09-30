<?php

namespace App\Usecase\Like;

use Ramsey\Uuid\Uuid;
use App\Domain\Entity\Like\Like;
use App\Domain\Entity\Like\LikeId;
use App\Domain\Entity\User\UserId;
use App\Exceptions\UseCaseException;
use App\Domain\Entity\Article\Article;
use App\Domain\Entity\Article\ArticleId;
use App\Domain\Service\User\UserService;
use App\Domain\Entity\Article\ArticleTitle;
use App\Domain\Entity\Article\ArticleContent;
use App\Domain\Service\Article\ArticleService;
use App\Infrastructure\Repository\Like\LikeRepositoryInterface;

class CreateLikeUseCase
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

    //引数が多いのでbuilderパターンかも、ただUseCaseの一つだけbuilderにしてもいいのか、それとも統一した方がいいのか
    public function execute(string $likeId = null, string $articleId, string $articleContent, string $articleTitle, string $articleAuthorId, string $userId)
    {
        $likeId = $likeId ?? Uuid::uuid4()->toString();

        if (!$this->articleService->isExists(new ArticleId($articleId))) {
            throw new UseCaseException("article_id", "this article_id is invalid");
        }
        if (!$this->userService->isExists(new UserId($userId))) {
            throw new UseCaseException("user_id", "this user_id is invalid");
        }
        $article = Article::New(new ArticleId($articleId), new ArticleTitle($articleTitle), new ArticleContent($articleContent), new UserId($articleAuthorId));

        $like = Like::New($article, new UserId($userId), new LikeId($likeId));
        $this->likeRepo->createLike($like);
    }
}

<?php

namespace App\Usecase\Like;

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
use App\Domain\Service\Like\LikeService;
use App\Infrastructure\Repository\Like\LikeRepositoryInterface;

class DeleteLikeUseCase
{
    private $likeRepo;
    private $articleService;
    private $userService;

    public function __construct(LikeRepositoryInterface $likeRepo, ArticleService $articleService, UserService $userService, LikeService $likeService)
    {
        $this->likeRepo = $likeRepo;
        $this->articleService = $articleService;
        $this->userService = $userService;
        $this->likeService = $likeService;
    }

    //引数が多いのでbuilderパターンかも、ただUseCaseの一つだけbuilderにしてもいいのか、それとも統一した方がいいのか
    public function execute(string $likeId)
    {
        if (!$this->likeService->isExists(new LikeId($likeId))) {
            throw new UseCaseException("like_id", "this like_id is invalid");
        }

        $this->likeRepo->deleteLike(new LikeId($likeId));
    }
}

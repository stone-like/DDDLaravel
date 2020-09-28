<?php

namespace App\Infrastructure\Repository\Like;

use App\Domain\Entity\Like\Like as LikeEntity;
use App\Domain\Entity\Like\LikeId;
use App\Domain\Entity\User\UserId;
use App\Domain\Entity\Article\ArticleId;

interface LikeRepositoryInterface
{
    public function findById(LikeId $id): ?LikeEntity;
    public function findByUserIdAndArticleId(UserId $user_id, ArticleId $article_id): ?LikeEntity;
    public function createLike(LikeEntity $like): void;
    public function deleteLike(LikeId $id): void;
}

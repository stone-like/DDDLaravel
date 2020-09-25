<?php

namespace App\Domain\Infrastructure\Repository\Like;

use App\Domain\Entity\Like\Like;
use App\Domain\Entity\Like\LikeId;

interface LikeRepositoryInterface
{
    public function createLike(Like $like): void;
    public function deleteLike(LikeId $id): void;
}

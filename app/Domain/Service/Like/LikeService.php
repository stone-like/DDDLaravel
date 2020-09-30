<?php

namespace App\Domain\Service\Like;

use App\Domain\Entity\Like\LikeId;
use App\Infrastructure\Repository\Like\LikeRepositoryInterface;

class LikeService
{

    private $likeRepo;
    public function __construct(LikeRepositoryInterface $likeRepo)
    {
        $this->likeRepo = $likeRepo;
    }

    public function isExists(LikeId $like_id): bool
    {
        $like = $this->likeRepo->findById($like_id);

        return $like !== null;
    }
}

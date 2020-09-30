<?php

namespace App\Usecase\Like;

use App\Domain\Entity\Like\Like;
use App\Domain\Entity\Like\LikeId;
use App\Infrastructure\Repository\Like\LikeRepositoryInterface;

class FindLikeByIdUseCase
{
    private $likeRepo;
    public function __construct(LikeRepositoryInterface $likeRepo)
    {
        $this->likeRepo = $likeRepo;
    }

    public function execute(string $id): ?Like
    {
        $like_id = new LikeId($id);
        return $this->likeRepo->findById($like_id);
    }
}

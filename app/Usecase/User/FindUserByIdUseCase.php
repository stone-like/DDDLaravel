<?php

namespace App\Usecase\User;

use App\Domain\Entity\User\User;
use App\Domain\Entity\User\UserId;
use App\Infrastructure\Repository\User\UserRepositoryInterface;

class FindUserByIdUseCase
{
    private $userRepo;
    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function execute(string $id): ?User
    {
        $user_id = new UserId($id);
        return $this->userRepo->findById($user_id);
    }
}

<?php

namespace App\Usecase\User;

use App\Domain\Entity\User\UserId;
use App\Domain\Infrastructure\Repository\User\UserRepositoryInterface;
use App\Domain\Service\User\UserService;
use App\Exceptions\UseCaseException;

class DeleteUserUseCase
{
    private $userRepo;
    private $userService;
    public function __construct(UserRepositoryInterface $userRepo, UserService $userService)
    {
        $this->userRepo = $userRepo;
        $this->userService = $userService;
    }

    public function execute(string $id): void
    {
        $user_id = new UserId($id);
        if (!$this->userService->isExists($user_id)) {
            throw new UseCaseException("user_id", "this user_id is invalid");
        }

        $this->userRepo->deleteUser($user_id);
    }
}

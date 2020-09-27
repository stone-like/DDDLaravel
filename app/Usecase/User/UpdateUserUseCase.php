<?php

namespace App\Usecase\User;

use App\Domain\Entity\User\User;
use App\Domain\Entity\User\UserId;
use App\Domain\Entity\User\UserName;
use App\Exceptions\UseCaseException;
use App\Domain\Entity\User\UserEmail;
use App\Domain\Entity\User\UserPassword;
use App\Domain\Infrastructure\Repository\User\UserRepositoryInterface;
use App\Domain\Service\User\UserService;

class UpdateUserUseCase
{
    private $userRepo;
    private $userService;
    public function __construct(UserRepositoryInterface $userRepo, UserService $userService)
    {
        $this->userRepo = $userRepo;
        $this->userService = $userService;
    }

    public function execute(string $user_id, string $userName, string $email, string $password, string $password_confirmation): void
    {

        if (!$this->userService->isExists(new UserId($user_id))) {
            throw new UseCaseException("user_id", "this user_id is invalid");
        }

        $user = User::New(new UserId($user_id), new UserName($userName), new UserEmail($email), UserPassword::New($password, $password_confirmation));

        if ($this->userService->isEmailDuplicated($user)) {
            throw new UseCaseException("email", "this email is duplicated");
        }
        $this->userRepo->updateUser($user);
    }
}

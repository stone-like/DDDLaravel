<?php

namespace App\Usecase\User;

use App\Domain\Entity\User\User;
use App\Domain\Entity\User\UserId;
use App\Domain\Entity\User\UserName;
use App\Domain\Entity\User\UserEmail;
use App\Domain\Entity\User\UserPassword;
use App\Infrastructure\Repository\User\UserRepositoryInterface;
use App\Domain\Service\User\UserService;
use App\Exceptions\UseCaseException;
use Ramsey\Uuid\Uuid;

class CreateUserUseCase
{
    private $userRepo;
    private $userService;
    public function __construct(UserRepositoryInterface $userRepo, UserService $userService)
    {
        $this->userRepo = $userRepo;
        $this->userService = $userService;
    }

    public function execute(string $user_id = null, string $userName, string $email, string $password, string $password_confirmation): User
    {
        $uuid = $user_id ?? Uuid::uuid4()->toString();
        //emailの重複禁止のValidation

        //ここでEntityを作り、EntityOrDTOがRepository,QueryServiceから返ってくる
        $user = User::New(new UserId($uuid), new UserName($userName), new UserEmail($email), UserPassword::New($password, $password_confirmation));


        if ($this->userService->isEmailDuplicated($user)) {
            throw new UseCaseException("email", "this email is duplicated");
        }

        return $this->userRepo->createUser($user);
    }
}

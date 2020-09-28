<?php

namespace App\Domain\Service\User;

use App\Domain\Entity\User\User;
use App\Domain\Entity\User\UserId;
use App\Domain\Entity\User\UserEmail;
use App\Infrastructure\Repository\User\UserRepositoryInterface;

class UserService
{
    private $userRepo;
    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function isEmailDuplicated(User $user): bool
    {
        $user = $this->userRepo->findByEmail(new UserEmail($user->Email()));

        return $user !== null;
    }
    public function isExists(UserId $user_id): bool
    {
        $user = $this->userRepo->findById($user_id);

        return $user !== null;
    }
}

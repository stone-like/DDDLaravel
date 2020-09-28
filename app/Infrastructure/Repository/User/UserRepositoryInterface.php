<?php

namespace App\Infrastructure\Repository\User;

use App\Domain\Entity\User\User as UserEntity;
use App\Domain\Entity\User\UserEmail;
use App\Domain\Entity\User\UserId;

interface UserRepositoryInterface
{
    public function findById(UserId $id): ?UserEntity;
    public function findByEmail(UserEmail $email): ?UserEntity;
    public function createUser(UserEntity $user): void;
    public function updateUser(UserEntity $user): void;
    public function deleteUser(UserId $id): void;
}

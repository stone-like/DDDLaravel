<?php

namespace App\Domain\Infrastructure\Repository\User;

use App\Domain\Entity\User\UserId;
use App\Domain\Infrastructure\Model\User;
use App\Domain\Entity\User\User as UserEntity;

class EloquentUserRepository
{
    private User $eloquent;
    public function __construct(User $eloquent)
    {
        $this->eloquent = $eloquent;
    }
    public function findById(UserId $id): UserEntity
    {
        $user = $this->eloquent->where("id", $id->value())->first(); //firstの返り値はあるときはModel、ないときはnull
        return optional($user)->toDomain();
    }
    public function createUser(UserEntity $userEntity): void
    {
        (new User([
            "id" => $userEntity->Id(),
            "name" => $userEntity->Name(),
            "email" => $userEntity->Email(),
            "password" => $userEntity->Password()
        ]))->save();
    }
    public function updateUser(UserEntity $userEntity): void
    {
        $user = $this->eloquent->where("id", $userEntity->Id())->first();
        $user->update([
            "name" => $userEntity->Name(),
            "email" => $userEntity->Email(),
            "password" => $userEntity->Password()
        ]);
    }
    public function deleteUser(UserId $id): void
    {
        $user = $this->eloquent->where("id", $id->value())->first();
        $user->delete();
    }
}

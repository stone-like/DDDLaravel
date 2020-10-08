<?php

namespace App\Response\User;

use App\Domain\Entity\User\User;

class CreateUserReponse
{
    private $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function Data()
    {

        return [
            "id" => $this->user->Id(),
            "name" => $this->user->Name(),
            "email" => $this->user->Email()
        ];
    }
}

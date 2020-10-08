<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usecase\User\CreateUserUseCase;
use App\Usecase\User\DeleteUserUseCase;
use App\Usecase\User\UpdateUserUseCase;
use App\Response\User\CreateUserReponse;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\DeleteUserRequest;
use App\Http\Requests\User\UpdateUserRequest;

class UserController extends Controller
{
    private $createUserUseCase;
    private $deleteUserUseCase;
    private $updateUserUseCase;

    public function __construct(CreateUserUseCase $createUserUseCase, DeleteUserUseCase $deleteUserUseCase, UpdateUserUseCase $updateUserUseCase)
    {
        $this->createUserUseCase = $createUserUseCase;
        $this->deleteUserUseCase = $deleteUserUseCase;
        $this->updateUserUseCase = $updateUserUseCase;
    }

    public function createUser(CreateUserRequest $request)
    {

        $user = $this->createUserUseCase->execute(null, $request->name, $request->email, $request->password, $request->password_confirmation);
        $response = new CreateUserReponse($user);

        return $response->Data();
    }

    public function updateUser(string $id, UpdateUserRequest $request)
    {

        $this->updateUserUseCase->execute($id, $request->name, $request->email, $request->password, $request->password_confirmation);
    }

    public function deleteUser(string $id, DeleteUserRequest $request)
    {

        $this->deleteUserUseCase->execute($id);
    }
}

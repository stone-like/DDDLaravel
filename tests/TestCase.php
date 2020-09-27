<?php

namespace Tests;

use App\Domain\Infrastructure\QueryService\Article\MySQLArticleQueryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Domain\Infrastructure\Repository\Like\EloquentLikeRepository;
use App\Domain\Infrastructure\Repository\User\EloquentUserRepository;
use App\Domain\Infrastructure\Repository\Like\LikeRepositoryInterface;
use App\Domain\Infrastructure\Repository\User\UserRepositoryInterface;
use App\Domain\Infrastructure\Repository\Article\EloquentArticleRepository;
use App\Usecase\User\CreateUserUseCase;
use App\Usecase\User\DeleteUserUseCase;
use App\Usecase\User\FindUserByIdUseCase;
use App\Usecase\User\UpdateUserUseCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected $likeRepo;
    protected $userRepo;
    protected $articleRepo;
    protected $articleQueryService;

    protected $createUserUseCase;
    protected $deleteUserUseCase;
    protected $updateUserUseCase;
    protected $findUserByIdUseCase;

    protected $createArticleUseCase;
    protected $deleteArticleUseCase;
    protected $updateArticleUseCase;
    protected $findArticleByIdUseCase;
    protected $getAllArticleUseCase;



    public function setUp(): void
    {
        //testがrepositoryに依存してしまっているのでここは直さないといけない
        parent::setUp();
        $this->likeRepo = $this->app->make(EloquentLikeRepository::class);
        $this->userRepo = $this->app->make(EloquentUserRepository::class);
        $this->articleRepo = $this->app->make(EloquentArticleRepository::class);
        $this->articleQueryService = $this->app->make(MySQLArticleQueryService::class);
        $this->createUserUseCase = $this->app->make(CreateUserUseCase::class);
        $this->deleteUserUseCase = $this->app->make(DeleteUserUseCase::class);
        $this->updateUserUseCase = $this->app->make(UpdateUserUseCase::class);
        $this->findUserByIdUseCase = $this->app->make(FindUserByIdUseCase::class);
    }
}

<?php

namespace Tests;

use App\Usecase\Like\CreateLikeUseCase;
use App\Usecase\Like\DeleteLikeUseCase;
use App\Usecase\User\CreateUserUseCase;
use App\Usecase\User\DeleteUserUseCase;
use App\Usecase\User\UpdateUserUseCase;
use App\Usecase\Like\FindLikeByIdUseCase;
use App\Usecase\User\FindUserByIdUseCase;
use App\Usecase\Article\CreateArticleUseCase;
use App\Usecase\Article\DeleteArticleUseCase;
use App\Usecase\Article\GetAllArticleUseCase;
use App\Usecase\Article\UpdateArticleUseCase;
use App\Usecase\Article\FindArticleByIdUseCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Usecase\Like\FindByUserIdAndArticleIdUseCase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Infrastructure\Repository\Like\EloquentLikeRepository;
use App\Infrastructure\Repository\User\EloquentUserRepository;
use App\Infrastructure\Repository\Like\LikeRepositoryInterface;
use App\Infrastructure\Repository\User\UserRepositoryInterface;
use App\Infrastructure\Repository\Article\EloquentArticleRepository;
use App\Infrastructure\QueryService\Article\MySQLArticleQueryService;

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

    protected $createLikeUseCase;
    protected $deleteLikeUseCase;
    protected $findLikeByIdUseCase;
    protected $findByUserIdAndArticleIdUseCase;



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

        $this->createArticleUseCase = $this->app->make(CreateArticleUseCase::class);
        $this->updateArticleUseCase = $this->app->make(UpdateArticleUseCase::class);
        $this->deleteArticleUseCase = $this->app->make(DeleteArticleUseCase::class);
        $this->findArticleByIdUseCase = $this->app->make(FindArticleByIdUseCase::class);
        $this->getAllArticleUseCase = $this->app->make(GetAllArticleUseCase::class);

        $this->createLikeUseCase = $this->app->make(CreateLikeUseCase::class);
        $this->deleteLikeUseCase = $this->app->make(DeleteLikeUseCase::class);
        $this->findLikeByIdUseCase = $this->app->make(FindLikeByIdUseCase::class);
        $this->findByUserIdAndArticleIdUseCase = $this->app->make(FindByUserIdAndArticleIdUseCase::class);
    }
}

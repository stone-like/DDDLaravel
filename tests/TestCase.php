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

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected $likeRepo;
    protected $userRepo;
    protected $articleRepo;
    protected $articleQueryService;

    public function setUp(): void
    {
        //testがrepositoryに依存してしまっているのでここは直さないといけない
        parent::setUp();
        $this->likeRepo = $this->app->make(EloquentLikeRepository::class);
        $this->userRepo = $this->app->make(EloquentUserRepository::class);
        $this->articleRepo = $this->app->make(EloquentArticleRepository::class);
        $this->articleQueryService = $this->app->make(MySQLArticleQueryService::class);
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Infrastructure\Repository\Like\EloquentLikeRepository;
use App\Infrastructure\Repository\User\EloquentUserRepository;
use App\Infrastructure\Repository\Like\LikeRepositoryInterface;
use App\Infrastructure\Repository\User\UserRepositoryInterface;
use App\Infrastructure\Repository\Article\EloquentArticleRepository;
use App\Infrastructure\Repository\Article\ArticleRepositoryInterface;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ArticleRepositoryInterface::class, EloquentArticleRepository::class);
        $this->app->bind(LikeRepositoryInterface::class, EloquentLikeRepository::class);
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

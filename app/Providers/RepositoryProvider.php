<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Infrastructure\Repository\Like\EloquentLikeRepository;
use App\Domain\Infrastructure\Repository\Like\LikeRepositoryInterface;
use App\Domain\Infrastructure\Repository\Article\EloquentArticleRepository;
use App\Domain\Infrastructure\Repository\Article\ArticleRepositoryInterface;

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
<?php

namespace App\Providers;

use App\Domain\Infrastructure\Repository\Article\ArticleRepositoryInterface;
use App\Domain\Infrastructure\Repository\Article\EloquentArticleRepository;
use Illuminate\Support\ServiceProvider;

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

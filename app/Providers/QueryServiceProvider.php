<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Infrastructure\QueryService\Article\ArticleQueryServiceInterface;
use App\Domain\Infrastructure\QueryService\Article\MySQLArticleQueryService;

class QueryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ArticleQueryServiceInterface::class, MySQLArticleQueryService::class);
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

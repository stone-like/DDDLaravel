<?php

namespace App\Infrastructure\QueryService\Article;

use App\Infrastructure\QueryService\Article\DTO\ArticleDTO;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


class MySQLArticleQueryService implements ArticleQueryServiceInterface
{
    public function getAllList(): Collection
    {
        //likeがついていないやつも欲しい
        $articleList = DB::table("articles")
            ->leftjoin("users", "articles.user_id", "=", "users.id")
            ->leftjoin("likes", "articles.id", "=", "likes.article_id")
            ->select("articles.id as article_id", "articles.title as title", "articles.content as content", DB::raw("count(likes.id) as likeCount"), "users.id as user_id", "users.name as username")
            ->groupBy("articles.id")
            ->get();

        return  $articleList->map(function ($article) {
            return new ArticleDTO($article->article_id, $article->title, $article->content, $article->likeCount, $article->username, $article->user_id);
        });
    }
}

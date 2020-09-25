<?php

namespace App\Domain\Infrastructure\Repository\Article;

use App\Domain\Entity\User\UserId;
use App\Exceptions\RepositoryException;
use App\Domain\Entity\Article\ArticleId;
use App\Domain\Repository\Model\Article;
use App\Domain\Entity\Article\ArticleTitle;
use App\Domain\Entity\Article\ArticleContent;
use App\Domain\Entity\Article\Article as ArticleEntity;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentArticleRepository
{
    private Article $eloquent;
    public function __construct(Article $eloquent)
    {
        $this->eloquent = $eloquent;
    }

    //ここでexistingを確認出来てダメだったら例外throwすればいいかな？
    public function findById(ArticleId $id): ArticleEntity
    {
        //ここで例外だしたいけど、Eloquentだろうがなんだろうが処理を共通化させたいので、nullを返すことで共通化させる
        //それでusecaseでnullだったら例外投げればいい
        $article = $this->eloquent->where("id", $id->value())->get();
        if ($article->isEmpty()) {
            return null;
        }

        return $article->toDomain();
    }
    public function createArticle(ArticleEntity $article): void
    {
        (new Article([
            "id" => $article->Id(),
            "title" => $article->Title(),
            "content" => $article->Content(),
            "user_id" => $article->AuthorId()
        ]))->save();
    }
    public function updateArticle(ArticleEntity $article): void
    {
        //useCaseでこのIdの存在性は確認済み
        $article = $this->eloquent->where("id", $article->Id())->get();
        $article->update([
            "title" => $article->Title(),
            "content" => $article->Content(),
            "user_id" => $article->AuthorId()
        ]);
    }
    public function deleteArticle(ArticleId $id): void
    {
        //useCaseでこのIdの存在性は確認済み
        $article = $this->eloquent->where("id", $id)->get();
        $article->delete();
    }
}

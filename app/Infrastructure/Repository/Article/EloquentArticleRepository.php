<?php

namespace App\Infrastructure\Repository\Article;

use App\Domain\Entity\User\UserId;
use App\Exceptions\RepositoryException;
use App\Domain\Entity\Article\ArticleId;
use App\Domain\Entity\Article\ArticleTitle;
use App\Infrastructure\Model\Article;
use App\Domain\Entity\Article\ArticleContent;
use App\Domain\Entity\Article\Article as ArticleEntity;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentArticleRepository implements ArticleRepositoryInterface
{
    private Article $eloquent;
    public function __construct(Article $eloquent)
    {
        $this->eloquent = $eloquent;
    }

    //ここでexistingを確認出来てダメだったら例外throwすればいいかな？
    public function findById(ArticleId $id): ?ArticleEntity
    {
        //ここで例外だしたいけど、Eloquentだろうがなんだろうが処理を共通化させたいので、nullを返すことで共通化させる
        //それでusecaseでnullだったら例外投げればいい
        $article = $this->eloquent->where("id", $id->value())->first();

        return optional($article)->toDomain();
    }
    public function createArticle(ArticleEntity $articleEntity): void
    {
        (new Article([
            "id" => $articleEntity->Id(),
            "title" => $articleEntity->Title(),
            "content" => $articleEntity->Content(),
            "user_id" => $articleEntity->AuthorId()
        ]))->save();
    }
    public function updateArticle(ArticleEntity $articleEntity): void
    {
        //useCaseでこのIdの存在性は確認済み
        $article = $this->eloquent->where("id", $articleEntity->Id())->first();
        $article->update([
            "title" => $articleEntity->Title(),
            "content" => $articleEntity->Content(),
            "user_id" => $articleEntity->AuthorId()
        ]);
    }
    public function deleteArticle(ArticleId $id): void
    {
        //useCaseでこのIdの存在性は確認済み
        $article = $this->eloquent->where("id", $id->value())->first();
        $article->delete();
    }
}

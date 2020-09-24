<?php

namespace App\Domain\Infrastructure\Repository\Article;

use App\Domain\Entity\Article\Article as ArticleEntity;
use App\Domain\Entity\Article\ArticleId;
use App\Domain\Repository\Model\Article;
use App\Exceptions\RepositoryException;
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
        try {
            $article = $this->eloquent->where("id", $id->value())->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new RepositoryException("article_id", $e->getMessage());
        }

        return $article->toDomain();
    }
}

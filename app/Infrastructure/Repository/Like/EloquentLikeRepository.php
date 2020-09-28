<?php

namespace App\Infrastructure\Repository\Like;

use App\Domain\Entity\Like\LikeId;
use App\Domain\Entity\User\UserId;
use App\Domain\Entity\Article\ArticleId;
use App\Infrastructure\Model\Like;
use App\Domain\Entity\Like\Like as LikeEntity;

class EloquentLikeRepository
{
    private Like $eloquent;
    public function __construct(Like $eloquent)
    {
        $this->eloquent = $eloquent;
    }

    //Entity通さない方がいいかも,Readであるfindとcreate時のArticleのauthorとuserを比較する制約がかみ合わない←コンストラクタを二つ作ることで解決
    public function findById(LikeId $id): ?LikeEntity
    {
        $like = $this->eloquent->where("id", $id->value())->first();
        return optional($like)->toDomain();
    }

    public function findByUserIdAndArticleId(UserId $user_id, ArticleId $article_id): ?LikeEntity
    {
        $like = $this->eloquent->where("user_id", $user_id->value())->where("article_id", $article_id->value())->first();
        return optional($like)->toDomain();
    }

    public function createLike(LikeEntity $likeEntity): void
    {
        (new Like([
            "id" => $likeEntity->Id(),
            "article_id" => $likeEntity->ArticleId(),
            "user_id" => $likeEntity->UserId()
        ]))->save();
    }
    public function deleteLike(LikeId $id): void
    {
        $like = $this->eloquent->where("id", $id->value())->first();
        $like->delete();
    }
}

<?php

namespace App\Domain\Infrastructure\Repository\Like;

use App\Domain\Entity\Like\Like as LikeEntity;
use App\Domain\Entity\Like\LikeId;
use App\Domain\Infrastructure\Model\Like;

class EloquentLikeRepository
{
    private Like $eloquent;
    public function __construct(Like $eloquent)
    {
        $this->eloquent = $eloquent;
    }

    //Entity通さない方がいいかも,Readであるfindとcreate時のArticleのauthorとuserを比較する制約がかみ合わない

    public function createLike(LikeEntity $like): void
    {
        (new Like([
            "id" => $like->Id(),
            "article_id" => $like->ArticleId(),
            "user_id" => $like->UserId()
        ]))->save();
    }
    public function deleteLike(LikeId $id): void
    {
        $like = $this->eloquent->where("id", $id)->get();
        $like->delete();
    }
}

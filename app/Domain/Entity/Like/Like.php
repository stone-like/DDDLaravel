<?php

namespace App\Domain\Entity\Like;

use App\Domain\Entity\User\UserId;
use App\Domain\Entity\Article\ArticleId;

class Like
{
    //実際likeにはなんの情報もないのでlikeEntityを作る意味はなさそうだけど・・・
    //ただ、Likeを永続化するときにArticle、userIdのexistingチェック等できればいいのかも？
    private ArticleId $article_id;
    private UserId $user_id;

    public function __construct(ArticleId $article_id, UserId $user_id)
    {
        $this->article_id = $article_id;
        $this->user_id = $user_id;
    }
}

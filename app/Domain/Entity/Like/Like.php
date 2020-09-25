<?php

namespace App\Domain\Entity\Like;

use App\Domain\Entity\Like\LikeId;
use App\Domain\Entity\User\UserId;
use App\Exceptions\DomainException;
use App\Domain\Entity\Article\Article;
use App\Domain\Entity\Article\ArticleId;

class Like
{
    //実際likeにはなんの情報もないのでlikeEntityを作る意味はなさそうだけど・・・
    //ただ、Likeを永続化するときにArticle、userIdのexistingチェック等できればいいのかも？
    private LikeId $id;
    private ArticleId $article_id;
    private UserId $user_id;

    private function __construct()
    {
    }

    //Entity全部Factoryパターンでそろえた方がいいかも
    public static function new(Article $article, UserId $user_id, LikeId $id)
    {
        if ($article->isAuthor($user_id)) {
            throw new DomainException("user_id", "this user is author in this article");
        }
        $instance = new self();
        $instance->article_id = $article->Id();
        $instance->user_id = $user_id;
        $instance->id = $id;

        return $instance;
    }


    public static function fromRepository(ArticleId $articleId, UserId $userId, LikeId $Id)
    {
        $instance = new self();
        $instance->article_id = $articleId;
        $instance->user_id = $userId;
        $instance->id = $Id;
        return $instance;
    }

    public function Id(): string
    {
        return $this->id->value();
    }
    public function ArticleId(): string
    {
        return $this->article_id->value();
    }
    public function UserId(): string
    {
        return $this->user_id->value();
    }
}

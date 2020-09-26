<?php

namespace App\Domain\Infrastructure\Model;

use App\Domain\Entity\Like\LikeId;
use App\Domain\Entity\User\UserId;
use Illuminate\Database\Eloquent\Model;
use App\Domain\Entity\Article\ArticleId;
use App\Domain\Entity\Like\Like as LikeEntity;
use App\Domain\Infrastructure\Model\Domainable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Like extends Model implements Domainable
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        "id",
        "user_id",
        "article_id"
    ];

    protected $keytype = "string";
    public  $incrementing = false;

    public function toDomain(): LikeEntity
    {
        return LikeEntity::FromRepository(
            new ArticleId($this->article_id),
            new UserId($this->user_id),
            new LikeId($this->id),
        );
    }
}

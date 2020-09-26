<?php


namespace App\Domain\Infrastructure\Model;

use App\Domain\Entity\User\UserId;
use Illuminate\Database\Eloquent\Model;
use App\Domain\Entity\Article\ArticleId;
use App\Domain\Entity\Article\ArticleTitle;
use App\Domain\Entity\Article\ArticleContent;
use App\Domain\Infrastructure\Model\Domainable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Domain\Entity\Article\Article as ArticleEntity;

class Article extends Model implements Domainable
{
    use HasFactory;
    public $timestamps = false;
    protected $keytype = "string";
    public  $incrementing = false;
    protected $fillable = [
        "id",
        "title",
        "content",
        "user_id"
    ];

    public function toDomain()
    {
        return ArticleEntity::New(
            new ArticleId($this->id),
            new ArticleTitle($this->title),
            new ArticleContent($this->content),
            new UserId($this->user_id)
        );
    }
}

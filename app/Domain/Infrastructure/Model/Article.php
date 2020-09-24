<?php


namespace App\Domain\Infrastructure\Model;

use App\Domain\Entity\Article\Article as ArticleEntity;
use App\Domain\Entity\Article\ArticleContent;
use App\Domain\Entity\Article\ArticleId;
use App\Domain\Entity\Article\ArticleTitle;
use Illuminate\Database\Eloquent\Model;
use App\Domain\Repository\Model\Domainable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model implements Domainable
{
    use HasFactory;
    protected $fillable = [
        "id",
        "title",
        "content"
    ];

    public function toDomain()
    {
        return new ArticleEntity(
            new ArticleId($this->id),
            new ArticleTitle($this->title),
            new ArticleContent($this->content)
        );
    }
}

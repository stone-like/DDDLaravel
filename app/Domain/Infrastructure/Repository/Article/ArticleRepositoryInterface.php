<?php

namespace App\Domain\Infrastructure\Repository\Article;

use App\Domain\Entity\Article\Article;
use App\Domain\Entity\Article\ArticleId;

interface ArticleRepositoryInterface
{
    public function findById(ArticleId $id): ?Article;
    public function createArticle(Article $article): void;
    public function updateArticle(Article $article): void;
    public function deleteArticle(ArticleId $id): void;
    //allArticleはpagination絡むためCQRSでやったほうがよさそう
}

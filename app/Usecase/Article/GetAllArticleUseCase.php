<?php

namespace App\Usecase\Article;

use Illuminate\Support\Collection;
use App\Domain\Infrastructure\QueryService\Article\ArticleQueryServiceInterface;

class GetAllArticleUseCase
{
    private $articleQueryService;
    public function __construct(ArticleQueryServiceInterface $articleQueryService)
    {
        $this->articleQueryService = $articleQueryService;
    }

    public function execute(): Collection
    {
        return $this->articleQueryService->getAllList();
    }
}

<?php

namespace Tests\Unit;

use Tests\TestCase;
use Ramsey\Uuid\Uuid;
use App\Domain\Entity\Like\Like;
use App\Domain\Entity\User\User;
use App\Domain\Entity\Like\LikeId;
use App\Domain\Entity\User\UserId;
use App\Domain\Entity\User\UserName;
use App\Domain\Entity\User\UserEmail;
use App\Domain\Entity\Article\Article;
use App\Domain\Entity\Article\ArticleId;
use App\Domain\Entity\User\UserPassword;
use App\Domain\Entity\Article\ArticleTitle;
use App\Domain\Entity\Article\ArticleContent;
use Illuminate\Foundation\Testing\RefreshDatabase;


class ArticleQueryServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_get_all_article_with_like_count_and_user_data()
    {
        $user_id = Uuid::uuid4()->toString();
        $user = User::New(new UserId($user_id), new UserName("test"), new UserEmail("test@email.com"), UserPassword::New("password", "password"));
        $this->userRepo->createUser($user);

        $another_user_id = Uuid::uuid4()->toString();
        $anotherUser = User::New(new UserId($another_user_id), new UserName("test"), new UserEmail("another@email.com"), UserPassword::New("password", "password"));
        $this->userRepo->createUser($anotherUser);

        $article_id = Uuid::uuid4()->toString();
        $article = Article::New(new ArticleId($article_id), new ArticleTitle("test"), new ArticleContent("test"), new UserId($user_id));
        $this->articleRepo->createArticle($article);

        $like_id = Uuid::uuid4()->toString();
        $like = Like::New($article, new UserId($another_user_id), new LikeId($like_id));
        $this->likeRepo->createLike($like);

        $articleList = $this->articleQueryService->getAllList();
        $this->assertEquals($article_id, $articleList[0]->ArticleId());
        $this->assertEquals("test", $articleList[0]->Title());
        $this->assertEquals("test", $articleList[0]->Content());
        $this->assertEquals(1, $articleList[0]->LikeCount());
        $this->assertEquals("test", $articleList[0]->UserName());
        $this->assertEquals($user_id, $articleList[0]->UserId());
    }
}

<?php

namespace Tests\Unit;

use Tests\TestCase;
use Ramsey\Uuid\Uuid;
use App\Domain\Entity\User\User;
use App\Domain\Entity\User\UserId;
use App\Domain\Entity\User\UserName;
use App\Domain\Entity\User\UserEmail;
use App\Domain\Entity\Article\Article;
use App\Domain\Entity\Article\ArticleId;
use App\Domain\Entity\User\UserPassword;
use App\Domain\Entity\Article\ArticleTitle;
use App\Domain\Entity\Article\ArticleContent;
use Illuminate\Foundation\Testing\RefreshDatabase;


class ArticleRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create_article()
    {

        $user_id = Uuid::uuid4()->toString();
        $user = User::New(new UserId($user_id), new UserName("test"), new UserEmail("test@email.com"), UserPassword::New("password", "password"));
        $this->userRepo->createUser($user);

        $article_id = Uuid::uuid4()->toString();
        $article = Article::New(new ArticleId($article_id), new ArticleTitle("test"), new ArticleContent("test"), new UserId($user_id));
        $this->articleRepo->createArticle($article);

        $this->assertDatabaseHas("articles", ["id" => $article_id, "title" => "test", "content" => "test", "user_id" => $user_id]);
    }

    /** @test */
    public function can_update_article()
    {

        $user_id = Uuid::uuid4()->toString();
        $user = User::New(new UserId($user_id), new UserName("test"), new UserEmail("test@email.com"), UserPassword::New("password", "password"));
        $this->userRepo->createUser($user);

        $article_id = Uuid::uuid4()->toString();
        $article = Article::New(new ArticleId($article_id), new ArticleTitle("test"), new ArticleContent("test"), new UserId($user_id));
        $this->articleRepo->createArticle($article);

        $newArticle = Article::New(new ArticleId($article_id), new ArticleTitle("updated"), new ArticleContent("updated"), new UserId($user_id));
        $this->articleRepo->updateArticle($newArticle);
        $this->assertDatabaseMissing("articles", ["id" => $article_id, "title" => "test", "content" => "test", "user_id" => $user_id]);
        $this->assertDatabaseHas("articles", ["id" => $article_id, "title" => "updated", "content" => "updated", "user_id" => $user_id]);
    }

    /** @test */
    public function can_delete_article()
    {

        $user_id = Uuid::uuid4()->toString();
        $user = User::New(new UserId($user_id), new UserName("test"), new UserEmail("test@email.com"), UserPassword::New("password", "password"));
        $this->userRepo->createUser($user);

        $article_id = Uuid::uuid4()->toString();
        $article = Article::New(new ArticleId($article_id), new ArticleTitle("test"), new ArticleContent("test"), new UserId($user_id));
        $this->articleRepo->createArticle($article);


        $this->articleRepo->deleteArticle(new ArticleId($article_id));
        $this->assertDatabaseMissing("articles", ["id" => $article_id, "title" => "test", "content" => "test", "user_id" => $user_id]);
    }
}

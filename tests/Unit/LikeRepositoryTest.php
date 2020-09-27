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



class LikeRepositoryTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function can_create_like()
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

        $this->assertDatabaseHas("likes", ["id" => $like_id, "user_id" => $another_user_id, "article_id" => $article_id]);
    }

    /** @test */
    public function can_delete_like()
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

        $this->likeRepo->deleteLike(new LikeId($like_id));
        $this->assertDatabaseMissing("likes", ["id" => $like_id, "user_id" => $another_user_id, "article_id" => $article_id]);
    }

    /** @test */
    public function can_find_like_by_id()
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

        $likeEntity = $this->likeRepo->findById(new LikeId($like_id));


        $this->assertEquals($another_user_id, $likeEntity->UserId());
        $this->assertEquals($article_id, $likeEntity->ArticleId());
    }

    /** @test */
    public function return_null_if_can_not_find_like()
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

        $likeEntity = $this->likeRepo->findById(new LikeId("dummyuuid"));


        $this->assertEquals(null, $likeEntity);
    }

    /** @test */
    public function can_find_like_by_user_id_and_article_id()
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

        $likeEntity = $this->likeRepo->findByUserIdAndArticleId(new UserId($another_user_id), new ArticleId($article_id));


        $this->assertEquals($another_user_id, $likeEntity->UserId());
        $this->assertEquals($article_id, $likeEntity->ArticleId());
    }
}

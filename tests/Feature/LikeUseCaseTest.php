<?php

namespace Tests\Feature;

use Tests\TestCase;
use Ramsey\Uuid\Uuid;
use App\Exceptions\DomainException;
use App\Exceptions\UseCaseException;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LikeUseCaseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create_like()
    {
        $like_id = Uuid::uuid4()->toString();
        $user_id = Uuid::uuid4()->toString();
        $this->createUserUseCase->execute($user_id, "test", "test@email.com", "password", "password");

        $another_user_id = Uuid::uuid4()->toString();
        $this->createUserUseCase->execute($another_user_id, "another", "another@email.com", "password", "password");

        $article_id = Uuid::uuid4()->toString();
        $this->createArticleUseCase->execute($article_id, "test", "test", $another_user_id);

        $this->createLikeUseCase->execute($like_id, $article_id, "test", "test", $another_user_id, $user_id);


        $this->assertDatabaseHas("likes", ["id" => $like_id, "user_id" => $user_id, "article_id" => $article_id]);
    }

    /** @test */
    public function error_when_invalid_article_id()
    {
        $this->expectException(UseCaseException::class);

        $like_id = Uuid::uuid4()->toString();
        $user_id = Uuid::uuid4()->toString();
        $this->createUserUseCase->execute($user_id, "test", "test@email.com", "password", "password");

        $another_user_id = Uuid::uuid4()->toString();
        $this->createUserUseCase->execute($another_user_id, "another", "another@email.com", "password", "password");

        $article_id = Uuid::uuid4()->toString();
        $this->createArticleUseCase->execute($article_id, "test", "test", $another_user_id);

        $this->createLikeUseCase->execute($like_id, "dummy_article", "test", "test", $another_user_id, $user_id);
    }

    /** @test */
    public function error_when_invalid_user_id()
    {
        $this->expectException(UseCaseException::class);

        $like_id = Uuid::uuid4()->toString();
        $user_id = Uuid::uuid4()->toString();
        $this->createUserUseCase->execute($user_id, "test", "test@email.com", "password", "password");

        $another_user_id = Uuid::uuid4()->toString();
        $this->createUserUseCase->execute($another_user_id, "another", "another@email.com", "password", "password");

        $article_id = Uuid::uuid4()->toString();
        $this->createArticleUseCase->execute($article_id, "test", "test", $another_user_id);

        $this->createLikeUseCase->execute($like_id, $article_id, "test", "test", $another_user_id, "dummy_user");
    }

    /** @test */
    public function error_when_author_like_own_article()
    {
        //Likeの生成時のErrorなのでDomainError
        $this->expectException(DomainException::class);

        $like_id = Uuid::uuid4()->toString();
        $user_id = Uuid::uuid4()->toString();
        $this->createUserUseCase->execute($user_id, "test", "test@email.com", "password", "password");

        $another_user_id = Uuid::uuid4()->toString();
        $this->createUserUseCase->execute($another_user_id, "another", "another@email.com", "password", "password");

        $article_id = Uuid::uuid4()->toString();
        $this->createArticleUseCase->execute($article_id, "test", "test", $another_user_id);

        $this->createLikeUseCase->execute($like_id, $article_id, "test", "test", $another_user_id, $another_user_id);
    }

    /** @test */
    public function can_delete_like()
    {


        $like_id = Uuid::uuid4()->toString();
        $user_id = Uuid::uuid4()->toString();
        $this->createUserUseCase->execute($user_id, "test", "test@email.com", "password", "password");

        $another_user_id = Uuid::uuid4()->toString();
        $this->createUserUseCase->execute($another_user_id, "another", "another@email.com", "password", "password");

        $article_id = Uuid::uuid4()->toString();
        $this->createArticleUseCase->execute($article_id, "test", "test", $another_user_id);

        $this->createLikeUseCase->execute($like_id, $article_id, "test", "test", $another_user_id, $user_id);
        $this->deleteLikeUseCase->execute($like_id);


        $this->assertDatabaseMissing("likes", ["id" => $like_id, "user_id" => $user_id, "article_id" => $article_id]);
    }

    /** @test */
    public function error_when_invalid_like()
    {
        $this->expectException(UseCaseException::class);

        $like_id = Uuid::uuid4()->toString();
        $user_id = Uuid::uuid4()->toString();
        $this->createUserUseCase->execute($user_id, "test", "test@email.com", "password", "password");

        $another_user_id = Uuid::uuid4()->toString();
        $this->createUserUseCase->execute($another_user_id, "another", "another@email.com", "password", "password");

        $article_id = Uuid::uuid4()->toString();
        $this->createArticleUseCase->execute($article_id, "test", "test", $another_user_id);

        $this->createLikeUseCase->execute($like_id, $article_id, "test", "test", $another_user_id, $user_id);
        $this->deleteLikeUseCase->execute("dummy_like");
    }


    /** @test */
    public function can_find_like_by_id()
    {
        $like_id = Uuid::uuid4()->toString();
        $user_id = Uuid::uuid4()->toString();
        $this->createUserUseCase->execute($user_id, "test", "test@email.com", "password", "password");

        $another_user_id = Uuid::uuid4()->toString();
        $this->createUserUseCase->execute($another_user_id, "another", "another@email.com", "password", "password");

        $article_id = Uuid::uuid4()->toString();
        $this->createArticleUseCase->execute($article_id, "test", "test", $another_user_id);

        $this->createLikeUseCase->execute($like_id, $article_id, "test", "test", $another_user_id, $user_id);

        $like = $this->findLikeByIdUseCase->execute($like_id);

        $this->assertEquals($user_id, $like->UserId());
        $this->assertEquals($article_id, $like->ArticleId());
        $this->assertEquals($like_id, $like->Id());
    }


    /** @test */
    public function can_find_by_user_id_and_article_id()
    {
        $like_id = Uuid::uuid4()->toString();
        $user_id = Uuid::uuid4()->toString();
        $this->createUserUseCase->execute($user_id, "test", "test@email.com", "password", "password");

        $another_user_id = Uuid::uuid4()->toString();
        $this->createUserUseCase->execute($another_user_id, "another", "another@email.com", "password", "password");

        $article_id = Uuid::uuid4()->toString();
        $this->createArticleUseCase->execute($article_id, "test", "test", $another_user_id);

        $this->createLikeUseCase->execute($like_id, $article_id, "test", "test", $another_user_id, $user_id);

        $like = $this->findByUserIdAndArticleIdUseCase->execute($user_id, $article_id);

        $this->assertEquals($user_id, $like->UserId());
        $this->assertEquals($article_id, $like->ArticleId());
        $this->assertEquals($like_id, $like->Id());
    }
}

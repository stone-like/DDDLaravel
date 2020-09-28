<?php

namespace Tests\Feature;

use App\Exceptions\UseCaseException;
use Tests\TestCase;
use Ramsey\Uuid\Uuid;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleUseCaseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create_article()
    {
        $user_id = Uuid::uuid4()->toString();
        $this->createUserUseCase->execute($user_id, "test", "test@email.com", "password", "password");

        $article_id = Uuid::uuid4()->toString();
        $this->createArticleUseCase->execute($article_id, "test", "test", $user_id);

        $this->assertDatabaseHas("articles", ["id" => $article_id, "title" => "test", "content" => "test", "user_id" => $user_id]);
    }

    /** @test */
    public function error_when_invalid_user_id_given()
    {
        $this->expectException(UseCaseException::class);

        $user_id = Uuid::uuid4()->toString();
        $this->createUserUseCase->execute($user_id, "test", "test@email.com", "password", "password");

        $article_id = Uuid::uuid4()->toString();
        $this->createArticleUseCase->execute($article_id, "test", "test", "dummyId");
    }

    /** @test */
    public function can_update_article()
    {
        $user_id = Uuid::uuid4()->toString();
        $this->createUserUseCase->execute($user_id, "test", "test@email.com", "password", "password");

        $article_id = Uuid::uuid4()->toString();
        $this->createArticleUseCase->execute($article_id, "test", "test", $user_id);

        $this->updateArticleUseCase->execute($article_id, "updated", "updated", $user_id);
        $this->assertDatabaseMissing("articles", ["title" => "test", "content" => "test"]);
        $this->assertDatabaseHas("articles", ["title" => "updated", "content" => "updated"]);
    }

    /** @test */
    public function error_when_invalid_article_id_given()
    {

        $this->expectException(UseCaseException::class);

        $user_id = Uuid::uuid4()->toString();
        $this->createUserUseCase->execute($user_id, "test", "test@email.com", "password", "password");

        $article_id = Uuid::uuid4()->toString();
        $this->createArticleUseCase->execute($article_id, "test", "test", $user_id);

        $this->updateArticleUseCase->execute("dummyId", "updated", "updated", $user_id);
    }

    /** @test */
    public function can_delete_article()
    {
        $user_id = Uuid::uuid4()->toString();
        $this->createUserUseCase->execute($user_id, "test", "test@email.com", "password", "password");

        $article_id = Uuid::uuid4()->toString();
        $this->createArticleUseCase->execute($article_id, "test", "test", $user_id);

        $this->deleteArticleUseCase->execute($article_id);
        $this->assertDatabaseMissing("articles", ["title" => "test", "content" => "test"]);
    }

    /** @test */
    public function can_find_article_by_id()
    {
        $user_id = Uuid::uuid4()->toString();
        $this->createUserUseCase->execute($user_id, "test", "test@email.com", "password", "password");

        $article_id = Uuid::uuid4()->toString();
        $this->createArticleUseCase->execute($article_id, "test", "test", $user_id);

        $article = $this->findArticleByIdUseCase->execute($article_id);
        $this->assertEquals($article_id, $article->Id());
        $this->assertEquals("test", $article->Title());
        $this->assertEquals("test", $article->Content());
        $this->assertEquals($user_id, $article->AuthorId());
    }

    // /** @test */
    // public function can_get_all_article()
    // {
    //     $user_id = Uuid::uuid4()->toString();
    //     $this->createUserUseCase->execute($user_id, "test", "test@email.com", "password", "password");

    //     $article_id = Uuid::uuid4()->toString();
    //     $this->createArticleUseCase->execute($article_id, "test", "test", $user_id);
    //     $another_article_id = Uuid::uuid4()->toString();
    //     $this->createArticleUseCase->execute($another_article_id, "test2", "test2", $user_id);

    //     $article = $this->getAllArticleUseCase->execute();


    // }
}

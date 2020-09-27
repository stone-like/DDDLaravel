<?php

namespace Tests\Feature;

use Tests\TestCase;
use Ramsey\Uuid\Uuid;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleUseCaseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create_article(){
        $user_id = Uuid::uuid4()->toString();
        $this->createUserUseCase->execute($user_id, "test", "test@email.com", "password", "password");

        $article_id = Uuid::uuid4()->toString();
    }
}

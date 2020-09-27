<?php

namespace Tests\Feature;

use App\Exceptions\UseCaseException;
use Tests\TestCase;
use Ramsey\Uuid\Uuid;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserUseCaseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create_user()
    {
        $uuid = Uuid::uuid4()->toString();
        $this->createUserUseCase->execute($uuid, "test", "test@email.com", "password", "password");
        $this->assertDatabaseHas("users", ["id" => $uuid, "name" => "test", "email" => "test@email.com"]);
    }
    /** @test */
    public function error_when_email_is_duplicated()
    {
        $this->expectException(UseCaseException::class);
        $uuid = Uuid::uuid4()->toString();
        $this->createUserUseCase->execute($uuid, "test", "test@email.com", "password", "password");
        $this->assertDatabaseHas("users", ["id" => $uuid, "name" => "test", "email" => "test@email.com"]);

        $uuid = Uuid::uuid4()->toString();
        $this->createUserUseCase->execute($uuid, "test", "test@email.com", "password", "password");
    }

    /** @test */
    public function can_update_user()
    {
        $uuid = Uuid::uuid4()->toString();
        $this->createUserUseCase->execute($uuid, "test", "test@email.com", "password", "password");
        $this->updateUserUseCase->execute($uuid, "updated", "updated@email.com", "password", "password");
        $this->assertDatabaseMissing("users", ["name" => "test", "email" => "test@email.com"]);
        $this->assertDatabaseHas("users", ["name" => "updated", "email" => "updated@email.com"]);
    }

    /** @test */
    public function error_when_invalid_user_id_given()
    {
        $this->expectException(UseCaseException::class);
        $uuid = Uuid::uuid4()->toString();
        $this->createUserUseCase->execute($uuid, "test", "test@email.com", "password", "password");
        $this->updateUserUseCase->execute("dummyId", "updated", "updated@email.com", "password", "password");
    }

    /** @test */
    public function can_delete_user()
    {
        $uuid = Uuid::uuid4()->toString();
        $this->createUserUseCase->execute($uuid, "test", "test@email.com", "password", "password");
        $this->deleteUserUseCase->execute($uuid);
        $this->assertDatabaseMissing("users", ["name" => "test", "email" => "test@email.com"]);
    }

    /** @test */
    public function can_find_user_by_id()
    {
        $uuid = Uuid::uuid4()->toString();
        $this->createUserUseCase->execute($uuid, "test", "test@email.com", "password", "password");
        $user = $this->findUserByIdUseCase->execute($uuid);
        $this->assertEquals("test", $user->Name());
        $this->assertEquals("test@email.com", $user->Email());
        $this->assertEquals($uuid, $user->Id());
        $this->assertTrue(password_verify("password", $user->Password()));
    }
}

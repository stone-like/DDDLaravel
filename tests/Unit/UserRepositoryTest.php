<?php

namespace Tests\Unit;

use Tests\TestCase;
use Ramsey\Uuid\Uuid;
use App\Domain\Entity\User\User;
use App\Domain\Entity\User\UserId;
use App\Domain\Entity\User\UserName;
use App\Domain\Entity\User\UserEmail;
use App\Domain\Entity\User\UserPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create_user()
    {
        $id = Uuid::uuid4()->toString();
        $user = User::New(new UserId($id), new UserName("test"), new UserEmail("test@email.com"), UserPassword::New("password", "password"));
        $this->userRepo->createUser($user);
        $this->assertDatabaseHas("users", ["id" => $id, "name" => "test", "email" => "test@email.com"]);
    }

    /** @test */
    public function can_update_user()
    {
        $id = Uuid::uuid4()->toString();
        $user = User::New(new UserId($id), new UserName("test"), new UserEmail("test@email.com"), UserPassword::New("password", "password"));
        $this->userRepo->createUser($user);

        $user = User::New(new UserId($id), new UserName("updated"), new UserEmail("updated@email.com"), UserPassword::New("newpassword", "newpassword"));
        $this->userRepo->updateUser($user);
        $this->assertDatabaseMissing("users", ["id" => $id, "name" => "test", "email" => "test@email.com"]);
        $this->assertDatabaseHas("users", ["id" => $id, "name" => "updated", "email" => "updated@email.com"]);
    }

    /** @test */
    public function can_delete_user()
    {
        $id = Uuid::uuid4()->toString();
        $user = User::New(new UserId($id), new UserName("test"), new UserEmail("test@email.com"), UserPassword::New("password", "password"));
        $this->userRepo->createUser($user);

        $this->userRepo->deleteUser(new UserId($id));
        $this->assertDatabaseMissing("users", ["id" => $id, "name" => "test", "email" => "test@email.com"]);
    }

    /** @test */
    public function can_find_user()
    {
        $id = Uuid::uuid4()->toString();
        $user = User::New(new UserId($id), new UserName("test"), new UserEmail("test@email.com"), UserPassword::New("password", "password"));
        $this->userRepo->createUser($user);

        $user = $this->userRepo->findById(new UserId($id));
        $this->assertEquals("test", $user->Name());
        $this->assertEquals("test@email.com", $user->Email());
        $this->assertEquals($id, $user->Id());
        $this->assertTrue(password_verify("password", $user->Password()));
    }

    /** @test */
    public function can_find_user_by_email()
    {
        $id = Uuid::uuid4()->toString();
        $user = User::New(new UserId($id), new UserName("test"), new UserEmail("test@email.com"), UserPassword::New("password", "password"));
        $this->userRepo->createUser($user);

        $user = $this->userRepo->findByEmail(new UserEmail("test@email.com"));
        $this->assertEquals("test", $user->Name());
        $this->assertEquals("test@email.com", $user->Email());
        $this->assertEquals($id, $user->Id());
        $this->assertTrue(password_verify("password", $user->Password()));
    }

    /** @test */
    public function return_null_if_can_not_find()
    {
        $id = Uuid::uuid4()->toString();
        $user = User::New(new UserId($id), new UserName("test"), new UserEmail("test@email.com"), UserPassword::New("password", "password"));
        $this->userRepo->createUser($user);

        $user = $this->userRepo->findById(new UserId("dummyId"));
        $this->assertEquals(null, $user);
    }
}

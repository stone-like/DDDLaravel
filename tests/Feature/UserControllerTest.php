<?php

namespace Tests\Feature;

use App\Http\Requests\User\CreateUserRequest;
use App\Usecase\User\CreateUserUseCase;
use App\Usecase\User\DeleteUserUseCase;
use App\Usecase\User\UpdateUserUseCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;



    /** @test */
    public function controller_can_create_user()
    {

        $data = [
            "name" => "test",
            "email" => "test@email.com",
            "password" => "password",
            "password_confirmation" => "password"
        ];

        $user = json_decode($this->post("/api/users", $data)->content(), true);
        $this->assertEquals("test", $user["name"]);
        $this->assertEquals("test@email.com", $user["email"]);
        $this->assertNotContains("password", $user);
    }

    /** @test */
    public function error_when_name_is_under_3()
    {

        $data = [
            "name" => "te",
            "email" => "test@email.com",
            "password" => "password",
            "password_confirmation" => "password"
        ];

        $this->post("/api/users", $data)->assertSessionHasErrors("name");
    }

    /** @test */
    public function ok_when_name_equals_3()
    {

        $data = [
            "name" => "tes",
            "email" => "test@email.com",
            "password" => "password",
            "password_confirmation" => "password"
        ];

        $this->post("/api/users", $data);

        $this->assertDatabaseHas("users", ["name" => "tes", "email" => "test@email.com"]);
    }

    /** @test */
    public function error_when_name_is_over_15()
    {

        $data = [
            "name" => "over15nameOccure",
            "email" => "test@email.com",
            "password" => "password",
            "password_confirmation" => "password"
        ];

        $this->post("/api/users", $data)->assertSessionHasErrors("name");
    }

    /** @test */
    public function ok_when_name_equals_15()
    {

        $data = [
            "name" => "just15nameOccur",
            "email" => "test@email.com",
            "password" => "password",
            "password_confirmation" => "password"
        ];

        $this->post("/api/users", $data);

        $this->assertDatabaseHas("users", ["name" => "just15nameOccur", "email" => "test@email.com"]);
    }

    /** @test */
    public function error_when_email_is_invalid()
    {

        $data = [
            "name" => "test",
            "email" => "testemailcom",
            "password" => "password",
            "password_confirmation" => "password"
        ];

        $this->post("/api/users", $data)->assertSessionHasErrors("email");
    }

    /** @test */
    public function error_when_password_is_under_8()
    {

        $data = [
            "name" => "test",
            "email" => "test@email.com",
            "password" => "passwor",
            "password_confirmation" => "passwor"
        ];

        $this->post("/api/users", $data)->assertSessionHasErrors("password");
    }

    /** @test */
    public function ok_when_password_equal_8()
    {

        $data = [
            "name" => "test",
            "email" => "test@email.com",
            "password" => "password",
            "password_confirmation" => "password"
        ];

        $this->post("/api/users", $data);

        $this->assertDatabaseHas("users", ["name" => "test", "email" => "test@email.com"]);
    }

    /** @test */
    public function error_when_password_is_over_20()
    {

        $data = [
            "name" => "test",
            "email" => "test@email.com",
            "password" => "over20PasswordIsError",
            "password_confirmation" => "over20PasswordIsError"
        ];

        $this->post("/api/users", $data)->assertSessionHasErrors("password");
    }

    /** @test */
    public function ok_when_password_equal_20()
    {

        $data = [
            "name" => "test",
            "email" => "test@email.com",
            "password" => "just20PasswordIsSafe",
            "password_confirmation" => "just20PasswordIsSafe"
        ];

        $this->post("/api/users", $data);

        $this->assertDatabaseHas("users", ["name" => "test", "email" => "test@email.com"]);
    }

    /** @test */
    public function error_when_password_is_not_equal_password_confirmation()
    {

        $data = [
            "name" => "test",
            "email" => "test@email.com",
            "password" => "password1",
            "password_confirmation" => "password2"
        ];

        $this->post("/api/users", $data)->assertSessionHasErrors("password");
    }

    /** @test */
    public function controller_can_update_user()
    {
        $this->withoutExceptionHandling();

        $data = [
            "name" => "test",
            "email" => "test@email.com",
            "password" => "password",
            "password_confirmation" => "password"
        ];

        $user = json_decode($this->post("/api/users", $data)->content(), true);

        $data = [
            "name" => "updated",
            "email" => "updated@email.com",
            "password" => "password",
            "password_confirmation" => "password"
        ];
        $this->patch("/api/users/" . $user["id"], $data);

        $this->assertDatabaseMissing("users", ["name" => "test", "email" => "test@email.com"]);
        $this->assertDatabaseHas("users", ["name" => "updated", "email" => "updated@email.com"]);
    }

    /** @test */
    public function error_when_non_existing_user()
    {

        $data = [
            "name" => "test",
            "email" => "test@email.com",
            "password" => "password",
            "password_confirmation" => "password"
        ];

        $user = json_decode($this->post("/api/users", $data)->content(), true);

        $data = [
            "name" => "updated",
            "email" => "updated@email.com",
            "password" => "password",
            "password_confirmation" => "password"
        ];
        $this->patch("/api/users/" . 6000000000, $data)->assertSessionHasErrors("user_id");
    }

    /** @test */
    public function controller_can_delete_user()
    {

        $data = [
            "name" => "test",
            "email" => "test@email.com",
            "password" => "password",
            "password_confirmation" => "password"
        ];

        $user = json_decode($this->post("/api/users", $data)->content(), true);

        $this->delete("/api/users/" . $user["id"]);

        $this->assertDatabaseMissing("users", ["name" => "test", "email" => "test@email.com"]);
    }
}

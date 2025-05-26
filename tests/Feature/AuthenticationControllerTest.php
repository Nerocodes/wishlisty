<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testCanRegisterUser()
    {
        $password = $this->faker->password(8);
        $response = $this->postJson('/api/auth/register', [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'message',
                     'user' => ['id', 'name', 'email'],
                 ])
                 ->assertJsonFragment(['message' => 'User registered successfully']);
    }

    public function testCanLoginUser()
    {
        $user = User::factory()->create([
            'password' => bcrypt($password = 'password123'),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'message',
                     'user' => ['id', 'name', 'email'],
                     'token',
                 ])
                 ->assertJsonFragment(['message' => 'Login successful']);
    }

    public function testCannotLoginWithInvalidCredentials()
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'emaildoes@notexist.com',
            'password' => 'wrongpassword',
        ]);
        $response->assertStatus(401)
                 ->assertJsonFragment(['message' => 'Invalid credentials']);
    }

    public function testCanLogoutUser()
    {
        $user = \App\Models\User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->withHeaders(['Authorization' => "Bearer $token"])
                         ->postJson('/api/auth/logout');

        $response->assertStatus(200)
                 ->assertJsonFragment(['message' => 'Logged out successfully']);
    }
}

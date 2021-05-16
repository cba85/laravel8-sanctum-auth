<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_login_attempt_without_data()
    {
        $response = $this->json('POST', 'api/auth/login')->assertJsonStructure(['errors']);
        $response->assertStatus(422);
    }

    public function test_login_attempt_bad_parameters()
    {
        $data = [
            'email' => $this->faker->email,
            'password' => $this->faker->password(4),
            'device_name' => "ios"
        ];

        $response = $this->json('POST', 'api/auth/login', $data)->assertJsonStructure(['errors']);
        $response->assertStatus(422);
    }

    public function test_login_attempt_success()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => Hash::make($this->faker->password(8)),
        ];

        $user = User::create($data);

        $payload = [
            'email',
            'name',
            'token',
            'created_at'
        ];

        $response = $this->json('POST', 'api/auth/login', array_merge($data, ['device_name' => "ios"]));
        $this->assertDatabaseHas('users', $data);
    }

    public function test_login_attempt_with_invalid_credentials()
    {
        $data = [
            'email' => $this->faker->email,
            'password' => $this->faker->password(8),
            'device_name' => "ios"
        ];

        $response = $this->json('POST', 'api/auth/login', $data)->assertJsonStructure(['errors']);
        $response->assertStatus(422);
    }
}

<?php

namespace Tests\Feature\API;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_user_create()
    {
        $response = $this->get('/api/users/create');

        $response->assertStatus(405)->assertJson([
            'message' => 'Method Not Allowed',
        ]);
    }

    public function test_api_user_store()
    {
        $payload = [
            'name' => 'User name',
            'email' => 'mail@example.com',
            'password' => 'password123',
        ];
        $response = $this->postJson('/api/users', $payload);

        $response->assertStatus(201)->assertJson([
            'data' => [
                'name' => 'User name',
                'email' => 'mail@example.com',
            ],
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'mail@example.com',
        ]);
    }

    public function test_api_user_show()
    {
        $user = User::factory()->create();
        $response = $this->get('/api/users/' . $user->id);

        $response->assertStatus(200)->assertJson([
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'ip_address' => $user->ip_address,
            ]
        ]);
    }

    public function test_api_user_edit()
    {
        $user = User::factory()->create();
        $response = $this->get('/api/users/' . $user->id . '/edit');

        $response->assertStatus(405)->assertJson([
            'message' => 'Method Not Allowed',
        ]);
    }

    public function test_api_user_update()
    {
        $user = User::factory()->create();
        $response = $this->putJson('/api/users/' . $user->id, [
            'name' => 'Updated name',
            'email' => 'updated@example.com',
        ]);

        $response->assertStatus(200)->assertJson([
            'data' => [
                'id' => $user->id,
                'name' => 'Updated name',
                'email' => 'updated@example.com',
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'ip_address' => $user->ip_address,
            ]
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Updated name',
            'email' => 'updated@example.com',
        ]);
    }

    public function test_api_user_delete()
    {
        $user = User::factory()->create();
        $response = $this->deleteJson('/api/users/' . $user->id);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }
}

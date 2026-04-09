<?php

use App\Models\User;

/*
|--------------------------------------------------------------------------
| Admin Auth API Tests
|--------------------------------------------------------------------------
*/

it('logs in with valid credentials', function () {
    User::factory()->create([
        'email' => 'admin@test.com',
        'password' => bcrypt('password'),
    ]);

    $response = $this->postJson('/api/admin/login', [
        'email' => 'admin@test.com',
        'password' => 'password',
    ]);

    $response->assertOk()
        ->assertJsonStructure(['user', 'token'])
        ->assertJsonFragment(['email' => 'admin@test.com']);
});

it('rejects invalid credentials', function () {
    User::factory()->create([
        'email' => 'admin@test.com',
        'password' => bcrypt('password'),
    ]);

    $response = $this->postJson('/api/admin/login', [
        'email' => 'admin@test.com',
        'password' => 'wrong-password',
    ]);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['email']);
});

it('validates login fields', function () {
    $response = $this->postJson('/api/admin/login', []);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['email', 'password']);
});

it('returns current user via /me', function () {
    authAdmin();

    $response = $this->getJson('/api/admin/me');

    $response->assertOk()
        ->assertJsonStructure(['user']);
});

it('logs out the user', function () {
    $user = createAdmin();
    $token = $user->createToken('test-token')->plainTextToken;

    $response = $this->withHeader('Authorization', "Bearer {$token}")
        ->postJson('/api/admin/logout');

    $response->assertOk()
        ->assertJsonFragment(['message' => 'Sessão terminada com sucesso.']);
});

it('returns 401 for unauthenticated admin routes', function () {
    $response = $this->getJson('/api/admin/me');

    $response->assertUnauthorized();
});

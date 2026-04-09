<?php

use App\Models\Lead;

/*
|--------------------------------------------------------------------------
| Public Contact API Tests
|--------------------------------------------------------------------------
*/

it('sends a contact message', function () {
    $response = $this->postJson('/api/contact', [
        'name' => 'João Silva',
        'email' => 'joao@example.com',
        'phone' => '+244 923 456 789',
        'subject' => 'Informação sobre produtos',
        'message' => 'Gostaria de saber mais sobre os vossos sofás.',
        'source' => 'contact_form',
    ]);

    $response->assertCreated()
        ->assertJsonFragment(['message' => 'Mensagem enviada com sucesso. Entraremos em contacto brevemente.']);

    $this->assertDatabaseHas('leads', ['email' => 'joao@example.com']);
});

it('validates required fields on contact', function () {
    $response = $this->postJson('/api/contact', []);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['name', 'email', 'message']);
});

it('validates email format on contact', function () {
    $response = $this->postJson('/api/contact', [
        'name' => 'Test',
        'email' => 'not-an-email',
        'message' => 'Hello',
        'source' => 'contact_form',
    ]);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['email']);
});

it('validates source is valid on contact', function () {
    $response = $this->postJson('/api/contact', [
        'name' => 'Test',
        'email' => 'test@example.com',
        'message' => 'Hello',
        'source' => 'invalid_source',
    ]);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['source']);
});

<?php

use App\Models\Lead;

/*
|--------------------------------------------------------------------------
| Admin Lead API Tests
|--------------------------------------------------------------------------
*/

it('lists leads for admin', function () {
    authAdmin();
    Lead::factory()->count(5)->create();

    $response = $this->getJson('/api/admin/leads');

    $response->assertOk();
});

it('filters leads by status', function () {
    authAdmin();
    Lead::factory()->count(2)->create(['status' => 'new']);
    Lead::factory()->count(3)->create(['status' => 'contacted']);

    $response = $this->getJson('/api/admin/leads?status=new');

    $response->assertOk();
});

it('shows a lead by id', function () {
    authAdmin();
    $lead = Lead::factory()->create();

    $response = $this->getJson("/api/admin/leads/{$lead->id}");

    $response->assertOk()
        ->assertJsonStructure(['data']);
});

it('updates lead status', function () {
    authAdmin();
    $lead = Lead::factory()->create(['status' => 'new']);

    $response = $this->putJson("/api/admin/leads/{$lead->id}/status", [
        'status' => 'contacted',
        'notes' => 'Contactado por telefone.',
    ]);

    $response->assertOk()
        ->assertJsonFragment(['message' => 'Estado do contacto atualizado.']);

    $this->assertDatabaseHas('leads', ['id' => $lead->id, 'status' => 'contacted']);
});

it('validates lead status value', function () {
    authAdmin();
    $lead = Lead::factory()->create();

    $response = $this->putJson("/api/admin/leads/{$lead->id}/status", [
        'status' => 'invalid_status',
    ]);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['status']);
});

it('deletes a lead', function () {
    authAdmin();
    $lead = Lead::factory()->create();

    $response = $this->deleteJson("/api/admin/leads/{$lead->id}");

    $response->assertOk()
        ->assertJsonFragment(['message' => 'Contacto eliminado com sucesso.']);

    $this->assertDatabaseMissing('leads', ['id' => $lead->id]);
});

it('requires auth for admin leads', function () {
    $response = $this->getJson('/api/admin/leads');

    $response->assertUnauthorized();
});

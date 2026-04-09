<?php

use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Admin Project API Tests
|--------------------------------------------------------------------------
*/

it('lists projects for admin', function () {
    authAdmin();
    Project::factory()->count(3)->create();

    $response = $this->getJson('/api/admin/projects');

    $response->assertOk();
});

it('creates a project', function () {
    authAdmin();

    $response = $this->postJson('/api/admin/projects', [
        'title' => 'Projeto Teste',
        'description' => 'Descrição do projeto.',
        'location' => 'Luanda',
        'is_active' => true,
        'is_featured' => false,
    ]);

    $response->assertCreated()
        ->assertJsonFragment(['message' => 'Projeto criado com sucesso.']);

    $this->assertDatabaseHas('projects', ['title' => 'Projeto Teste']);
});

it('validates project creation', function () {
    authAdmin();

    $response = $this->postJson('/api/admin/projects', []);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['title']);
});

it('shows a project by id', function () {
    authAdmin();
    $project = Project::factory()->create();

    $response = $this->getJson("/api/admin/projects/{$project->id}");

    $response->assertOk();
});

it('updates a project', function () {
    authAdmin();
    $project = Project::factory()->create();

    $response = $this->putJson("/api/admin/projects/{$project->id}", [
        'title' => 'Projeto Atualizado',
    ]);

    $response->assertOk()
        ->assertJsonFragment(['message' => 'Projeto atualizado com sucesso.']);

    $this->assertDatabaseHas('projects', ['id' => $project->id, 'title' => 'Projeto Atualizado']);
});

it('deletes a project', function () {
    authAdmin();
    $project = Project::factory()->create();

    $response = $this->deleteJson("/api/admin/projects/{$project->id}");

    $response->assertOk()
        ->assertJsonFragment(['message' => 'Projeto eliminado com sucesso.']);

    $this->assertDatabaseMissing('projects', ['id' => $project->id]);
});

it('uploads an image to a project', function () {
    authAdmin();
    Storage::fake('public');
    $project = Project::factory()->create();
    $file = UploadedFile::fake()->image('project.jpg', 800, 600);

    $response = $this->postJson("/api/admin/projects/{$project->id}/images", [
        'image' => $file,
    ]);

    $response->assertCreated()
        ->assertJsonFragment(['message' => 'Imagem carregada com sucesso.']);
});

it('deletes an image from a project', function () {
    authAdmin();
    Storage::fake('public');
    $image = ProjectImage::factory()->create();

    $response = $this->deleteJson("/api/admin/projects/{$image->project_id}/images/{$image->id}");

    $response->assertOk()
        ->assertJsonFragment(['message' => 'Imagem eliminada com sucesso.']);

    $this->assertDatabaseMissing('project_images', ['id' => $image->id]);
});

it('requires auth for admin projects', function () {
    $response = $this->getJson('/api/admin/projects');

    $response->assertUnauthorized();
});

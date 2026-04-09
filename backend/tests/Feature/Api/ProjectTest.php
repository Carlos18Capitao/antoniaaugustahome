<?php

use App\Models\Project;

/*
|--------------------------------------------------------------------------
| Public Project API Tests
|--------------------------------------------------------------------------
*/

it('lists projects', function () {
    Project::factory()->count(3)->create(['is_active' => true]);

    $response = $this->getJson('/api/projects');

    $response->assertOk();
});

it('shows a project by slug', function () {
    $project = Project::factory()->create(['is_active' => true]);

    $response = $this->getJson("/api/projects/{$project->slug}");

    $response->assertOk();
});

it('returns 404 for non-existent project slug', function () {
    $response = $this->getJson('/api/projects/non-existent-slug');

    $response->assertNotFound();
});

it('returns featured projects', function () {
    Project::factory()->count(2)->featured()->create();
    Project::factory()->count(3)->create();

    $response = $this->getJson('/api/projects/featured');

    $response->assertOk()
        ->assertJsonStructure(['data']);
});

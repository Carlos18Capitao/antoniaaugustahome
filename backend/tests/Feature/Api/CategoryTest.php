<?php

use App\Models\Category;

/*
|--------------------------------------------------------------------------
| Public Category API Tests
|--------------------------------------------------------------------------
*/

it('lists active categories', function () {
    Category::factory()->count(3)->create(['is_active' => true]);
    Category::factory()->create(['is_active' => false]);

    $response = $this->getJson('/api/categories');

    $response->assertOk()
        ->assertJsonStructure(['data']);
});

it('shows a category by slug', function () {
    $category = Category::factory()->create(['is_active' => true]);

    $response = $this->getJson("/api/categories/{$category->slug}");

    $response->assertOk();
});

it('returns 404 for non-existent category slug', function () {
    $response = $this->getJson('/api/categories/non-existent-slug');

    $response->assertNotFound();
});

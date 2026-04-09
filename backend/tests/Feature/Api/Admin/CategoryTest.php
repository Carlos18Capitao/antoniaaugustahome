<?php

use App\Models\Category;
use App\Models\Product;

/*
|--------------------------------------------------------------------------
| Admin Category API Tests
|--------------------------------------------------------------------------
*/

it('lists categories for admin', function () {
    authAdmin();
    Category::factory()->count(3)->create();

    $response = $this->getJson('/api/admin/categories');

    $response->assertOk();
});

it('creates a category', function () {
    authAdmin();

    $response = $this->postJson('/api/admin/categories', [
        'name' => 'Sofás Premium',
        'description' => 'Categoria de sofás premium.',
        'is_active' => true,
    ]);

    $response->assertCreated()
        ->assertJsonFragment(['message' => 'Categoria criada com sucesso.']);

    $this->assertDatabaseHas('categories', ['name' => 'Sofás Premium']);
});

it('validates category creation', function () {
    authAdmin();

    $response = $this->postJson('/api/admin/categories', []);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['name']);
});

it('shows a category by id', function () {
    authAdmin();
    $category = Category::factory()->create();

    $response = $this->getJson("/api/admin/categories/{$category->id}");

    $response->assertOk();
});

it('updates a category', function () {
    authAdmin();
    $category = Category::factory()->create();

    $response = $this->putJson("/api/admin/categories/{$category->id}", [
        'name' => 'Categoria Atualizada',
    ]);

    $response->assertOk()
        ->assertJsonFragment(['message' => 'Categoria atualizada com sucesso.']);

    $this->assertDatabaseHas('categories', ['id' => $category->id, 'name' => 'Categoria Atualizada']);
});

it('deletes a category without products', function () {
    authAdmin();
    $category = Category::factory()->create();

    $response = $this->deleteJson("/api/admin/categories/{$category->id}");

    $response->assertOk()
        ->assertJsonFragment(['message' => 'Categoria eliminada com sucesso.']);

    $this->assertDatabaseMissing('categories', ['id' => $category->id]);
});

it('cannot delete a category with products', function () {
    authAdmin();
    $category = Category::factory()->create();
    Product::factory()->create(['category_id' => $category->id]);

    $response = $this->deleteJson("/api/admin/categories/{$category->id}");

    $response->assertUnprocessable();
});

it('requires auth for admin categories', function () {
    $response = $this->getJson('/api/admin/categories');

    $response->assertUnauthorized();
});

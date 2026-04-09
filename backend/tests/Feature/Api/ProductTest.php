<?php

use App\Models\Category;
use App\Models\Product;

/*
|--------------------------------------------------------------------------
| Public Product API Tests
|--------------------------------------------------------------------------
*/

it('lists products', function () {
    Product::factory()->count(3)->create(['is_active' => true]);

    $response = $this->getJson('/api/products');

    $response->assertOk()
        ->assertJsonStructure(['data']);
});

it('lists products with pagination', function () {
    Product::factory()->count(15)->create(['is_active' => true]);

    $response = $this->getJson('/api/products?per_page=5');

    $response->assertOk();
});

it('filters products by category slug', function () {
    $category = Category::factory()->create();
    Product::factory()->count(2)->create(['category_id' => $category->id, 'is_active' => true]);
    Product::factory()->count(3)->create(['is_active' => true]);

    $response = $this->getJson("/api/products?category_slug={$category->slug}");

    $response->assertOk();
});

it('returns featured products', function () {
    Product::factory()->count(2)->featured()->create();
    Product::factory()->count(3)->create();

    $response = $this->getJson('/api/products/featured?limit=5');

    $response->assertOk()
        ->assertJsonStructure(['data']);
});

it('shows a single product by slug', function () {
    $product = Product::factory()->create(['is_active' => true]);

    $response = $this->getJson("/api/products/{$product->slug}");

    $response->assertOk();
});

it('returns 404 for non-existent product slug', function () {
    $response = $this->getJson('/api/products/non-existent-slug');

    $response->assertNotFound();
});

it('returns related products', function () {
    $category = Category::factory()->create();
    $product = Product::factory()->create(['category_id' => $category->id, 'is_active' => true]);
    Product::factory()->count(3)->create(['category_id' => $category->id, 'is_active' => true]);

    $response = $this->getJson("/api/products/{$product->slug}/related");

    $response->assertOk()
        ->assertJsonStructure(['data']);
});

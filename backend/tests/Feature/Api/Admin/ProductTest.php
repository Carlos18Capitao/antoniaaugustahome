<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Admin Product API Tests
|--------------------------------------------------------------------------
*/

it('lists products for admin', function () {
    authAdmin();
    Product::factory()->count(3)->create();

    $response = $this->getJson('/api/admin/products');

    $response->assertOk();
});

it('creates a product', function () {
    authAdmin();
    $category = Category::factory()->create();

    $response = $this->postJson('/api/admin/products', [
        'name' => 'Sofá Teste',
        'description' => 'Um sofá de teste.',
        'price' => 1500.00,
        'category_id' => $category->id,
        'is_active' => true,
        'is_featured' => false,
        'is_available' => true,
    ]);

    $response->assertCreated()
        ->assertJsonFragment(['message' => 'Produto criado com sucesso.']);

    $this->assertDatabaseHas('products', ['name' => 'Sofá Teste']);
});

it('validates product creation', function () {
    authAdmin();

    $response = $this->postJson('/api/admin/products', []);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['name', 'category_id']);
});

it('shows a product by id', function () {
    authAdmin();
    $product = Product::factory()->create();

    $response = $this->getJson("/api/admin/products/{$product->id}");

    $response->assertOk();
});

it('updates a product', function () {
    authAdmin();
    $product = Product::factory()->create();

    $response = $this->putJson("/api/admin/products/{$product->id}", [
        'name' => 'Sofá Atualizado',
        'category_id' => $product->category_id,
    ]);

    $response->assertOk()
        ->assertJsonFragment(['message' => 'Produto atualizado com sucesso.']);

    $this->assertDatabaseHas('products', ['id' => $product->id, 'name' => 'Sofá Atualizado']);
});

it('deletes a product', function () {
    authAdmin();
    $product = Product::factory()->create();

    $response = $this->deleteJson("/api/admin/products/{$product->id}");

    $response->assertOk()
        ->assertJsonFragment(['message' => 'Produto eliminado com sucesso.']);

    $this->assertDatabaseMissing('products', ['id' => $product->id]);
});

it('uploads an image to a product', function () {
    authAdmin();
    Storage::fake('public');
    $product = Product::factory()->create();
    $file = UploadedFile::fake()->image('sofa.jpg', 800, 600);

    $response = $this->postJson("/api/admin/products/{$product->id}/images", [
        'image' => $file,
        'is_primary' => true,
    ]);

    $response->assertCreated()
        ->assertJsonFragment(['message' => 'Imagem carregada com sucesso.']);
});

it('deletes an image from a product', function () {
    authAdmin();
    Storage::fake('public');
    $image = ProductImage::factory()->create();

    $response = $this->deleteJson("/api/admin/products/{$image->product_id}/images/{$image->id}");

    $response->assertOk()
        ->assertJsonFragment(['message' => 'Imagem eliminada com sucesso.']);

    $this->assertDatabaseMissing('product_images', ['id' => $image->id]);
});

it('reorders product images', function () {
    authAdmin();
    $product = Product::factory()->create();
    $img1 = ProductImage::factory()->create(['product_id' => $product->id, 'sort_order' => 0]);
    $img2 = ProductImage::factory()->create(['product_id' => $product->id, 'sort_order' => 1]);

    $response = $this->putJson("/api/admin/products/{$product->id}/images/reorder", [
        'image_ids' => [$img2->id, $img1->id],
    ]);

    $response->assertOk()
        ->assertJsonFragment(['message' => 'Ordem das imagens atualizada.']);
});

it('requires auth for admin products', function () {
    $response = $this->getJson('/api/admin/products');

    $response->assertUnauthorized();
});

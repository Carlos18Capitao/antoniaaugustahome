<?php

/*
|--------------------------------------------------------------------------
| Public PageView API Tests
|--------------------------------------------------------------------------
*/

it('tracks a page view', function () {
    $response = $this->postJson('/api/page-views', [
        'page' => '/catalogo',
    ]);

    $response->assertOk()
        ->assertJsonFragment(['status' => 'ok']);

    $this->assertDatabaseHas('page_views', ['page' => '/catalogo']);
});

it('validates page is required', function () {
    $response = $this->postJson('/api/page-views', []);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['page']);
});

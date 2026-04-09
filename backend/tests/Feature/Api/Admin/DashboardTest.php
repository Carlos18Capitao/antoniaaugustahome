<?php

use App\Models\Product;

/*
|--------------------------------------------------------------------------
| Admin Dashboard API Tests
|--------------------------------------------------------------------------
*/

it('returns dashboard metrics', function () {
    authAdmin();

    $response = $this->getJson('/api/admin/dashboard');

    $response->assertOk()
        ->assertJsonStructure(['metrics', 'recent_leads', 'popular_products']);
});

it('returns views chart data', function () {
    authAdmin();

    $response = $this->getJson('/api/admin/dashboard/views-chart');

    $response->assertOk()
        ->assertJsonStructure(['data']);
});

it('requires auth for dashboard', function () {
    $response = $this->getJson('/api/admin/dashboard');

    $response->assertUnauthorized();
});

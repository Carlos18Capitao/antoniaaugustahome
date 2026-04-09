<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\PageViewController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Api\Admin\DashboardController;
use App\Http\Controllers\Api\Admin\LeadController;
use App\Http\Controllers\Api\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Api\Admin\ProjectController as AdminProjectController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public API Routes
|--------------------------------------------------------------------------
*/

// Products
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/featured', [ProductController::class, 'featured']);
Route::get('/products/{slug}', [ProductController::class, 'show']);
Route::get('/products/{slug}/related', [ProductController::class, 'related']);

// Categories
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{slug}', [CategoryController::class, 'show']);

// Projects
Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/projects/featured', [ProjectController::class, 'featured']);
Route::get('/projects/{slug}', [ProjectController::class, 'show']);

// Contact
Route::post('/contact', [ContactController::class, 'store']);

// Page Views (analytics)
Route::post('/page-views', [PageViewController::class, 'store']);

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

Route::post('/admin/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Admin Protected Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/dashboard/views-chart', [DashboardController::class, 'viewsChart']);

    // Products
    Route::apiResource('/products', AdminProductController::class);
    Route::post('/products/{id}/images', [AdminProductController::class, 'uploadImage']);
    Route::delete('/products/{id}/images/{imageId}', [AdminProductController::class, 'deleteImage']);
    Route::put('/products/{id}/images/reorder', [AdminProductController::class, 'reorderImages']);

    // Categories
    Route::apiResource('/categories', AdminCategoryController::class);

    // Projects
    Route::apiResource('/projects', AdminProjectController::class);
    Route::post('/projects/{id}/images', [AdminProjectController::class, 'uploadImage']);
    Route::delete('/projects/{id}/images/{imageId}', [AdminProjectController::class, 'deleteImage']);

    // Leads
    Route::get('/leads', [LeadController::class, 'index']);
    Route::get('/leads/{id}', [LeadController::class, 'show']);
    Route::put('/leads/{id}/status', [LeadController::class, 'updateStatus']);
    Route::delete('/leads/{id}', [LeadController::class, 'destroy']);
});

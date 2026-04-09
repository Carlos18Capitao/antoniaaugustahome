<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryService $categoryService
    ) {}

    public function index(): JsonResponse
    {
        $categories = $this->categoryService->listActive();
        return response()->json([
            'data' => CategoryResource::collection($categories),
        ]);
    }

    public function show(string $slug): CategoryResource
    {
        $category = $this->categoryService->findBySlug($slug);
        return new CategoryResource($category);
    }
}

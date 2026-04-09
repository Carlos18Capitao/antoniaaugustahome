<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryService $categoryService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $categories = $this->categoryService->adminList($request->integer('per_page', 15));
        return response()->json($categories);
    }

    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $category = $this->categoryService->create($data);

        return response()->json([
            'message' => 'Categoria criada com sucesso.',
            'data' => new CategoryResource($category),
        ], 201);
    }

    public function show(int $id): CategoryResource
    {
        return new CategoryResource($this->categoryService->find($id));
    }

    public function update(StoreCategoryRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $category = $this->categoryService->update($id, $data);

        return response()->json([
            'message' => 'Categoria atualizada com sucesso.',
            'data' => new CategoryResource($category),
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->categoryService->delete($id);
            return response()->json(['message' => 'Categoria eliminada com sucesso.']);
        } catch (\RuntimeException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }
}

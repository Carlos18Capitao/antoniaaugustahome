<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\UploadImageRequest;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductService $productService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['category', 'search', 'is_active']);
        $products = $this->productService->adminList($filters, $request->integer('per_page', 15));

        return response()->json($products);
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = $this->productService->create($request->validated());

        return response()->json([
            'message' => 'Produto criado com sucesso.',
            'data' => new ProductResource($product->load(['category', 'images'])),
        ], 201);
    }

    public function show(int $id): ProductResource
    {
        $product = $this->productService->find($id);
        return new ProductResource($product);
    }

    public function update(UpdateProductRequest $request, int $id): JsonResponse
    {
        $product = $this->productService->update($id, $request->validated());

        return response()->json([
            'message' => 'Produto atualizado com sucesso.',
            'data' => new ProductResource($product),
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->productService->delete($id);

        return response()->json([
            'message' => 'Produto eliminado com sucesso.',
        ]);
    }

    public function uploadImage(UploadImageRequest $request, int $id): JsonResponse
    {
        $image = $this->productService->uploadImage(
            $id,
            $request->file('image'),
            $request->boolean('is_primary')
        );

        return response()->json([
            'message' => 'Imagem carregada com sucesso.',
            'data' => $image,
        ], 201);
    }

    public function deleteImage(int $id, int $imageId): JsonResponse
    {
        $this->productService->deleteImage($imageId);

        return response()->json([
            'message' => 'Imagem eliminada com sucesso.',
        ]);
    }

    public function reorderImages(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'image_ids' => 'required|array',
            'image_ids.*' => 'integer|exists:product_images,id',
        ]);

        $this->productService->reorderImages($id, $request->input('image_ids'));

        return response()->json([
            'message' => 'Ordem das imagens atualizada.',
        ]);
    }
}

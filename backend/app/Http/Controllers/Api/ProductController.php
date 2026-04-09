<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\UploadImageRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductService $productService
    ) {}

    /**
     * Public product listing with filters.
     */
    public function index(Request $request): ProductCollection
    {
        $filters = $request->only(['category', 'category_slug', 'featured', 'search']);
        $products = $this->productService->list($filters, $request->integer('per_page', 12));

        return new ProductCollection($products);
    }

    /**
     * Public product detail by slug.
     */
    public function show(string $slug): ProductResource
    {
        $product = $this->productService->findBySlug($slug);
        return new ProductResource($product);
    }

    /**
     * Featured products for homepage.
     */
    public function featured(Request $request): JsonResponse
    {
        $products = $this->productService->getFeatured($request->integer('limit', 8));
        return response()->json([
            'data' => ProductResource::collection($products),
        ]);
    }

    /**
     * Related products.
     */
    public function related(string $slug): JsonResponse
    {
        $product = $this->productService->findBySlug($slug);
        $related = $this->productService->getRelated($product);

        return response()->json([
            'data' => ProductResource::collection($related),
        ]);
    }
}

<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ProductService
{
    public function list(array $filters = [], int $perPage = 12): LengthAwarePaginator
    {
        $query = Product::with(['category', 'primaryImage'])
            ->active()
            ->ordered();

        if (!empty($filters['category'])) {
            $query->where('category_id', $filters['category']);
        }

        if (!empty($filters['category_slug'])) {
            $query->whereHas('category', function ($q) use ($filters) {
                $q->where('slug', $filters['category_slug']);
            });
        }

        if (!empty($filters['featured'])) {
            $query->featured();
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        return $query->paginate($perPage);
    }

    public function adminList(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Product::with(['category', 'primaryImage'])->ordered();

        if (!empty($filters['category'])) {
            $query->where('category_id', $filters['category']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }

        return $query->paginate($perPage);
    }

    public function findBySlug(string $slug): Product
    {
        $product = Product::with(['category', 'images'])
            ->where('slug', $slug)
            ->active()
            ->firstOrFail();

        $product->incrementViews();

        return $product;
    }

    public function find(int $id): Product
    {
        return Product::with(['category', 'images'])->findOrFail($id);
    }

    public function create(array $data): Product
    {
        return DB::transaction(function () use ($data) {
            $product = Product::create($data);
            return $product;
        });
    }

    public function update(int $id, array $data): Product
    {
        return DB::transaction(function () use ($id, $data) {
            $product = Product::findOrFail($id);
            $product->update($data);
            return $product->fresh(['category', 'images']);
        });
    }

    public function delete(int $id): void
    {
        DB::transaction(function () use ($id) {
            $product = Product::with('images')->findOrFail($id);

            foreach ($product->images as $image) {
                $this->deleteImageFile($image);
            }

            $product->delete();
        });
    }

    public function uploadImage(int $productId, UploadedFile $file, bool $isPrimary = false): ProductImage
    {
        $product = Product::findOrFail($productId);

        $path = $file->store('products/' . $product->id, 'public');

        // Create thumbnail
        $thumbnail = $this->createThumbnail($file, $product->id);

        if ($isPrimary) {
            $product->images()->update(['is_primary' => false]);
        }

        $sortOrder = $product->images()->max('sort_order') + 1;

        return $product->images()->create([
            'path' => $path,
            'thumbnail' => $thumbnail,
            'alt_text' => $product->name,
            'is_primary' => $isPrimary || $product->images()->count() === 0,
            'sort_order' => $sortOrder,
        ]);
    }

    public function deleteImage(int $imageId): void
    {
        $image = ProductImage::findOrFail($imageId);
        $this->deleteImageFile($image);
        $image->delete();
    }

    public function reorderImages(int $productId, array $imageIds): void
    {
        foreach ($imageIds as $index => $imageId) {
            ProductImage::where('id', $imageId)
                ->where('product_id', $productId)
                ->update(['sort_order' => $index]);
        }
    }

    public function getFeatured(int $limit = 8)
    {
        return Product::with(['category', 'primaryImage'])
            ->active()
            ->featured()
            ->ordered()
            ->limit($limit)
            ->get();
    }

    public function getRelated(Product $product, int $limit = 4)
    {
        return Product::with(['primaryImage'])
            ->active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }

    private function createThumbnail(UploadedFile $file, int $productId): string
    {
        $thumbnailPath = 'products/' . $productId . '/thumbs';
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();

        Storage::disk('public')->makeDirectory($thumbnailPath);

        $image = Image::read($file->getPathname());
        $image->scale(width: (int) config('app.thumbnail_width', 400));

        $fullPath = Storage::disk('public')->path($thumbnailPath . '/' . $filename);
        $image->save($fullPath, quality: (int) config('app.image_quality', 85));

        return $thumbnailPath . '/' . $filename;
    }

    private function deleteImageFile(ProductImage $image): void
    {
        Storage::disk('public')->delete($image->path);
        if ($image->thumbnail) {
            Storage::disk('public')->delete($image->thumbnail);
        }
    }
}

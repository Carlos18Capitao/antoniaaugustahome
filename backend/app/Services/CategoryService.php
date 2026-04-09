<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryService
{
    public function listActive(): Collection
    {
        return Category::active()
            ->ordered()
            ->withCount('activeProducts')
            ->get();
    }

    public function adminList(int $perPage = 15): LengthAwarePaginator
    {
        return Category::ordered()
            ->withCount('products')
            ->paginate($perPage);
    }

    public function findBySlug(string $slug): Category
    {
        return Category::where('slug', $slug)
            ->active()
            ->firstOrFail();
    }

    public function find(int $id): Category
    {
        return Category::withCount('products')->findOrFail($id);
    }

    public function create(array $data): Category
    {
        return Category::create($data);
    }

    public function update(int $id, array $data): Category
    {
        $category = Category::findOrFail($id);
        $category->update($data);
        return $category->fresh();
    }

    public function delete(int $id): void
    {
        $category = Category::withCount('products')->findOrFail($id);

        if ($category->products_count > 0) {
            throw new \RuntimeException('Não é possível eliminar uma categoria com produtos associados.');
        }

        $category->delete();
    }
}

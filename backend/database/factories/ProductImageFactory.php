<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductImageFactory extends Factory
{
    protected $model = ProductImage::class;

    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'path' => 'products/1/test.jpg',
            'thumbnail' => 'products/1/thumbs/test.jpg',
            'alt_text' => fake()->sentence(3),
            'is_primary' => false,
            'sort_order' => 0,
        ];
    }
}

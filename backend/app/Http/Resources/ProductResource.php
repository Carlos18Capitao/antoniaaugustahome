<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'short_description' => $this->short_description,
            'price' => $this->price,
            'formatted_price' => $this->formatted_price,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'images' => ProductImageResource::collection($this->whenLoaded('images')),
            'primary_image' => new ProductImageResource($this->whenLoaded('primaryImage')),
            'is_featured' => $this->is_featured,
            'is_available' => $this->is_available,
            'is_active' => $this->is_active,
            'dimensions' => $this->dimensions,
            'materials' => $this->materials,
            'colors' => $this->colors,
            'views_count' => $this->views_count,
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'image' => $this->image ? asset('storage/' . $this->image) : null,
            'products_count' => $this->when(isset($this->active_products_count), $this->active_products_count),
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,
        ];
    }
}

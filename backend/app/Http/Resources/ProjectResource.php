<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'location' => $this->location,
            'client_name' => $this->client_name,
            'cover_image' => $this->cover_image ? asset('storage/' . $this->cover_image) : null,
            'images' => $this->whenLoaded('images', function () {
                return $this->images->map(function ($img) {
                    return [
                        'id' => $img->id,
                        'url' => $img->url,
                        'thumbnail_url' => $img->thumbnail_url,
                        'alt_text' => $img->alt_text,
                    ];
                });
            }),
            'is_featured' => $this->is_featured,
            'is_active' => $this->is_active,
            'completed_at' => $this->completed_at?->toDateString(),
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}

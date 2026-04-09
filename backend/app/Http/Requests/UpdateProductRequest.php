<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string|max:10000',
            'short_description' => 'nullable|string|max:500',
            'price' => 'nullable|numeric|min:0|max:999999.99',
            'category_id' => 'sometimes|required|exists:categories,id',
            'is_featured' => 'boolean',
            'is_available' => 'boolean',
            'is_active' => 'boolean',
            'dimensions' => 'nullable|string|max:255',
            'materials' => 'nullable|string|max:255',
            'colors' => 'nullable|string|max:255',
            'sort_order' => 'integer|min:0',
        ];
    }
}

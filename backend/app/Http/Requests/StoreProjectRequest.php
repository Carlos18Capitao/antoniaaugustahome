<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:10000',
            'location' => 'nullable|string|max:255',
            'client_name' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
            'completed_at' => 'nullable|date',
        ];
    }
}

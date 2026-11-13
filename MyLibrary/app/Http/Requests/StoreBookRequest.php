<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Permitir la operación por ahora
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'author_ids' => 'required|array|min:1',
            'author_ids.*' => 'integer|exists:authors,id',
            'category_ids'=>'nullable|array',
            'category_ids.*'=>'integer|exists:categories,id',
            'isbn' => 'required|string|unique:books,isbn',
            'total_copies' => 'required|integer|min:1',
            'available_copies' => 'required|integer|min:0|lte:total_copies',
        ];
    }
}

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
            'author_ids' => 'required|array',
            'author_ids.*' => 'integer|exists:authors,id',
            'isbn' => 'required|string|unique:books,isbn',
            'available_copies' => 'required|integer|min:0',
        ];
    }
}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLoanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'book_id' => 'required|integer|exists:books,id',
            'loan_date' => 'required|date',
            'return_date' => 'nullable|date|after_or_equal:loan_date',
            'status' => 'nullable|string|in:active,returned,overdue',
        ];
    }
}
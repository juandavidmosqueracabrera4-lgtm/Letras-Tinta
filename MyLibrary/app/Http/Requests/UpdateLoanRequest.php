<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// Clase encargada de validar los datos enviados al actualizar un préstamo
class UpdateLoanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    // Define las reglas de validación para actualizar los prestamos
    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'book_id' => 'required|integer|exists:books,id',
            'loan_date' => 'required|date',
        ];
    }
}

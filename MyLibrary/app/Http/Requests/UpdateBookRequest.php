<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

//Valida los datos enviados para actualizar un libro cumpliendo las reglas definidas
class UpdateBookRequest extends FormRequest
{
    //VALIDA SI ESTA PERMITIDO EL ACCESO A LA SOLICITUD
    public function authorize(): bool
    {
        return true;
    }

    // DEFINE LAS REGLAS DE LAS VALIDACIONES
    public function rules(): array
    {
        // OBTIENE EL ID DEL LIBRO QUE SE ESTA ACTUALIZANDO
        $id = $this->route('id');

        return [
            'title' => 'required|string|max:255',
            'author_ids' => 'required|array|min:1',
            //APLICA REGLA PARA EVITAR LOS ID DE LOS AUTORES QUE NO EXISTAN EN LA TABLA
            'author_ids.*' => 'integer|exists:authors,id',
            'category_ids' => 'nullable|array',
            //APLICA REGLA PARA EVITAR LOS ID DE LAS CATEGORIAS QUE NO EXISTAN EN LA TABLA
            'category_ids.*' => 'integer|exists:categories,id',
            //APLICA REGLA PARA EVITAR ISBN DUPLICADOS
            'isbn' => ['required','string',  Rule::unique('books', 'isbn')->ignore($id),],
            'available_copies' => 'required|integer|min:0',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'El ID del usuario es obligatorio',
            'user_id.exists' => 'El usuario no existe',
            'products.required' => 'Se requieren productos',
            'products.array' => 'Los productos deben ser un arreglo',
            'products.*.id.required' => 'El ID del producto es obligatorio',
            'products.*.id.exists' => 'El producto no existe',
            'products.*.quantity.required' => 'La cantidad es obligatoria',
            'products.*.quantity.min' => 'La cantidad debe ser al menos 1',
        ];
    }
}

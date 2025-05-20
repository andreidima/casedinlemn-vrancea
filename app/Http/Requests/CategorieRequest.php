<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategorieRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'nume' => 'required|string|max:100',
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'nume.required' => 'Numele categoriei este obligatoriu.',
            'nume.string'   => 'Numele categoriei trebuie să fie un text.',
            'nume.max'      => 'Numele categoriei nu poate avea mai mult de 100 de caractere.',
        ];
    }
}

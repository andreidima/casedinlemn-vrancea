<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'categorie_id'    => 'required|exists:categorii,id',
            'nume'            => 'required|string|max:255',
            'cantitate'       => 'nullable|integer',
            'prag_minim'      => 'required|integer',
            'data_procesare'  => 'nullable|date',
            'lungime'         => 'nullable|numeric',
            'latime'          => 'nullable|numeric',
            'grosime'         => 'nullable|numeric',
            'pret'            => 'nullable|numeric',
            'observatii'      => 'nullable|string',
        ];
    }
}

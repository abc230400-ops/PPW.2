<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateGeneroRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'nome' => 'required|string|min:2|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'nome.string' => 'O nome deve ser uma string.',
            'nome.required' => 'O nome do gênero é obrigatório.',
            'nome.min' => 'O nome do gênero deve ter pelo menos 2 caracteres.',
            'nome.max' => 'O nome do gênero deve ter no máximo 100 caracteres.',
            ];
    }
}

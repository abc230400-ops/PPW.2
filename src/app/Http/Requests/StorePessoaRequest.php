<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePessoaRequest extends FormRequest
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
        'cpf'             => 'required|unique:pessoa,cpf',
        'nome'            => 'required',
        'data_nascimento' => 'required|date',
        'biografia'       => 'nullable',
        'genero'          => 'nullable',
        'nacionalidade'   => 'nullable',
    ];
}

public function messages(): array
{
    return [
        'cpf.required'             => 'O CPF é obrigatório.',
        'cpf.unique'               => 'Esse CPF já está cadastrado.',
        'nome.required'            => 'O nome é obrigatório.',
        'data_nascimento.required' => 'A data de nascimento é obrigatória.',
        'data_nascimento.date'     => 'Informe uma data válida.',
    ];
}
}



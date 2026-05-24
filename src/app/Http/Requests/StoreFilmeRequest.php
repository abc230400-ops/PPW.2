<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreFilmeRequest extends FormRequest
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
            'nome' => 'required|string|min:2|max:255',
            'duracao' => 'required|string|min:1',
            'data_lancamento' => 'required|date',
            'classificacao' => 'required|string|max:2000',
            'sinopse' => 'required|string|max:2000',

        ];
    }

    public function messages(): array
    {
        return [
            'nome.required'            => 'O nome do filme é obrigatório.',
            'duracao.required'         => 'A duração é obrigatória.',
            'data_lancamento.required' => 'A data de lançamento é obrigatória.',
            'data_lancamento.date'     => 'Informe uma data válida.',
            'classificacao.required'   => 'A classificação é obrigatória.',
            'sinopse.required'         => 'A sinopse é obrigatória.',
        ];
    }
}

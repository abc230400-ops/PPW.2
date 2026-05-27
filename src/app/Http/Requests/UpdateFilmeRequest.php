<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFilmeRequest extends FormRequest
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

        $id = $this->route('filme');

        return [
            'nome' => 'required|string|min:2|max:255',
            'duracao' => 'required|string|min:1',
            'data_lancamento' => 'required|date',
            'classificacao' => 'required|string|max:2000',
            'sinopse' => 'required|string|max:2000',
            // Novas imagens — opcionais no update
            'imagens' => 'sometimes|nullable|array|max:5',
            'imagens.*' => 'image|mimes:jpeg,png,webp|max:2048',
            // Índice do poster entre as novas imagens enviadas
            'poster_index' => 'nullable|integer|min:0',
            // ID de imagem existente para definir como poster
            'poster_imagem_id' => 'nullable|integer',

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

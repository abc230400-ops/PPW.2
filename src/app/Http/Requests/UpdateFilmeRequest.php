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
            'imagens' => 'sometimes|nullable|array|max:5',
            'imagens.*' => 'image|mimes:jpeg,png,webp|max:2048',
            'poster_index' => 'nullable|integer|min:0',
            'poster_imagem_id' => 'nullable|integer',
            'vinculos' => 'nullable|array',
            'vinculos.*.pessoa_id' => 'required_with:vinculos|integer|exists:pessoa,id',
            'vinculos.*.tipo' => 'required_with:vinculos|in:ator,diretor,produtor,escritor',
            'vinculos.*.papel' => 'nullable|max:100',
            'remover_vinculos' => 'nullable|array',
            'remover_vinculos.atores' => 'nullable|array',
            'remover_vinculos.atores.*' => 'integer|exists:ator,id',
            'remover_vinculos.diretores' => 'nullable|array',
            'remover_vinculos.diretores.*' => 'integer|exists:diretor,id',
            'remover_vinculos.produtores' => 'nullable|array',
            'remover_vinculos.produtores.*' => 'integer|exists:produtor,id',
            'remover_vinculos.escritores' => 'nullable|array',
            'remover_vinculos.escritores.*' => 'integer|exists:escritor,id',
            'atores_existentes' => 'nullable|array',
            'atores_existentes.*.papel' => 'nullable|max:100',

        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O nome do filme é obrigatório.',
            'duracao.required' => 'A duração é obrigatória.',
            'data_lancamento.required' => 'A data de lançamento é obrigatória.',
            'data_lancamento.date' => 'Informe uma data válida.',
            'classificacao.required' => 'A classificação é obrigatória.',
            'sinopse.required' => 'A sinopse é obrigatória.',
        ];
    }
}

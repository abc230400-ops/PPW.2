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
            // Valida o array de imagens
            'imagens' => 'required|array|min:1|max:5',
            'imagens.*' => 'image|mimes:jpeg,png,webp|max:2048',
            'vinculos' => 'nullable|array',
            'vinculos.*.pessoa_id' => 'required_with:vinculos|integer|exists:pessoa,id',
            'vinculos.*.tipo' => 'required_with:vinculos|in:ator,diretor,produtor,escritor',
            'vinculos.*.papel' => 'nullable|max:100',

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
            'imagens.required' => 'Envie ao menos uma imagem.',
            'imagens.max' => 'Máximo de 5 imagens por vez.',
            'imagens.*.image' => 'Todos os arquivos devem ser imagens.',
            'imagens.*.max' => 'Cada imagem pode ter no máximo 2 MB.',
        ];
    }
}

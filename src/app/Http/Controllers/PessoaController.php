<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePessoaRequest;
use App\Http\Requests\UpdatePessoaRequest;
use App\Models\Ator;
use App\Models\Diretor;
use App\Models\Escritor;
use App\Models\Imagem;
use App\Models\Pessoa;
use App\Models\Produtor;
use Illuminate\Http\Request;

class PessoaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pessoas = Pessoa::all();
        return view('pessoas.index', compact('pessoas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pessoas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePessoaRequest $request)
    {
        $dados = $request->validated();
        $pessoa = Pessoa::create($dados);

        if ($request->hasFile('imagem')) {
            $caminho = $request->file('imagem')->store('imagens', 'public');
            $imagem = Imagem::create([
                'caminho' => $caminho,
                'nome' => basename($caminho)
                /* basename é uma função nativa do PHP que retorna o nome do arquivo de um caminho */
            ]);
            $pessoa->imagem()->attach($imagem->id);
        }

        /**
         * esse $tipos é so uma variavel que armazana os tipos de pessoa que o usuario selecionou no formulario,
         *  e depois a gente verifica se cada tipo foi selecionado e cria o registro correspondente na tabela relacionada
         */
        $tipos = request()->input('tipos', []);
        if (in_array('ator', $tipos)) {
            Ator::create(['pessoa_id' => $pessoa->id]);
        }
        if (in_array('diretor', $tipos)) {
            Diretor::create(['pessoa_id' => $pessoa->id]);
        }
        if (in_array('produtor', $tipos)) {
            Produtor::create(['pessoa_id' => $pessoa->id]);
        }
        if (in_array('escritor', $tipos)) {
            Escritor::create(['pessoa_id' => $pessoa->id]);
        }

        return redirect('/pessoas')->with('success', 'Pessoa criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pessoa = Pessoa::findOrFail($id);
        return view('pessoas.show', compact('pessoa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        $pessoa = Pessoa::findOrfail($id);
        return view('pessoas.edit', compact('pessoa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePessoaRequest $request, string $id)
    {

        abort_unless(auth()->user()->isAdmin(), 403);

        $pessoa = Pessoa::findOrFail($id);
        $dados = $request->validated();
        $pessoa->update($dados);

        // Remove a imagem antiga se existir
        $pessoa->imagem()->detach();
        
        //campo pra salvar a imagem
        if ($request->hasFile('imagem')) {
            $caminho = $request->file('imagem')->store('imagens', 'public');
            $imagem = Imagem::create([
                'caminho' => $caminho,
                'nome' => basename($caminho)
            ]);
            //adiciona a nova imagem
            $pessoa->imagem()->attach($imagem->id);
        }

        // Remove os tipos antigos
        $pessoa->ator()->delete();
        $pessoa->diretor()->delete();
        $pessoa->produtor()->delete();
        $pessoa->escritor()->delete();

        // Adiciona os novos tipos selecionados
        $tipos = $request->input('tipos', []);
        if (in_array('ator', $tipos)) {
            Ator::create(['pessoa_id' => $pessoa->id]);
        }
        if (in_array('diretor', $tipos)) {
            Diretor::create(['pessoa_id' => $pessoa->id]);
        }
        if (in_array('produtor', $tipos)) {
            Produtor::create(['pessoa_id' => $pessoa->id]);
        }
        if (in_array('escritor', $tipos)) {
            Escritor::create(['pessoa_id' => $pessoa->id]);
        }
        return redirect('/pessoas')->with('success', 'Pessoa atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

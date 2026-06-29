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
        $fotos = $request->file('imagens', []);
        $pessoa = Pessoa::create($dados);

        foreach ($fotos as $foto) {
            $caminho = $foto->store('imagens', 'public');
            $imagem = Imagem::create([
                'caminho' => $caminho,
                'nome' => basename($caminho)
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
        $filmesVinculados = $request->input('filmes_vinculados', []);
        foreach ($filmesVinculados as $v) {
            $filmeId = $v['filme_id'] ?? null;
            $tipo = $v['tipo'] ?? null;
            $personagem = $v['papel'] ?? 'sem papel';

            if (!$filmeId || !$tipo) continue;

            match ($tipo) {
                'ator' => Ator::firstOrCreate(['pessoa_id' => $pessoa->id])
                    ->filmes()->syncWithoutDetaching([$filmeId => ['papel' => $personagem]]),
                'diretor' => Diretor::firstOrCreate(['pessoa_id' => $pessoa->id])
                    ->filmes()->syncWithoutDetaching([$filmeId]),
                'produtor' => Produtor::firstOrCreate(['pessoa_id' => $pessoa->id])
                    ->filmes()->syncWithoutDetaching([$filmeId]),
                'escritor' => Escritor::firstOrCreate(['pessoa_id' => $pessoa->id])
                    ->filmes()->syncWithoutDetaching([$filmeId]),
                default => null,
            };
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

        //campo pra salvar a imagem
        // Só substitui as fotos se o usuário enviou arquivos novos
        if ($request->hasFile('imagens')) {
            // Remove as fotos antigas, já que vamos adicionar novas
            $pessoa->imagem()->detach();

            foreach ($request->file('imagens') as $foto) {
                $caminho = $foto->store('imagens', 'public');
                $imagem = Imagem::create([
                    'caminho' => $caminho,
                    'nome' => basename($caminho)
                ]);
                $pessoa->imagem()->attach($imagem->id);
            }
        }

        // Adiciona os novos tipos selecionados
        // Tipos que devem permanecer ou ser criados
        $tipos = $request->input('tipos', []);

        if (in_array('ator', $tipos)) {
            Ator::firstOrCreate(['pessoa_id' => $pessoa->id]);
        } else {
            $pessoa->ator()->delete();
        }

        if (in_array('diretor', $tipos)) {
            Diretor::firstOrCreate(['pessoa_id' => $pessoa->id]);
        } else {
            $pessoa->diretor()->delete();
        }

        if (in_array('produtor', $tipos)) {
            Produtor::firstOrCreate(['pessoa_id' => $pessoa->id]);
        } else {
            $pessoa->produtor()->delete();
        }

        if (in_array('escritor', $tipos)) {
            Escritor::firstOrCreate(['pessoa_id' => $pessoa->id]);
        } else {
            $pessoa->escritor()->delete();
        }

        return redirect('/pessoas')->with('success', 'Pessoa atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pessoa = Pessoa::findOrFail($id);
        $pessoa->ator()->delete();
        $pessoa->diretor()->delete();
        $pessoa->produtor()->delete();
        $pessoa->escritor()->delete();
        $pessoa->delete();
        return redirect('/pessoas')->with('success', 'Pessoa excluída com sucesso!');
    }

    public function buscar(Request $request)
    {
        $termo = trim($request->input('q', ''));
        $filmeId = $request->input('filme_id');
        if (strlen($termo) < 2) {
            return response()->json([]);
        }
        $pessoas = Pessoa::with('imagem')->where('nome', 'ilike', "%{$termo}%")
            ->limit(8)
            ->get(['id', 'nome']);
        // Indica quais tipos de vínculo a pessoa já tem no filme
        return response()->json($pessoas->map(function ($p) use ($filmeId) {
            $vinculos = [];
            if ($filmeId) {
                if ($p->ator?->filmes()->where('filme_id', $filmeId)->exists())
                    $vinculos[] = 'ator';
                if ($p->diretor?->filmes()->where('filme_id', $filmeId)->exists())
                    $vinculos[] = 'diretor';
            }
            return [
                'id' => $p->id,
                'nome' => $p->nome,
                'foto' => $p->foto_url,
                'vinculos' => $vinculos
            ];
        }));
    }
}

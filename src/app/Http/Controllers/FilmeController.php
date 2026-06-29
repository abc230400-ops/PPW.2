<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateFilmeRequest;
use App\Models\Filme;
use App\Models\Imagem;
use Illuminate\Http\Request;
use App\Http\Requests\StoreFilmeRequest;
use App\Models\Ator;
use App\Models\Diretor;
use App\Models\Escritor;
use App\Models\Estudio;
use App\Models\Genero;
use App\Models\Produtor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FilmeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function indexPublic(string $id)
    {

        $filme = Filme::findOrFail($id);
        return view('filmes.show-public', compact('filme'));
    }

    public function index(Request $request)
    {

        $busca = trim($request->input('busca', ''));
        $genero = $request->input('genero');
        $ano = $request->input('ano');
        $ordem = $request->input('ordem', 'nome');

        // Substitui ->get() por ->paginate()
        // O Laravel lê ?page=N da URL automaticamente
        $filmes = Filme::orderBy('nome')

            // Busca por título — só aplica se $busca não for vazio
            ->when(
                $busca,
                fn($q) =>
                $q->where('nome', 'ilike', "%{$busca}%")
            )

            // Filtro por gênero — só aplica se $genero não for nulo
            ->when(
                $genero,
                fn($q) =>
                $q->whereHas('genero', fn($g) => $g->where('genero.id', $genero))
            )

            // Filtro por ano — só aplica se $ano não for nulo
            ->when(
                $ano,
                fn($q) =>
                $q->where('ano', $ano)
            )
            // Ordenação dinâmica
            ->when(
                $ordem === 'ano',
                fn($q) => $q->orderBy('data_lancamento', 'desc'),
                fn($q) => $q->orderBy('nome')
            )
            ->paginate(12)
            ->withQueryString(); // preserva os filtros nos links de paginação

        $generos = Genero::all();
        return view('filmes.index', compact('filmes', 'generos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $generos = Genero::all();
        $estudios = Estudio::all();
        return view('filmes.create', compact('generos', 'estudios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFilmeRequest $request)
    {
        $dados = $request->validated();

        $posterIndex = $request->input('poster_index', 0);
        $arquivos = $request->file('imagens', []);
        $vinculos = $request->input('vinculos', []);
        $caminhos = [];
        // Faz upload de todos os arquivos antes da transação
        foreach ($arquivos as $arquivo) {
            $caminhos[] = $arquivo->store('imagens', 'public');
        }
        $generosSelecionados = $request->input('generos', []);
        try {
            DB::transaction(function () use ($dados, $caminhos, $posterIndex, $generosSelecionados, $vinculos) {
                $filme = Filme::create($dados);
                $filme->genero()->sync($generosSelecionados); // ← vincula os gêneros
                $this->sincronizarVinculos($filme, $vinculos);

                foreach ($caminhos as $i => $caminho) {
                    $imagem = Imagem::create([
                        'caminho' => $caminho,
                        'nome' => basename($caminho),
                    ]);
                    // Associa ao filme com pivot poster
                    $filme->imagens()->attach($imagem->id, [
                        'poster' => ($i === (int) $posterIndex),
                    ]);
                }
            });
        } catch (\Exception $e) {
            dd($e->getMessage());
            foreach ($caminhos as $caminho) {
                Storage::disk('public')->delete($caminho);
            }
            return back()->with('erro', 'Erro ao salvar. Tente novamente.');
        }
        return redirect('/filmes')->with('sucesso', 'Filme cadastrado!');
    }
    /**
     * Display the specified resource.
     */
    private function sincronizarVinculos(Filme $filme, array $vinculos): void
    {
        foreach ($vinculos as $v) {
            $pessoaId = $v['pessoa_id'] ?? null;
            $tipo = $v['tipo'] ?? null;
            $personagem = $v['papel'] ?? 'sem papel';
            if (!$pessoaId || !$tipo)
                continue;
            match ($tipo) {
                'ator' => $filme->ator()->syncWithoutDetaching([
                    Ator::firstOrCreate(['pessoa_id' => $pessoaId])->id => ['papel' => $personagem]
                ]),
                'diretor' => $filme->diretor()->syncWithoutDetaching([
                    Diretor::firstOrCreate(['pessoa_id' => $pessoaId])->id
                ]),
                'produtor' => $filme->produtor()->syncWithoutDetaching([
                    Produtor::firstOrCreate(['pessoa_id' => $pessoaId])->id
                ]),
                'escritor' => $filme->escritor()->syncWithoutDetaching([
                    Escritor::firstOrCreate(['pessoa_id' => $pessoaId])->id
                ]),
                default => null,
            };
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $filme = Filme::with([
            'ator.pessoa',
            'escritor.pessoa',
            'diretor.pessoa',
            'produtor.pessoa',
            'imagens',
            'genero',
            'estudio',

        ])->findOrFail($id);

        return view('filmes.show', compact('filme'));


        /**   $filmes = Filme::findOrFail($id);
         *$avaliacoes = $filmes->avaliacao()->reviews()->with('usuario')->orderBy('created_at', 'desc')->get();
         *return view('filmes.show', compact('filmes', 'avaliacoes'));*/
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        $filme = Filme::with([
            'ator.pessoa',
            'escritor.pessoa',
            'diretor.pessoa',
            'produtor.pessoa',

        ])->findOrFail($id);
        $generos = Genero::all();
        $estudios = Estudio::all();
        return view('filmes.edit', compact('filme', 'generos', 'estudios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFilmeRequest $request, int $id)
    {
        abort_unless(auth()->user()->isAdmin(), 403);
        $filme = Filme::findOrFail($id);
        $filme->update($request->validated());

        // 1. Remover vínculos marcados
        foreach ($request->input('remover_vinculos', []) as $relacao => $ids) {
            if (in_array($relacao, ['ator', 'diretor', 'produtor', 'escritor'])) {
                $filme->$relacao()->detach($ids);
            }
        }
        // 2. Atualizar personagem dos atores existentes
        foreach ($request->input('atores_existentes', []) as $atorId => $dados) {
            $filme->ator()->updateExistingPivot($atorId, [
                'papel' => $dados['papel'] ?? 'sem papel'
            ]);
        }
        // 3. Adicionar novos vínculos (mesmo método do store)
        $this->sincronizarVinculos($filme, $request->input('vinculos', []));

        $filme->genero()->sync($request->input('generos', [])); // ← aqui
        $filme->estudio()->sync($request->input('estudios', []));

        // 1. Atualiza qual imagem é o poster
        if ($request->filled('poster_imagem_id')) {
            // Desmarca todos os posters do filme
            $filme->imagens()->updateExistingPivot(
                $filme->imagens->pluck('id'),
                ['poster' => false]
            );
            // Marca a imagem selecionada como poster
            $filme->imagens()->updateExistingPivot(
                $request->poster_imagem_id,
                ['poster' => true]
            );
        }
        // 2. Adiciona novas imagens (se enviadas)
        if ($request->hasFile('imagens')) {
            $posterIndex = $request->input('poster_index');
            foreach ($request->file('imagens') as $i => $arquivo) {
                $caminho = $arquivo->store('imagens', 'public');
                $imagem = Imagem::create(['caminho' => $caminho, 'nome' => basename($caminho)]);
                $filme->imagens()->attach($imagem->id, ['poster' => ($i == $posterIndex)]);
            }
        }
        return redirect('/filmes/' . $id)->with('sucesso', 'Filme atualizado!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $filme = Filme::findOrFail($id);
        $filme->delete();
        return redirect('/filmes')->with('sucesso', 'Filme excluído com sucesso!');
    }

    public function buscar(Request $request)
    {
        $termo = trim($request->input('q', ''));

        if (strlen($termo) < 2) {
            return response()->json([]);
        }

        $filmes = Filme::where('nome', 'ilike', "%{$termo}%")
            ->limit(8)
            ->get(['id', 'nome']);

        return response()->json($filmes->map(function ($f) {
            return [
                'id' => $f->id,
                'nome' => $f->nome,
            ];
        }));
    }
}

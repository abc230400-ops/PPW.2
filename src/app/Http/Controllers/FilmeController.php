<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateFilmeRequest;
use App\Models\Filme;
use App\Models\Imagem;
use Illuminate\Http\Request;
use App\Http\Requests\StoreFilmeRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FilmeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $busca = trim($request->input('busca', ''));
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


        return view('filmes.index', compact('filmes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('filmes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFilmeRequest $request)
    {
        $dados = $request->validated();
        $posterIndex = $request->input('poster_index', 0);
        $arquivos = $request->file('imagens', []);
        $caminhos = [];
        // Faz upload de todos os arquivos antes da transação
        foreach ($arquivos as $arquivo) {
            $caminhos[] = $arquivo->store('imagens', 'public');
        }
        try {
            DB::transaction(function () use ($dados, $caminhos, $posterIndex) {
                $filme = Filme::create($dados);
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
    public function show(string $id)
    {

        $filme = Filme::findOrFail($id);
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

        $filme = Filme::findOrFail($id);
        return view('filmes.edit', compact('filme'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFilmeRequest $request, string $id)
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        $filme = Filme::findOrFail($id);
        $dados = $request->validated();

        // Upload de novas imagens (se enviadas)
        if ($request->hasFile('imagem')) {
            $arquivos = $request->file('imagem');
            $posterIndex = $request->input('poster_index', 0);
            $caminhos = [];
            foreach ($arquivos as $arquivo) {
                $caminhos[] = $arquivo->store('imagem', 'public');
            }
            foreach ($caminhos as $i => $caminho) {
                $imagem = Imagem::create(['caminho' => $caminho, 'nome' => basename($caminho)]);
                $filme->imagens()->attach($imagem->id, ['poster' => ($i === (int) $posterIndex)]);
            }
        }
        $filme->update($dados);
        return redirect('/filmes/' . $id)->with('sucesso', 'Filme atualizado!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Filme;
use App\Models\Imagem;
use Illuminate\Http\Request;
use App\Http\Requests\StoreFilmeRequest;

class FilmeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filmes = Filme::orderBy('nome')->paginate(12);
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

        // 1. Salva o arquivo no disco e pega o caminho
        $caminho = $request->file('poster')->store('posters', 'public');

        // 2. Cria o registro na tabela imagem
        $imagem = Imagem::create([
            'caminho' => $caminho,
            'nome' => $request->file('poster')->getClientOriginalName(),
        ]);

        // 3. Cria o filme (sem o poster, pois ele não é coluna da tabela filme)
        unset($dados['poster']);
        $filme = Filme::create($dados);

        // 4. Liga o filme à imagem na tabela imagem_filme com poster = true
        $filme->imagem()->attach($imagem->id, ['poster' => true]);

        return redirect('/filmes')
            ->with('sucesso', 'Filme cadastrado!');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Filme;
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

        Filme::create($dados);
        
        return redirect('/filmes')
            ->with('sucesso', 'Filme cadastrado!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $filmes = Filme::findOrFail($id);
        $avaliacoes = $filmes->avaliacoes()->reviews()->with('usuario')->orderBy('created_at', 'desc')->get();
        return view('filmes.show', compact('filmes', 'avaliacoes'));
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

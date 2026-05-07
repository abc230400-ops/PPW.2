<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produtos = DB::select('select * from produtos');
       
     

        return view("produtos.index", compact('produtos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('produtos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required|min:3',
            'preco' => 'required|numeric|min:0',
        ]);
        DB::insert('insert into produtos(nome, preco) values (?,?)', [$dados['nome'], $dados['preco']]);
        return redirect('/produtos')->with('sucesso', 'algo');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $produto = DB::select('select * from produtos where id = ?', [$id]);
        return view('produtos.edit', ['produto' => $produto[0]]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::update('update produtos set nome = ?, preco = ? where id = ?', [$request->nome, $request->preco, $id]);
        return redirect('/produtos')->with('sucesso', 'algo');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        DB::delete('delete from produtos where id = ?', [$id]);

        return redirect('/produtos')->with('sucesso', 'produto excluido');

    }
}

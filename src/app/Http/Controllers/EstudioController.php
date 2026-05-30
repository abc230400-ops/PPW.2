<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEstudioRequest;
use App\Http\Requests\UpdateEstudioRequest;
use App\Models\Estudio;
use Illuminate\Http\Request;

class EstudioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estudios = Estudio::all();
        return view('estudios.index', compact('estudios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('estudios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEstudioRequest $request)
    {
        $dados = $request->validated();
        Estudio::create($dados);
        return redirect('/estudios')->with('success', 'Estúdio criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $estudio = Estudio::with('filme')->findOrFail($id);
        return view('estudios.show', compact('estudio'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        $estudio = Estudio::findOrfail($id);
        return view('estudios.edit', compact('estudio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEstudioRequest $request, string $id)
    {
        abort_unless(auth()->user()->isAdmin(), 403);
        
        $estudio = Estudio::findOrfail($id);
        $dados = $request->validated();
        $estudio->update($dados);
        return redirect('/estudios')->with('success', 'Estúdio atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

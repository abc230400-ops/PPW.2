<?php

namespace App\Http\Controllers;

use App\Models\Estudio;
use App\Models\Filme;
use App\Models\Pessoa;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $busca = trim($request->input('busca_tudo', ''));

        $filmes = Filme::orderBy('nome')
        ->when($busca, fn($q) => $q->where('nome', 'ilike', "%{$busca}%"))->get();

        $pessoas = Pessoa::orderBy('nome')
        ->when($busca, fn($q) => $q->where('nome', 'ilike', "%{$busca}%"))->get();

        $estudios = Estudio::orderBy('nome')
        ->when($busca, fn($q) => $q->where('nome', 'ilike', "%{$busca}%"))->get();
        
        return view('home', compact('filmes', 'pessoas', 'estudios'));
    }
}

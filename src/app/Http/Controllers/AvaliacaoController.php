<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use App\Models\Avaliacao;
use Illuminate\Http\Request;

class AvaliacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(int $filmeId)
    {
        $avaliacoes = Avaliacao::with('user')
            ->where('filme_id', $filmeId)
            ->orderBy('created_at', 'desc')
            ->paginate(5);
        // Se for requisição AJAX (Accept: application/json), retorna JSON
// O paginator serializa automaticamente para JSON com metadados
        return response()->json([
            'data' => $avaliacoes->items(),
            'current_page' => $avaliacoes->currentPage(),
            'last_page' => $avaliacoes->lastPage(),
            'total' => $avaliacoes->total(),
            'next_page_url' => $avaliacoes->nextPageUrl(),
            'prev_page_url' => $avaliacoes->previousPageUrl(),
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
   
}

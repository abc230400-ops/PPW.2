<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $busca = trim($request->input('busca_tudo', ''));
        $filme = request()->input('filme');
        $pessoa = request()->input('pessoa');   
        $estudio = request()->input('estudio');
       // $genero = request()->input('genero');

    }

}

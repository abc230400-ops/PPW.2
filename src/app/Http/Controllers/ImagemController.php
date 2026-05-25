<?php

namespace App\Http\Controllers;

use App\Models\Filme;
use App\Models\Imagem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImagemController extends Controller
{
    public function destroyFromFilme(Imagem $imagem, Filme $filme)
    {
    dd('aa');
        $filme->imagens()->detach($imagem->id);
        $usos = $imagem->filmes()->count() + $imagem->pessoas()->count();
        if ($usos === 0) {
            Storage::disk('public')->delete($imagem->caminho);
            $imagem->delete();
        }
        return redirect()->back()->with('sucesso', 'Imagem removida!');
    }
}

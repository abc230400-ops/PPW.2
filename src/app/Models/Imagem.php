<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Imagem extends Model
{
    protected $table = 'imagem';

    protected $fillable = [
        'caminho',
        'nome',
    ];

    public function pessoa():BelongsToMany
    {
        return $this->belongsToMany(Pessoa::class,  'imagem_pessoa');
    }

    public function estudio():BelongsToMany
    {
        return $this->belongsToMany(Estudio::class, 'estudio_imagem');
    }

    public function filmes():BelongsToMany
    {
        return $this->belongsToMany(Filme::class, 'imagem_filme');
    }
}
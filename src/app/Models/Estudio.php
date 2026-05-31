<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Estudio extends Model
{
    protected $table = 'estudio';
    
    protected $fillable = [
        'nome',
        'local',
    ];

    public function imagem():BelongsToMany
    {
        return $this->belongsToMany(Imagem::class, 'imagem_estudio');
    }

    public function filme():BelongsToMany
    {
        return $this->belongsToMany(Filme::class, 'estudio_filme');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Genero extends Model
{
    protected $fillable =[
        'nome',
    ];

    public function filme():BelongsToMany
    {
        return $this->belongsToMany(Filme::class, 'filme_genero');
    }
}
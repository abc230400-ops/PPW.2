<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Filme extends Model
{
    protected $table = "filme";
    
    protected $fillable = [
        'nome',
        'duracao',
        'data_lancamento',
        'classificacao',
        'sinopse',
    ];
    public function ator(): BelongsToMany
    {
        return $this->belongsToMany(Ator::class, 'ator_filme');
    }

    public function diretor(): BelongsToMany
    {
        return $this->belongsToMany(Diretor::class, 'diretor_filme');
    }

    public function produtor(): BelongsToMany
    {
        return $this->belongsToMany(Produtor::class, 'produtor_filme');
    }
    public function escritor(): BelongsToMany
    {
        return $this->belongsToMany(Escritor::class, 'escritor_filme');
    }

    public function genero(): BelongsToMany
    {
        return $this->belongsToMany(Genero::class, 'filme_genero');
    }

    public function estudio(): BelongsToMany
    {
        return $this->belongsToMany(Estudio::class, 'estudio_filme');
    }

    public function imagem(): BelongsToMany
    {
        return $this->belongsToMany(Imagem::class, 'imagem_filme');
    }

    public function avaliacao(): HasMany
    {
        return $this->hasMany(Avaliacao::class);
    }
}

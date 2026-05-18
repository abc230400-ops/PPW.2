<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Escritor extends Model
{
    protected $fillable = [
        'pessoa_id',
    ];

    public function pessoa(): BelongsTo
    {
        return $this->belongsTo(Pessoa::class); 
    }

    public function filme():BelongsToMany
    {
        return $this->belongsToMany(Filme::class, 'escritor_filme');
    }
}
<?php

use Illuminate\Support\Facades\Route;

// Parâmetro obrigatório
Route::get('/produtos/{id}/{nome}/{preco}', function (int $id, string $nome, float $preco) {
return response()->json(['id' => $id, 'nome' => $nome, 'preco' => $preco]);
});



// Parâmetro opcional (com valor padrão)
Route::get('/categorias/{slug?}', function (string $slug = 'todas') {
return response()->json(['categoria' => $slug]);
});



// Restrição: aceita apenas números inteiros
Route::get('/produtos/{id}', function (int $id) {
return response()->json(['produtos_id' => $id]);
})->whereNumber('id');




// Rota POST
Route::post('/produtos', function () {
return response()->json(['mensagem' => 'Produto criado com sucesso!'], statusCode: 201);
});
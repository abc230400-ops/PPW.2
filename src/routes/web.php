<?php

use Illuminate\Support\Facades\Route;

Route::get('/produtos', function () {
return [['id'=> 1, 'nome' => 'banana', 'preço' => 10],['id'=> 2, 'nome' => 'maça', 'preço' => 20],['id'=> 3, 'nome' => 'pera', 'preço' => 30]];
});

Route::get('/produtos/{id}', function (int $id) {
return response()->json(['id' => $id, 'nome' => 'Produto ' . $id]);
});

Route::get('/produtos/{id}/avaliacao', function (int $id) {
return response()->json(['id' => $id, 'nome' => 'Produto ' . $id, 'avaliacao' =>[['id' => 1, 'texto' => 'algo'],['id' => 2, 'texto' => 'algo 2']] ]);
});

Route::post('/produtos', function () {
return response()->json(['mensagem' => 'Produto criado com sucesso'], 201);
});

Route::get('/', function(){
return view('welcome');
});

Route::delete('/produtos/{id}', function ($id) {
return response()->json(['mensagem' => 'Produto deletado com sucesso'], 200);
});
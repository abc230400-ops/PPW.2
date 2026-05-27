<?php

use App\Http\Controllers\FilmeController;
use App\Http\Controllers\GeneroController;
use App\Http\Controllers\ImagemController;
use App\Http\Controllers\ProdutoController;
use Illuminate\Support\Facades\Route;

// Route::get('/produtos', [ProdutoController::class,'index']);

// Route::get('/produtos/{id}', function (int $id) {
// return response()->json(['id' => $id, 'nome' => 'Produto ' . $id]);
// });

// Route::get('/produtos/{id}/avaliacao', function (int $id) {
// return response()->json(['id' => $id, 'nome' => 'Produto ' . $id, 'avaliacao' =>[['id' => 1, 'texto' => 'algo'],['id' => 2, 'texto' => 'algo 2']] ]);
// });

// Route::post('/produtos', function () {
// return response()->json(['mensagem' => 'Produto criado com sucesso'], 201);
// });

// Route::get('/', function(){
// return view('welcome');
// });

// Route::delete('/produtos/{id}', function ($id) {
// return response()->json(['mensagem' => 'Produto deletado com sucesso'], 200);
// });

//route::resource('produtos', ProdutoController::class);


// Grupo de rotas protegidas — só admin
Route::middleware(['auth', 'admin'])->group(function () {

    Route::resource('filmes', FilmeController::class);

    Route::resource('generos', GeneroController::class);

    Route::delete(
        '/imagens/{imagem}/filme/{filme}',
        [ImagemController::class, 'destroyFromFilme']
    );


    Route::get('/admin', function () {
        return view('admin');
    });
});


Route::get('/', function () {
    return view('home');
});

require __DIR__ . '/auth.php';

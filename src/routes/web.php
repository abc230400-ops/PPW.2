<?php

use App\Http\Controllers\EstudioController;
use App\Http\Controllers\FilmeController;
use App\Http\Controllers\GeneroController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImagemController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\AvaliacaoController;
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

    Route::get('/pessoas/buscar', [PessoaController::class, 'buscar']);

    Route::get('/filmes/buscar', [FilmeController::class, 'buscar']);

    // index e show ficam fora do resource, porque são públicos e pra evitar codigo repetido ai utilizou o except 
    //que exclui as rotas index e show do resource e o usuario comum nao consegue acessar o create, edit, update e delete
    Route::resource('filmes', FilmeController::class)->except(['index', 'show']);

    Route::resource('generos', GeneroController::class);

    // index e show ficam fora do resource, porque são públicos
    Route::resource('pessoas', PessoaController::class)->except(['index', 'show']);

    Route::resource('estudios', EstudioController::class);



    Route::delete(
        '/imagens/{imagem}/filme/{filme}',
        [ImagemController::class, 'destroyFromFilme']
    );

    Route::get('/admin', function () {
        return view('admin');
    });
});

// Rotas públicas de Filmes e Pessoas (index e show)
Route::get('/filmes', [FilmeController::class, 'index']);
Route::get('/filmes/{filme}', [FilmeController::class, 'show']);
Route::get('/pessoas', [PessoaController::class, 'index']);
Route::get('/pessoas/{pessoa}', [PessoaController::class, 'show']);

Route::get('/filmes/{id}/avaliacoes', [AvaliacaoController::class, 'index']);

Route::get('/filmes-p/{id}', [FilmeController::class, 'indexPublic']);


Route::get('/', [HomeController::class, 'index']);

Route::get('/home', [HomeController::class, 'index'])->name('home');

require __DIR__ . '/auth.php';
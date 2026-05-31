<?php

use App\Http\Controllers\EstudioController;
use App\Http\Controllers\FilmeController;
use App\Http\Controllers\GeneroController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImagemController;
use App\Http\Controllers\PessoaController;
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

    Route::resource('pessoas', PessoaController::class);

    Route::resource('estudios', EstudioController::class);

    Route::delete(
        '/imagens/{imagem}/filme/{filme}',
        [ImagemController::class, 'destroyFromFilme']
    );

    Route::get('/admin', function () {
        return view('admin');
    });
});
 //teve que criar as rotas a parte pq tava dando erro, com elas separadas usuarios comuns conseguem acessar a rota show, 
 //mas não conseguem acessar as rotas de edição, criação e exclusão, que estão protegidas pelo middleware admin. 
Route::get('/filmes', [FilmeController::class, 'index']);
Route::get('/filmes/{filme}', [FilmeController::class, 'show']);
Route::get('/pessoas', [PessoaController::class, 'index']);
Route::get('/pessoas/{pessoa}', [PessoaController::class, 'show']);


Route::get('/', [HomeController::class, 'index']);

require __DIR__ . '/auth.php';

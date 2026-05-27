@extends('layouts.app')

@section('titulo', 'editando gênero')

@section('conteudo')

<!-- controla o tamanho total da página -->
<div class="container mt-4">
<!-- centraliza o conteúdo (row) -->
    <div class="row justify-content-center">
<!-- define a largura da coluna (col) -->
        <div class="col-md-6">

            <h1 class="h2 mb-4">Editar gênero</h1>

            <form action="/generos/{{ $genero->id }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('partials.form-generos')
                <button type="submit" class="btn btn-dark">Alterar gênero</button>
            </form>

        </div>
    </div>
</div>
@endsection
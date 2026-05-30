@extends('layouts.app')

@section('titulo', 'editando estúdio')

@section('conteudo')

<!-- controla o tamanho total da página -->
<div class="container mt-4">
    <!-- centraliza o conteúdo (row) -->
    <div class="row justify-content-center">
        <!-- define a largura da coluna (col) -->
        <div class="col-md-6">

            <h1 class="h2 mb-4">Editar estúdio</h1>

            <form action="/estudios/{{ $estudio->id }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('partials.form-estudios')
                <button type="submit" class="btn btn-dark">Alterar estúdio</button>
            </form>

        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('titulo', 'criando estúdio')

@section('conteudo')

<!-- controla o tamanho total da página -->
<div class="container mt-4">
    <!-- centraliza o conteúdo (row) -->
    <div class="row justify-content-center">
        <!-- define a largura da coluna (col) -->
        <div class="col-md-6">

            <h1 class="h2 mb-4">Criar estúdio</h1>

            <form action="/estudios" method="POST" enctype="multipart/form-data">
                @csrf
                @include('partials.form-estudios')
                <button type="submit" class="btn btn-dark">Criar estúdio</button>
            </form>

        </div>
    </div>
</div>
@endsection
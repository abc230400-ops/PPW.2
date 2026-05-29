@extends('layouts.app')

@section('titulo', 'editando pessoa')

@section('conteudo')

<!-- controla o tamanho total da página -->
<div class="container mt-4">
    <!-- centraliza o conteúdo (row) -->
    <div class="row justify-content-center">
        <!-- define a largura da coluna (col) -->
        <div class="col-md-6">

            <h1 class="h2 mb-4">Editar pessoa</h1>

            @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $erro)
                <div>{{ $erro }}</div>
                @endforeach
            </div>
            @endif

            <form action="/pessoas/{{ $pessoa->id }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('partials.form-pessoas')
                <button type="submit" class="btn btn-dark">Alterar pessoa</button>
            </form>

        </div>
    </div>
</div>
@endsection
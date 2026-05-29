@extends('layouts.app')

@section('titulo', 'criando pessoa')

@section('conteudo')

<!-- controla o tamanho total da página -->
<div class="container mt-4">
    <!-- centraliza o conteúdo (row) -->
    <div class="row justify-content-center">
        <!-- define a largura da coluna (col) -->
        <div class="col-md-6">

            <h1 class="h2 mb-4">Criar pessoa</h1>

            @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $erro)
                <div>{{ $erro }}</div>
                @endforeach
            </div>
            @endif

            <form action="/pessoas" method="POST" enctype="multipart/form-data">
                @csrf
                @include('partials.form-pessoas')

                <div class="mb-3 mt-4">
                    <button type="submit" class="btn btn-dark">criar pessoa</button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection
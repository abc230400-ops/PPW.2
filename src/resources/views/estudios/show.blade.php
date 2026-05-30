@extends('layouts.app')

@section('titulo', 'Detalhes do estúdio')

@section('conteudo')

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="h2 mb-4">{{ $estudio->nome }}</h1>

            <p><strong>Nome do estúdio:</strong> {{ $estudio->nome }}</p>
            <p><strong>Local:</strong> {{ $estudio->local }}</p>
            
            <button class="btn btn-dark mb-3" onclick="window.history.back()">Voltar</button>
        </div>
    </div>
</div>
@endsection
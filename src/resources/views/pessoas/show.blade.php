@extends('layouts.app')

@section('titulo', 'Detalhes da pessoa')

@section('conteudo')

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="h2 mb-4">{{ $pessoa->nome }}</h1>

            @php $foto = $pessoa->imagem->first(); @endphp
            @if ($foto)
            <img src="{{ asset('storage/' . $foto->caminho) }}" class="img-fluid rounded" style="max-width: 300px;">
            @else
            <p>Sem foto</p>
            @endif

            <p><strong>Data de Nascimento:</strong> {{ $pessoa->data_nascimento }}</p>
            <p><strong>Biografia:</strong> {{ $pessoa->biografia }}</p>
            <p><strong>Gênero:</strong> {{ $pessoa->genero }}</p>
            <p><strong>Nacionalidade:</strong> {{ $pessoa->nacionalidade }}</p>

            <button class="btn btn-dark mb-3" onclick="window.history.back()">Voltar</button>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('titulo', 'Detalhes do gênero')

@section('conteudo')

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="h2 mb-4">Filmes de {{ $genero->nome }} </h1>
            @forelse ($genero->filme as $filme)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ $filme->nome }}</h5>
                        <p class="card-text">{{ $filme->sinopse }}</p>
                    </div>
                </div>
            @empty
                <p>Não há filmes disponíveis para este gênero.</p>
            @endforelse
             {{-- esse onclick faz voce voltar pra janela anterior (bizu dmss) --}}
            <button class="btn btn-dark mb-3" onclick="window.history.back()">Voltar</button>
    </div>
</div>
@endsection
@extends('layouts.app')
@section('titulo', 'Gêneros')

@section('conteudo')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="row justify-content-center">
            <div class="col-md-6">


                <h1>Gêneros</h1>


                @forelse ($generos as $genero)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ $genero->nome }}</h5>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="/generos/{{ $genero->id }}" class="btn btn-dark">Ver todos os filmes de {{ $genero->nome }}</a>
                            
                            <a href="/generos/{{ $genero->id }}/edit" class="btn btn-dark">Editar gênero</a>
                        </div>
                    </div>
                </div>
                @empty
                <p>Nenhum gênero cadastrado.</p>
                @endforelse
                <a href="/generos/create" class="btn btn-dark">Adicionar gênero</a>
                <button class="btn btn-dark mb-3 ">
                    <a href="/" class="text-white text-decoration-none">Voltar</a>
                </button>
            </div>

        </div>
    </div>
</div>
@endsection
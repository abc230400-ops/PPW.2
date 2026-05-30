@extends('layouts.app')
@section('titulo', 'Estúdios')

@section('conteudo')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="row justify-content-center">
            <div class="col-md-6">


                <h1>Estúdios</h1>


                @forelse ($estudios as $estudio)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ $estudio->nome }}</h5>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="/estudios/{{ $estudio->id }}" class="btn btn-dark">Ver estudios</a>
                            <a href="/estudios/{{ $estudio->id }}/edit" class="btn btn-dark">Editar</a>
                        </div>
                    </div>
                </div>
                @empty
                <p>Nenhum estúdio cadastrado.</p>
                @endforelse
             
                <button class="btn btn-dark mb-3 ">
                    <a href="/" class="text-white text-decoration-none">Voltar</a>
                </button>
            </div>

        </div>
    </div>
</div>
@endsection
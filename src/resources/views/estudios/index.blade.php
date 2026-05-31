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

                <div class="d-flex gap-2 mb-3">
                    <a href="/estudios/create" class="btn btn-dark">Adicionar Estúdio</a>
                    <a href="/" class="btn btn-dark">Voltar</a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
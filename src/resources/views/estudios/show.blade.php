@extends('layouts.app')

@section('titulo', 'Detalhes do estúdio')

@section('conteudo')

<div class="container mt-5">
    <div class="card mb-3">
        <div class="row g-0">

            {{-- imagem do card --}}
            <div class="col-md-4">
                @php $foto = $estudio->imagem->first(); @endphp
                @if ($foto)
                <img src="{{ asset('storage/' . $foto->caminho) }}"
                    class="img-fluid rounded-start" style="height: 100%; object-fit: cover;">
                @else
                <p>Sem foto</p>
                @endif
            </div>

            {{-- texto do card --}}
            <div class="col-md-8 d-flex align-items-center">
                <div class="card-body">
                    <h1 class="h2 mb-4">{{ $estudio->nome }}</h1>

                    <p><strong>Nome do estúdio:</strong> {{ $estudio->nome }}</p>
                    <p><strong>Local:</strong> {{ $estudio->local }}</p>

                    <button class="btn btn-dark mb-3" onclick="window.history.back()">Voltar</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
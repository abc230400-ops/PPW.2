@extends('layouts.app')

@section('titulo', 'Detalhes da pessoa')

@section('conteudo')

<div class="container mt-5">
    <div class="card mb-3">
        <div class="row g-0">

            {{-- imagem do card --}}
            <div class="col-md-4">
                @php $foto = $pessoa->imagem->first(); @endphp
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
                    <h1 class="h2 mb-4">{{ $pessoa->nome }}</h1>
                    <p><strong>Data de Nascimento:</strong> {{ $pessoa->data_nascimento }}</p>
                    <p><strong>Tipo:</strong>
                        @php $tipos = [];
                        if($pessoa->ator) $tipos[] = 'Ator/Dublador';
                        if($pessoa->diretor) $tipos[] = 'Diretor';
                        if($pessoa->escritor) $tipos[] = 'Escritor';
                        if($pessoa->produtor) $tipos[] = 'Produtor';
                        @endphp
                        {{ implode(', ', $tipos) }}
                    </p>
                    <p><strong>Biografia:</strong> {{ $pessoa->biografia }}</p>
                    <p><strong>Gênero:</strong> {{ $pessoa->genero }}</p>
                    <p><strong>Nacionalidade:</strong> {{ $pessoa->nacionalidade }}</p>
                
                </div>
            </div>
        </div>
    </div>
    <button class="btn btn-dark mb-3" onclick="window.history.back()">Voltar</button>
</div>

@endsection
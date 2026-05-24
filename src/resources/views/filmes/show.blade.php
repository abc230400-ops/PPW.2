@extends('layouts.app')

@section('titulo', $filme->nome)

@section('conteudo')
    <div class="row justify-content-center align-items-center" style="background-color: #f8f9fa; padding: 20px; border-radius: 5px;">
        {{-- Poster --}}
        <div class="col-md-3">
            @php $poster = $filme->imagem->first(); @endphp
            @if ($poster)
                <img src="{{ asset('storage/' . $poster->caminho) }}" class="img-fluid rounded">
            @else
                <p>Sem poster</p>
            @endif
        </div>

        {{-- Informações --}}
        <div class="col-md-9">
            <h1>{{ $filme->nome }}</h1>
            <p><strong>Duração:</strong> {{ $filme->duracao }} min</p>
            <p><strong>Lançamento:</strong> {{ $filme->data_lancamento }}</p>
            <p><strong>Classificação:</strong> {{ $filme->classificacao }}</p>
            <p><strong>Sinopse:</strong> {{ $filme->sinopse }}</p>
        </div>
    </div>

    <!-- {{-- Todas as imagens do filme --}}
    <h3 class="mt-4">Imagens</h3>
    <div class="row g-3">
        @forelse ($filme->imagem as $imagem)
            <div class="col-md-3">
                <img src="{{ asset('storage/' . $imagem->caminho) }}" class="img-fluid rounded">
            </div>
        @empty
            <p>Nenhuma imagem cadastrada.</p>
        @endforelse
    </div> -->
@endsection
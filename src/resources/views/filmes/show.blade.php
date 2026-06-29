@extends('layouts.app')

@section('titulo', $filme->nome)

@section('conteudo')

<div class="container" style="margin-top: 100px;">
    <div class="row justify-content-center">
        <div class="col-md-11">

            <h1 class="h2 mb-4">Detalhes do filme</h1>

            <div class="card mb-4">
                <div class="row g-0">
                    <div class="col-md-5">
                        @php $poster = $filme->imagens->firstWhere('pivot.poster', true); @endphp
                        @if ($poster)
                        <img src="{{ asset('storage/' . $poster->caminho) }}"
                            class="img-fluid h-100 rounded-start"
                            style="object-fit: cover; width: 100%">
                        @else
                        <p class="p-3">Sem poster</p>
                        @endif
                    </div>

                    <div class="col-md-7">
                        <div class="card-body">
                            <h2 class="card-title">{{ $filme->nome }}</h2>
                            <p><strong>Gêneros:</strong>
                                @foreach ($filme->genero as $genero)
                                {{ $genero->nome }}@if (!$loop->last), @endif
                                @endforeach
                            </p>
                            <p><strong>Duração:</strong> {{ $filme->duracao }} minutos</p>
                            <p><strong>Lançamento:</strong> {{ $filme->data_lancamento }}</p>
                            <p><strong>Classificação:</strong> {{ $filme->classificacao }}</p>
                            <p><strong>Sinopse:</strong> {{ $filme->sinopse }}</p>
                            <p><strong>Estúdio:</strong>
                                @foreach ($filme->estudio as $estudio)
                                {{ $estudio->nome }}@if (!$loop->last), @endif
                                @endforeach
                            </p>
                            <p><strong>Diretor(es):</strong>
                                @foreach ($filme->diretor as $diretor)
                                {{ $diretor->pessoa->nome }}@if (!$loop->last), @endif
                                @endforeach
                            </p>
                            <p><strong>Escritor(es):</strong>
                                @foreach ($filme->escritor as $escritor)
                                {{ $escritor->pessoa->nome }}@if (!$loop->last), @endif
                                @endforeach
                            </p>
                            <p class="mb-0"><strong>Produtor(es):</strong>
                                @foreach ($filme->produtor as $produtor)
                                {{ $produtor->pessoa->nome }}@if (!$loop->last), @endif
                                @endforeach
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <h2 class="h4 mb-3">Elenco</h2>
            @foreach ($filme->ator as $ator)
            <div class="card mb-3 shadow-sm">
                <div class="d-flex align-items-center p-3 gap-3">
                    @php $foto = $ator->pessoa->imagem->first(); @endphp
                    @if ($foto)
                    <img src="{{ asset('storage/' . $foto->caminho) }}"
                        class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover;">
                    @else
                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center"
                        style="width: 60px; height: 60px;">
                        <i class="bi bi-person-fill" style="font-size: 24px; color: white;"></i>
                    </div>
                    @endif
                    <div class="flex-grow-1">
                        <h5 class="mb-0">{{ $ator->pessoa->nome }}</h5>
                        <small class="text-muted">como {{ $ator->pivot->papel }}</small>
                    </div>
                </div>
            </div>
            @endforeach

            <a href="/filmes" class="btn btn-dark mb-3 mt-3">Voltar</a>

        </div>
    </div>
</div>

@endsection
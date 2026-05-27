@extends('layouts.app')

@section('titulo', $filme->nome)
{{-- style="background-color: #f8f9fa; padding: 20px; border-radius: 5px;" --}}
@section('conteudo')

{{-- Container que controla o tamanho total da página (fluid pra pegar toda a largura) --}}
<div class="container-fluid px-5" style="margin-top: 150px;">
    {{-- Row para centralizar o conteúdo --}}
    <div class="row justify-content-center">
        {{-- Coluna que define a largura do conteúdo --}}
        <div class="col-md-11">

            <h1 class="h2 mb-4">Detalhes do filme</h1>

            {{-- Poster --}}
            <div class="card">
                <div class="row g-0">
                    {{-- Poster --}}
                    <div class="col-md-5">
                        @php $poster = $filme->imagens->first(); @endphp
                        @if ($poster)
                        <img src="{{ asset('storage/' . $poster->caminho) }}"
                            class="img-fluid h-100 rounded-start"
                            style="object-fit: contain; width: 100%">
                        @else
                        <p>Sem poster</p>
                        @endif
                    </div>

                    {{-- Informações --}}
                    <div class="col-md-7">
                        <div class="card-body">
                            <h1 class="card-title">{{ $filme->nome }}</h1>
                            <p><strong>Gêneros:</strong>
                                @foreach ($filme->genero as $genero)
                                {{ $genero->nome }}@if (!$loop->last), @endif
                                @endforeach
                            </p>
                            <p><strong>Duração:</strong> {{ $filme->duracao }} minutos</p>
                            <p><strong>Lançamento:</strong> {{ $filme->data_lancamento }}</p>
                            <p><strong>Classificação:</strong> {{ $filme->classificacao }}</p>
                            <p><strong>Sinopse:</strong> {{ $filme->sinopse }}</p>
                        </div>

                    </div>

                </div>
            </div>
            {{-- esse onclick faz voce voltar pra janela anterior (bizu dmss) --}}
            <button class="btn btn-dark mb-3" onclick="window.history.back()">Voltar</button>



        </div>
    </div>
</div>


@endsection
@extends('layouts.app')
@section('titulo', 'Pessoas')

@section('conteudo')
<div class="container mt-4">

    <div class="row justify-content-center">



        <h1>Pessoas</h1>

        <div class="row g-2 justify-content-center">
            @forelse ($pessoas as $pessoa)
            <div class="col-md-3">
                <div class="card h-100"> {{-- ← card adicionado --}}

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold">{{ $pessoa->nome }}</h5>

                        <p class="card-text ">
                            <strong>Tipo(s): </strong>
                            @php $tipos = []; @endphp
                            @if ($pessoa->ator) @php $tipos[] = 'Ator/Dublador(a)'; @endphp @endif
                            @if ($pessoa->diretor) @php $tipos[] = 'Diretor(a)'; @endphp @endif
                            @if ($pessoa->escritor) @php $tipos[] = 'Escritor(a)'; @endphp @endif
                            @if ($pessoa->produtor) @php $tipos[] = 'Produtor(a)'; @endphp @endif
                            {{ implode(', ', $tipos) }}
                        </p>

                        <strong class="card-text">Biografia: </strong>
                        <p class="card-text">{{ Str::limit($pessoa->biografia, 100) }}</p>
                        <p class="card-text"><small class="text-muted">Nascido em {{ $pessoa->data_nascimento}}</small></p>

                        {{-- ← empurra os botões pro fundo com o mt-auto --}}
                        <div class="mt-auto">
                            <a href="/pessoas/{{ $pessoa->id }}" class="btn btn-dark">Ver detalhes</a>
                            <a href="/pessoas/{{ $pessoa->id }}/edit" class="btn btn-dark">Editar</a>
                        </div>

                    </div>
                </div> {{-- ← fecha card --}}
            </div>

            @empty
            <p>Nenhuma pessoa cadastrada.</p>
            @endforelse

            <div class="mb-3 mt-3">
                <button class="btn btn-dark mb-3 ">
                    <a href="/" class="text-white text-decoration-none">Voltar</a>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection



{{-- @php $poster = $pessoa->imagens->first(); @endphp --}}
{{-- @if ($poster) --}}
{{-- <img src="{{ asset('storage/' . $poster->caminho) }}" class="card-img-top"> --}}
{{-- @else --}}
{{-- <img src="{{ asset('storage/default-poster.jpg') }}" class="card-img-top"> --}}
{{-- @endif --}}
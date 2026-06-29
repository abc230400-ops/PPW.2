@extends('layouts.app')
@section('titulo', 'Pessoas')

@section('conteudo')
<div class="container mt-4">

    <div class="row justify-content-center">



        <h1>Pessoas</h1>

        <div class="row g-2 justify-content-center">
            @forelse ($pessoas as $pessoa)
            <div class="card mb-3">
                <div class="d-flex align-items-center p-3 gap-3">

                    {{-- Foto redonda --}}
                    @php $foto = $pessoa->imagem->first(); @endphp
                    @if ($foto)
                    <img src="{{ asset('storage/' . $foto->caminho) }}"
                        class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover;">
                    @else
                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center"
                        style="width: 60px; height: 60px;">
                        <i class="bi bi-person-fill" style="font-size: 24px; color: white;"></i>
                    </div>
                    @endif

                    {{-- Informações --}}
                    <div class="flex-grow-1">
                        <h5 class="mb-0">{{ $pessoa->nome }}</h5>
                        <small class="text-muted">
                            @php $tipos = [];
                            if ($pessoa->ator) $tipos[] = 'Ator/Dublador';
                            if ($pessoa->diretor) $tipos[] = 'Diretor';
                            if ($pessoa->escritor) $tipos[] = 'Escritor';
                            if ($pessoa->produtor) $tipos[] = 'Produtor';
                            @endphp
                            {{ implode(', ', $tipos) }}
                        </small>
                    </div>

                    {{-- Botões à direita --}}
                    <div class="d-flex gap-2">
                        <a href="/pessoas/{{ $pessoa->id }}" class="btn btn-dark btn-md"><i class="bi bi-plus-lg"></i></i></a>
                        @if(auth()->user()?->isAdmin())
                        <a href="/pessoas/{{ $pessoa->id }}/edit" class="btn btn-dark">Editar</a>
                        <form action="/pessoas/{{ $pessoa->id }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir esta pessoa?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-secondary">Excluir</button>
                        </form>
                        @endif
                    </div>

                </div>
            </div>
            @empty
            <p>Nenhuma pessoa cadastrada.</p>
            @endforelse

            <div class="d-flex mb-3 mt-3 gap-3">
                <a href="/" class="btn btn-dark mb-3">
                    Voltar
                </a>
                @if(auth()->user()?->isAdmin())
                <a href="/pessoas/create" class="btn btn-dark mb-3">
                    Criar pessoa
                </a>
                @endif
            </div>
        </div>
        @endsection
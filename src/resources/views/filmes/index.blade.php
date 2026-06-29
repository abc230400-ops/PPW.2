{{-- resources/views/filmes/index.blade.php --}}
@extends('layouts.app')
@section('titulo', 'Filmes')

@section('conteudo')

<div class="container mt-4">

    <h1 class="h2 mb-4">Filmes</h1>

    {{-- Formulario de busca --}}

    <form action="/filmes" method="GET" class="mb-4">
        <div class="row g-2 justify-content-center">
            <div class="col-md-5">
                <input type="text" name="busca" value="{{ request('busca') }}" class="form-control"
                    placeholder="Buscar filmes...">
            </div>

            <div class="col-md-3">
                <select name="genero" class="form-select">
                    <option value="">Todos os gêneros</option>
                    @foreach ($generos as $g)
                    <option value="{{ $g->id }}" {{ request('genero') == $g->id ? 'selected' : '' }}>
                        {{ $g->nome }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <select name="ordem" class="form-select">
                    <option value="nome" {{ request('ordem') === 'nome' ? 'selected' : '' }}>A–Z</option>
                    <option value="ano" {{ request('ordem') === 'ano' ? 'selected' : '' }}>Mais recentes</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-dark w-100">Buscar</button>
            </div>
        </div>
    </form> {{-- ← fechamento correto aqui --}}

    {{-- Lista de filmes --}}
    <div class="row g-2 justify-content-center">
        @forelse ($filmes as $filme)
        <div class="col-md-3">
            <div class="card h-100"> {{-- ← card adicionado --}}
                @php $poster = $filme->imagens->firstWhere('pivot.poster', true); @endphp
                @if ($poster)
                <img src="{{ asset('storage/' . $poster->caminho) }}" class="card-img-top">
                @endif
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $filme->nome }}</h5>
                    <p class="text-muted">{{ $filme->data_lancamento }}</p>
                    <p class="card-text">{{ Str::limit($filme->sinopse, 100) }}</p>

                    {{-- ← empurra os botões pro fundo com o mt-auto --}}
                    <div class="mt-auto">
                        <a href="/filmes/{{ $filme->id }}" class="btn btn-dark">Ver detalhes</a>
                        @if(auth()->user()?->isAdmin())
                        <a href="/filmes/{{ $filme->id }}/edit" class="btn btn-dark">Editar</a>
                        <form action="/filmes/{{ $filme->id }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este filme?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-secondary">Excluir</button>
                        </form>
                        @endif
                    </div>

                </div>
            </div> {{-- ← fecha card --}}
        </div>

        @empty

        <p>Nenhum filme encontrado.</p>

        @endforelse

    </div>

    {{-- exibindo filmes --}}
    <div class="d-flex justify-content-center" style="margin-top: 80px;">
        {{ $filmes->links() }}
    </div>

    <p class="text-muted text-center">
        Exibindo {{ $filmes->firstItem() }}–{{ $filmes->lastItem() }}
        de {{ $filmes->total() }} filmes
    </p>

    <div class="d-flex justify-content-center gap-3">
        <a href="/" class="btn btn-dark mb-3">
            Voltar
        </a>
        <a href="/filmes/create" class="btn btn-dark mb-3">
            Criar filme
        </a>
    </div>

</div>
@endsection
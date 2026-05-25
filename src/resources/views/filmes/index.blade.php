{{-- resources/views/filmes/index.blade.php --}}
@extends('layouts.app')
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
    </form>  {{-- ← fechamento correto aqui --}}

    {{-- Lista de filmes --}}
    <div class="row g-2 justify-content-center">
        @forelse ($filmes as $filme)
        <div class="col-md-3">
            <div class="card h-100">  {{-- ← card adicionado --}}
                @php $poster = $filme->imagens->first(); @endphp
                @if ($poster)
                <img src="{{ asset('storage/' . $poster->caminho) }}" class="card-img-top">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $filme->nome }}</h5>
                    <p class="text-muted">{{ $filme->data_lancamento }}</p>
                    <p class="card-text">{{ Str::limit($filme->sinopse, 100) }}</p>
                    <a href="/filmes/{{ $filme->id }}" class="btn btn-dark">Ver detalhes</a>
                    <a href="/filmes/{{ $filme->id }}/edit" class="btn btn-dark">Editar</a>
                </div>
            </div>  {{-- ← fecha card --}}
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
</div>
@endsection
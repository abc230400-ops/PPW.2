{{-- resources/views/filmes/index.blade.php --}}
@extends('layouts.app')
@section('conteudo')
<h1 class="h2 mb-4">Filmes</h1>
<div class="row g-3">
    @forelse ($filmes as $filme)
    <div class="col-md-3">
        {{-- Poster é a foto da capa do filme --}}
        @php $poster = $filme->imagem->first(); @endphp
        @if ($poster)
        <img src="{{ asset('storage/' . $poster->caminho) }}" class="card-img-top">
        @endif
        <div class="card-body">
            <h5 class="card-title">{{ $filme->nome }}</h5>
            <p class="text-muted">{{ $filme->data_lancamento }}</p>
            <p class="card-text">{{ Str::limit($filme->sinopse, 100) }}</p>
            <a href="/filmes/{{ $filme->id }}" class="btn btn-dark">Ver detalhes</a>
        </div>
    </div>
</div>
@empty
<p>Nenhum filme encontrado.</p>
@endforelse
</div>
{{-- Renderiza os botões de paginação --}}
<div class="d-flex justify-content-center mt-4">
    {{ $filmes->links() }}
</div>
{{-- Informações sobre a página atual --}}
<p class="text-muted text-center">
    Exibindo {{ $filmes->firstItem() }}–{{ $filmes->lastItem() }}
    de {{ $filmes->total() }} filmes
</p>
@endsection
@extends('layouts.app')

@section('titulo', 'criando filme')

@section('conteudo')
    {{-- enctype="multipart/form-data" é obrigatório para upload --}}
    <form action="/filmes" method="POST" enctype="multipart/form-data">

        @csrf
        <div class="mb-3">
            <label for="nome" class="form-label">nome</label>
            <input type="text" class="form-control" id="nome" aria-describedby="nome" name="nome">
            <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
        </div>
        <div class="mb-3">
            <label for="preco" class="form-label">duração</label>
            <input type="text" class="form-control" id="duracao" name="duracao">
        </div>
        <div class="mb-3">
            <label for="preco" class="form-label">data do lançamento</label>
            <input type="text" class="form-control" id="data_lancamento" name="data_lancamento">
        </div>
        <div class="mb-3">
            <label for="preco" class="form-label">classificação</label>
            <input type="text" class="form-control" id="classificacao" name="classificacao">
        </div>
        <div class="mb-3">
            <label for="preco" class="form-label">sinopse</label>
            <input type="text" class="form-control" id="sinopse" name="sinopse">
        </div>
        <button type="submit" class="btn btn-primary">criar filme</button>
    </form>
@endsection
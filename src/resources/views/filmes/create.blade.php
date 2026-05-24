@extends('layouts.app')

@section('titulo', 'criando filme')

@section('conteudo')
    <form action="/filmes" method="POST" enctype="multipart/form-data">

        @csrf
        <div class="mb-3">
            <label for="nome" class="form-label">nome</label>
            <input type="text" class="form-control" id="nome" name="nome">
            @error('nome') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label for="duracao" class="form-label">duração</label>
            <input type="text" class="form-control" id="duracao" name="duracao">
            @error('duracao') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label for="data_lancamento" class="form-label">data do lançamento</label>
            <input type="text" class="form-control" id="data_lancamento" name="data_lancamento">
            @error('data_lancamento') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label for="classificacao" class="form-label">classificação</label>
            <input type="text" class="form-control" id="classificacao" name="classificacao">
            @error('classificacao') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label for="sinopse" class="form-label">sinopse</label>
            <input type="text" class="form-control" id="sinopse" name="sinopse">
            @error('sinopse') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        {{-- Campo do poster --}}
        <div class="mb-3">
            <label for="poster" class="form-label">poster</label>
            <input type="file" class="form-control" id="poster" name="poster">
            @error('poster') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-dark">criar filme</button>
    </form>
@endsection
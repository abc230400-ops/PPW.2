@extends('layouts.app')

@section('titulo', 'criando produto')

@section('conteudo')
<form action="/produtos/{{$produto->id}}" method="post">
    @csrf
    @method('put')
    <div class="mb-3">
        <label for="nome" class="form-label">nome</label>
        <input type="text" class="form-control" id="nome" aria-describedby="nome" name="nome" value="{{$produto->nome ?? '' }}">
        
    </div>
    <div class="mb-3">
        <label for="preco" class="form-label">preço</label>
        <input type="text" class="form-control" id="preco" name="preco" value="{{$produto->preco ?? '' }}">
    </div>
    <button type="submit" class="btn btn-primary">editar produto</button>
</form>
@endsection
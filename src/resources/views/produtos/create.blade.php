@extends('layouts.app')

@section('titulo', 'criando produto')

@section('conteudo')
<form action="/produtos" method="post">
    @csrf
    <div class="mb-3">
        <label for="nome" class="form-label">nome</label>
        <input type="text" class="form-control" id="nome" aria-describedby="nome" name="nome">
        <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
    </div>
    <div class="mb-3">
        <label for="preco" class="form-label">preço</label>
        <input type="text" class="form-control" id="preco" name="preco">
    </div>
    <button type="submit" class="btn btn-primary">criar produto</button>
</form>
@endsection
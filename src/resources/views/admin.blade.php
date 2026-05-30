@extends('layouts.app')

@section('titulo', 'Admin')

@section('conteudo')
<div class="container mt-4">
    <h1>Área Admin</h1>
    <p>Bem-vindo à área administrativa!</p>
    <div class="mb-3 mt-3">
        <button class="btn btn-dark mb-3 ">
            <a href="/generos" class="text-white text-decoration-none">acessar gêneros</a>
        </button>
    </div>
    <div class="mb-3 mt-3">
        <button class="btn btn-dark mb-3 ">
            <a href="/estudios" class="text-white text-decoration-none">acessar estúdios</a>
        </button>
    </div>
</div>
@endsection
{{-- Listagem de produtos com cards Bootstrap em grid --}}
{{-- 1. Indica qual layout usar --}}
@extends('layouts.app')
{{-- 2. Preenche o título da aba do navegador --}}
@section('titulo', 'Lista de Produtos')

@section('conteudo')
<h1 class='mb-4'>Produtos</h1>
<div class='row g-3'>
    @forelse ($produtos as $produto)
    <div class='col-md-4'>
        <div class='card h-100 shadow-sm'>
            <div class='card-body'>
                <h5 class='card-title'>{{ $produto->nome }}</h5>
                <p class='card-text text-muted'>
                    R$ {{ number_format($produto->preco, 2, ',', '.') }}
                </p>

            </div>
            <div class='card-footer'>
                <button class='btn btn-primary' type='submit'>
                    Ver detalhes
                </button>
                <form action='/produtos/{{$produto->id}}' method='post'>
                    @csrf
                    @method('delete')
                    <button class='btn btn-danger' type='submit'>
                        excluir
                    </button>


                </form>

                <a href="/produtos/{{$produto->id}}/edit" class= 'btn btn-secondary' type='submit'>
                    editar
                </a>
               

            </div>

        </div>
    </div>
    @empty
    <div class='col-12'>
        <div class='alert alert-warning'>
            Nenhum produto encontrado.
        </div>
    </div>
    @endforelse
</div>
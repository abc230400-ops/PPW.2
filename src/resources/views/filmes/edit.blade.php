@extends('layouts.app')

@section('titulo', 'editando filme')

@section('conteudo')

    <!-- controla o tamanho total da página -->
    <div class="container mt-4">
        <!-- centraliza o conteúdo (row) -->
        <div class="row justify-content-center">
            <!-- define a largura da coluna (col) -->
            <div class="col-md-6">

                <h1 class="h2 mb-4">Editar filme</h1>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $erro) <div>{{ $erro }}</div> @endforeach
                    </div>
                @endif


                <form action="/filmes/{{$filme->id }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('partials.form-filmes', ['filme' => $filme])
                    <button type="submit" class="btn btn-dark mb-5">Atualizar</button>
                </form>

            </div>
        </div>
    </div>
@endsection
@extends('layouts.app')
@section('titulo', 'OtakoFlix')

@section('conteudo')

<div class="container mt-4">
    @if(request('busca_tudo'))
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <h2>Resultados para: "{{ request('busca_tudo') }}"</h2>

            <h4>Filmes</h4>
            @forelse($filmes as $filme)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title"><a href="/filmes/{{ $filme->id }}">{{ $filme->nome }}</a></h5>
                    <span class="card-text small">{{ $filme->data_lancamento }}</span> |
                    <span class="card-text small">{{ $filme->classificacao }}</span> |
                    <span class="card-text small">{{ $filme->duracao }} min</span>
                </div>
            </div>
            @empty
            <p>Nenhum filme encontrado.</p>
            @endforelse

            <h4>Pessoas</h4>
            @forelse($pessoas as $pessoa)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title"><a href="/pessoas/{{ $pessoa->id }}">{{ $pessoa->nome }}</a></h5>
                    <span class="card-text small">{{ $pessoa->data_nascimento }}</span> |
                    <span class="card-text small">{{ $pessoa->nacionalidade }}</span> |
                    <span class="card-text small">
                        <?php $tipos = []; ?>
                        @if($pessoa->ator) <?php $tipos[] = 'Ator/Dublador'; ?> @endif
                        @if($pessoa->diretor) <?php $tipos[] = 'Diretor'; ?> @endif
                        @if($pessoa->escritor) <?php $tipos[] = 'Escritor'; ?> @endif
                        @if($pessoa->produtor) <?php $tipos[] = 'Produtor'; ?> @endif
                        {{ implode(', ', $tipos) }}
                    </span>
                </div>
            </div>
            @empty
            <p>Nenhuma pessoa encontrada.</p>
            @endforelse

            <h4>Estúdios</h4>
            @forelse($estudios as $estudio)
            <p><a href="/estudios/{{ $estudio->id }}">{{ $estudio->nome }}</a></p>
            @empty
            <p>Nenhum estúdio encontrado.</p>
            @endforelse
            <button class="btn btn-dark mb-3 ">
                <a href="/" class="text-white text-decoration-none">Voltar para a página inicial</a>
            </button>
        </div>
    </div>

    @else

    <h1>Bem-vindo ao OtakoFlix!</h1>
    <p>Descubra os melhores filmes e séries de anime aqui.</p>

    <h2>Filmes em Destaque</h2>
    <div id="carouselExampleIndicators" class="carousel slide">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('imagens/filme_red_carrosel.jpg') }}" class="d-block w-100" alt="..." style="height: 450px; object-fit: fill">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('imagens/gold-onepiece_carrosel.jpg') }}" class="d-block w-100" alt="..." style="height: 450px; object-fit: fill">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('imagens/One-piece-live-action_carrosel.webp') }}" class="d-block w-100" alt="..." style="height: 450px; object-fit: fill">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="container mt-4 mb-5">
        <h2>Animes em Destaque</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <img src="{{ asset('imagens/card_1.jpg') }}" class="card-img-top" alt="Filme">
                    <div class="card-body">
                        <p class="card-text">Kimetsu no Yaiba</p>
                        <p class="card-text">Temporada 1</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="{{ asset('imagens/card_2.jpg') }}" class="card-img-top" alt="Filme">
                    <div class="card-body">
                        <p class="card-text">Jujutsu Kaisen</p>
                        <p class="card-text">Temporada 1</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="{{ asset('imagens/card_3.jpg') }}" class="card-img-top" alt="Filme">
                    <div class="card-body">
                        <p class="card-text">Spy x Family</p>
                        <p class="card-text">Temporada 1</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

   <div class="container mt-4 mb-5">
    <h2>Dubladores de Animes em Destaque</h2>
    
    <div class="card mb-3">
        <div class="d-flex align-items-center p-3 gap-3">
            <img src="{{ asset('imagens/ator_1.jpg') }}" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover;">
            <div class="flex-grow-1">
                <h5 class="card-title">Robson Kumode</h5>
                <p class="card-text">Personagem mais famoso que ja dublou foi Sasuke de Naruto.</p>
            </div>
        </div>
    </div>  {{-- ← fecha card 1 --}}

    <div class="card mb-3">
        <div class="d-flex align-items-center p-3 gap-3">
            <img src="{{ asset('imagens/ator_2.jpg') }}" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover;">
            <div class="flex-grow-1">
                <h5 class="card-title">Tati Keplmair</h5>
                <p class="card-text">Personagem mais famoso que ja dublou foi Shinobu de Kimetsu no Yaiba.</p>
            </div>
        </div>
    </div>  {{-- ← fecha card 2 --}}

    <div class="card mb-3">
        <div class="d-flex align-items-center p-3 gap-3">
            <img src="{{ asset('imagens/ator_3.jpg') }}" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover;">
            <div class="flex-grow-1">
                <h5 class="card-title">Wendel Bezerra</h5>
                <p class="card-text">Personagem mais famoso que ja dublou foi Goku de Dragon Ball.</p>
            </div>
        </div>
    </div>  {{-- ← fecha card 3 --}}

</div>
    @endif
</div>

@endsection
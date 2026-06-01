@extends('layouts.app')

@section('titulo', $filme->nome)
{{-- style="background-color: #f8f9fa; padding: 20px; border-radius: 5px;" --}}
@section('conteudo')

{{-- resources/views/filmes/show.blade.php --}}
<section class="mt-5" id="secao-avaliacoes">
    <h3>Avaliações</h3>
    {{-- Container onde o JS injeta os cards de avaliação --}}
    <div id="avaliacoes-container">
        <p class="text-muted">Carregando avaliações...</p>
    </div>
    {{-- Navegação AJAX --}}
    <div class="d-flex align-items-center gap-3 mt-3">
        <button id="btn-anterior" class="btn btn-outline-secondary" disabled>
            ← Anterior
        </button>
        <span id="info-pagina" class="text-muted"></span>
        <button id="btn-proxima" class="btn btn-outline-secondary">
            Próxima →
        </button>
    </div>
</section>
@endsection
{{-- Script inline com o ID do filme para o JS usar --}}
{{-- O @push('scripts') com o fetch fica abaixo ou num arquivo separado --}}
@push('scripts')
    <script>
        const filmeId = {{ $filme->id }};
        let paginaAtual = 1;
        function carregarAvaliacoes(pagina) {
            fetch(`/filmes/${filmeId}/avaliacoes?page=${pagina}`, {
                headers: { 'Accept': 'application/json' }
            })
                .then(res => {
                    if (!res.ok) throw new Error('Erro na requisição');
                    return res.json();
                })
                .then(dados => {
                    renderizarAvaliacoes(dados.data);
                    atualizarNavegacao(dados);
                    paginaAtual = dados.current_page;
                })
                .catch(erro => {
                console.log(erro);
                    document.getElementById('avaliacoes-container').innerHTML =
                        '<p class="text-danger">Erro ao carregar avaliações.</p>';
                });
        }
        function renderizarAvaliacoes(avaliacoes) {
            const container = document.getElementById('avaliacoes-container');
            container.innerHTML = avaliacoes.map(av => `
    <div class="card mb-2">
    <div class="card-body">
    <strong>${av.user.name}</strong>
    <span class="badge bg-primary">${av.nota}/5</span>
    <p class="mb-0">${av.descricao ?? ''}</p>
    </div>
    </div>
    `).join('');
        }
        function atualizarNavegacao(dados) {
            document.getElementById('btn-anterior').disabled = !dados.prev_page_url;
            document.getElementById('btn-proxima').disabled = !dados.next_page_url;
            document.getElementById('info-pagina').textContent =
                `Página ${dados.current_page} de ${dados.last_page}`;
        }
        document.getElementById('btn-anterior')
            .addEventListener('click', () => carregarAvaliacoes(paginaAtual - 1));
        document.getElementById('btn-proxima')
            .addEventListener('click', () => carregarAvaliacoes(paginaAtual + 1));
        // Carrega a primeira página ao abrir a página
        carregarAvaliacoes(1);
    </script>
@endpush
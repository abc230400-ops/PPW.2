<div class="mb-3">
    <label for="nome" class="form-label">nome</label>
    <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome', $filme->nome ?? '') }}"
        class="form-control @error('nome') is-invalid @enderror">
    @error('nome') <div class="text-danger">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
    <label for="duracao" class="form-label">duração</label>
    <input type="number" class="form-control" id="duracao" name="duracao"
        value="{{ old('duracao', $filme->duracao ?? '') }}" class="form-control @error('duracao') is-invalid @enderror">
    @error('duracao') <div class="text-danger">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
    <label for="data_lancamento" class="form-label">data do lançamento</label>
    <input type="text" class="form-control" id="data_lancamento" name="data_lancamento"
        value="{{ old('data_lancamento', $filme->data_lancamento ?? '') }}"
        class="form-control @error('data_lancamento') is-invalid @enderror">
    @error('data_lancamento') <div class="text-danger">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
    <label for="classificacao" class="form-label">classificação</label>
    <input type="text" class="form-control" id="classificacao" name="classificacao"
        value="{{ old('classificacao', $filme->classificacao ?? '') }}"
        class="form-control @error('classificacao') is-invalid @enderror">
    @error('classificacao') <div class="text-danger">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
    <label for="sinopse" class="form-label">sinopse</label>
    <input type="text" class="form-control" id="sinopse" name="sinopse"
        value="{{ old('sinopse', $filme->sinopse ?? '') }}" class="form-control @error('sinopse') is-invalid @enderror">
    @error('sinopse') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div id="generos" class="mb-3">
    <label class="form-label">Gêneros</label>
    <div class="d-flex flex-wrap gap-3">
        @foreach ($generos as $genero)
            <div class="form-check">
                <input type="checkbox" name="generos[]" value="{{ $genero->id }}" {{ ($filme->genero ?? collect())->contains($genero->id) ? 'checked' : '' }} class="form-check-input">
                <label class="form-check-label">{{ $genero->nome }}</label>
            </div>
        @endforeach
    </div>
</div>
<div id="estudios" class="mb-3">
    <label class="form-label">Estúdios</label>
    <div class="d-flex flex-wrap gap-3">
        @foreach ($estudios as $estudio)
            <div class="form-check">
                <input type="checkbox" name="estudios[]" value="{{ $estudio->id }}" {{ ($filme->estudio ?? collect())->contains($estudio->id) ? 'checked' : '' }} class="form-check-input">
                <label class="form-check-label">{{ $estudio->nome }}</label>
            </div>
        @endforeach
    </div>
</div>



{{-- Seção de vínculos na partial form-filme.blade.php --}}
<div class="mb-4">
    <label class="form-label fw-bold">Pessoas vinculadas</label>
    {{-- Container onde os cards de vínculo são inseridos --}}
    <div id="vinculos-container"></div>
    <button type="button" id="btn-vincular" class="btn btn-outline-secondary btn-sm mt-2">
        + Vincular pessoa
    </button>
</div>

{{-- Template de um card de vínculo (oculto, clonado pelo JS) --}}
<template id="template-vinculo">
    <div class="card mb-2 card-vinculo">
        <div class="card-body p-2">
            {{-- Campo de busca visível + campo oculto com o ID --}}
            <input type="text" class="form-control mb-2 campo-busca" placeholder="Buscar pelo nome da pessoa...">
            <div class="lista-resultados list-group mb-2"></div>
            <input type="hidden" name="" class="campo-pessoa-id">
            <span class="nome-pessoa text-muted small"></span>
            <select name="" class="form-select form-select-sm mb-2 campo-tipo">
                <option value="ator">Ator</option>
                <option value="diretor">Diretor</option>
                <option value="produtor">Produtor</option>
                <option value="escritor">Escritor</option>
            </select>
            <input type="text" name="" class="form-control form-control-sm campo-personagem"
                placeholder="Nome do personagem">
            <button type="button" class="btn btn-sm btn-outline-danger mt-1 btn-remover">
                Remover vínculo
            </button>
        </div>
    </div>
</template>

{{-- Container que recebe os novos campos --}}
<div id="campos-imagem">
    <div class="campo-imagem mb-2 d-flex align-items-center gap-2">
        <input type="file" name="imagens[]" class="form-control" accept="image/jpeg,image/png,image/webp">
        <label class="mb-0">
            <input type="checkbox" name="poster_index" value="0"> Poster
        </label>
    </div>
    {{-- aqui amostra as imagens que tem dentro de cada filme --}}
    {{-- vai ajeitar na semana que vem com ajax --}}
    @if (isset($filme) && $filme->imagens->isNotEmpty())
        <div class="mb-4">
            <label class="form-label fw-bold">Imagens cadastradas</label>
            <div class="d-flex flex-wrap gap-3">
                @foreach ($filme->imagens as $imagem)
                    <div class="text-center" style="width: 130px">
                        <img src="{{ asset('storage/' . $imagem->caminho) }}" class="img-thumbnail mb-1"
                            style="height: 90px; object-fit: cover">
                        {{-- Radio para definir como poster --}}
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="poster_imagem_id" value="{{ $imagem->id }}" {{ $imagem->pivot->poster ? 'checked' : '' }}>
                            <label class="form-check-label small">Poster</label>
                        </div>
                        {{-- Botão de remoção individual --}}
                        <!-- <form action="/imagens/{{ $imagem->id }}/filme/{{ $filme->id }}" method="POST" class="mt-1"
                                                                                            onsubmit="return confirm('Remover esta imagem?')">
                                                                                            @csrf
                                                                                            @method('DELETE')
                                                                                            <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                                                                                Remover
                                                                                            </button>
                                                                                        </form> -->
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
<button type="button" id="btn-adicionar" class="btn btn-outline-secondary mb-5">
    + Adicionar imagem
</button>

@if (isset($filme))
<div class="mb-3">
<label class="form-label fw-bold">Pessoas vinculadas</label>
@foreach ([
'ator' => ['label' => 'Ator', 'temPersonagem' => true],
'diretor' => ['label' => 'Diretor', 'temPersonagem' => false],
'produtor'=> ['label' => 'Produtor', 'temPersonagem' => false],
'escritor'=> ['label' => 'Escritor', 'temPersonagem' => false],
] as $relacao => $config)
@foreach ($filme->$relacao as $item)
<div class="d-flex align-items-center gap-2 mb-2 card-vinculo-existente">
<span class="badge bg-secondary">{{ $config['label'] }}</span>
<span>{{ $item->pessoa->nome }}</span>
@if ($config['temPersonagem'])
<input type="text"
name="atores_existentes[{{ $item->id }}][papel]"
value="{{ $item->pivot->papel }}"
class="form-control form-control-sm" style="width:180px"
placeholder="Personagem">

@endif

{{-- Marcador para remoção --}}
<input type="checkbox"
name="remover_vinculos[{{ $relacao }}][]"
value="{{ $item->id }}"
class="form-check-input" title="Remover">
<label class="form-check-label text-danger small">Remover</label>
</div>
@endforeach
@endforeach
</div>
@endif


@foreach ($errors->all() as $erro)
    <li>{{ $erro }}</li>
@endforeach

@push('scripts')
    <script>
        const container = document.getElementById('campos-imagem');
        const btnAdicionar = document.getElementById('btn-adicionar');
        let indice = 1;
        const MAX_FOTOS = 5;
        btnAdicionar.addEventListener('click', () => {
            //if (indice >= MAX_FOTOS) {
            //  alert('Máximo de ' + MAX_FOTOS + ' imagens.');
            // return;
            //}
            const div = document.createElement('div');
            div.className = 'campo-imagem mb-2 d-flex align-items-center gap-2';
            div.innerHTML = `
                                                    <input type="file" name="imagens[]" class="form-control"
                                                    accept="image/jpeg,image/png,image/webp">
                                                    <label class="mb-0">
                                                    <input type="checkbox" name="poster_index" value="${indice}"> Poster
                                                    </label>
                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                    onclick="this.closest('.campo-imagem').remove()">✕</button>`;
            container.appendChild(div);
            indice++;
        });

        const filmeId = {{ $filme->id ?? 'null' }};
        const container_pessoa = document.getElementById('vinculos-container');
        const template = document.getElementById('template-vinculo');
        const csrfToken = document.querySelector('input[name="_token"]').value;
        let indice_pessoa = 0;
        document.getElementById('btn-vincular').addEventListener('click', () => {
            const card = template.content.cloneNode(true).querySelector('.card-vinculo');
            // Nomeia os campos com o índice atual
            card.querySelector('.campo-pessoa-id').name = `vinculos[${indice_pessoa}][pessoa_id]`;
            card.querySelector('.campo-tipo').name = `vinculos[${indice_pessoa}][tipo]`;
            card.querySelector('.campo-personagem').name = `vinculos[${indice_pessoa}][papel]`;
            inicializarCard(card);
            container.appendChild(card);
            indice_pessoa++;
        });

        function inicializarCard(card) {
            const campoBusca = card.querySelector('.campo-busca');
            const listaResultados = card.querySelector('.lista-resultados');
            let timer;
            // Debounce: aguarda 300ms após o usuário parar de digitar
            campoBusca.addEventListener('input', () => {
                clearTimeout(timer);
                timer = setTimeout(() => buscarPessoas(campoBusca.value, listaResultados, card), 300);
            });
            // Exibir/ocultar campo de personagem conforme o tipo
            card.querySelector('.campo-tipo').addEventListener('change', (e) => {
                card.querySelector('.campo-personagem').style.display =
                    e.target.value === 'ator' ? 'block' : 'none';
            });
            // Remover card
            card.querySelector('.btn-remover').addEventListener('click', () => {
                card.remove();
                reindexarVinculos();
            });
        }

        function buscarPessoas(termo, lista, card) {
            if (termo.length < 2) { lista.innerHTML = ''; return; }
            fetch(`/pessoas/buscar?q=${encodeURIComponent(termo)}&filme_id=${filmeId ?? ''}`, {
                headers: { 'Accept': 'application/json' }
            })
                .then(res => res.json())
                .then(pessoas => {
                    lista.innerHTML = '';
                    if (pessoas.length === 0) {
                        lista.innerHTML = '<span class="list-group-item text-muted">Nenhum resultado</span>';
                        return;
                    }
                    pessoas.forEach(p => {
                        const item = document.createElement('button');
                        item.type = 'button';
                        item.className = 'list-group-item list-group-item-action';
                        // Avisa se já existe vínculo deste tipo
                        const aviso = p.vinculos.length > 0
                            ? ` <small class="text-warning">(já vinculado como ${p.vinculos.join(', ')})</small>`
                            : '';
                        item.innerHTML = `${p.nome}${aviso}`;
                        item.addEventListener('click', () => {
                            // Preenche os campos ocultos e exibe o nome selecionado
                            card.querySelector('.campo-pessoa-id').value = p.id;
                            card.querySelector('.campo-busca').value = '';
                            card.querySelector('.nome-pessoa').textContent = ' ' + p.nome;
                            lista.innerHTML = ''; // fecha a lista
                        });
                        lista.appendChild(item);
                    });
                })
                .catch(err => console.error(err));
        }

        function reindexarVinculos() {
            container.querySelectorAll('.card-vinculo').forEach((card, i) => {
                card.querySelector('.campo-pessoa-id').name = `vinculos[${i}][pessoa_id]`;
                card.querySelector('.campo-tipo').name = `vinculos[${i}][tipo]`;
                card.querySelector('.campo-personagem').name = `vinculos[${i}][papel]`;
            });
            indice_pessoa = container.querySelectorAll('.card-vinculo').length;
        }

    </script>

@endpush


<!-- <div class="mb-3">
    <label for="poster" class="form-label">poster</label>
    <input type="file" class="form-control" id="poster" name="poster">
    @error('poster') <div class="text-danger">{{ $message }}</div> @enderror
</div> -->
<div class="mb-3">
    <label for="nome" class="form-label">Nome</label>
    <input type="text" class="form-control @error('nome') is-invalid @enderror"
        id="nome" name="nome" value="{{ old('nome', $pessoa->nome ?? '') }}">
    @error('nome') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="data_nascimento" class="form-label">Data de Nascimento</label>
    <input type="date" class="form-control @error('data_nascimento') is-invalid @enderror"
        id="data_nascimento" name="data_nascimento"
        value="{{ old('data_nascimento', $pessoa->data_nascimento ?? '') }}">
    @error('data_nascimento') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="biografia" class="form-label">Biografia</label>
    <input type="text" class="form-control @error('biografia') is-invalid @enderror"
        id="biografia" name="biografia"
        value="{{ old('biografia', $pessoa->biografia ?? '') }}">
    @error('biografia') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="genero" class="form-label">Gênero</label>
    <input type="text" class="form-control @error('genero') is-invalid @enderror"
        id="genero" name="genero"
        value="{{ old('genero', $pessoa->genero ?? '') }}">
    @error('genero') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="nacionalidade" class="form-label">Nacionalidade</label>
    <input type="text" class="form-control @error('nacionalidade') is-invalid @enderror"
        id="nacionalidade" name="nacionalidade"
        value="{{ old('nacionalidade', $pessoa->nacionalidade ?? '') }}">
    @error('nacionalidade') <div class="text-danger">{{ $message }}</div> @enderror
</div>

@if (!isset($pessoa))
<div class="mb-3">
    <label for="cpf" class="form-label">CPF</label>
    <input type="text" class="form-control @error('cpf') is-invalid @enderror"
        id="cpf" name="cpf" value="{{ old('cpf') }}">
    @error('cpf') <div class="text-danger">{{ $message }}</div> @enderror
</div>

@endif

<div class="mb-3">
    <label class="form-label">Fotos</label>
    <div id="campos-imagem-pessoa">
        <div class="campo-imagem-pessoa mb-2">
            <input type="file" name="imagens[]" class="form-control" accept="image/jpeg,image/png,image/webp">
        </div>
    </div>
    <button type="button" id="btn-adicionar-imagem-pessoa" class="btn btn-outline-secondary btn-sm mt-2">
        + Adicionar foto
    </button>
</div>

<div id="tipos" class="mb-3">
    <label class="form-label">O que essa pessoa é?</label>

    <div class="form-check">
        <input type="checkbox" name="tipos[]" value="ator"
            {{ isset($pessoa) && $pessoa->ator ? 'checked' : '' }}
            class="form-check-input"> Ator/Dublador
    </div>
    <div class="form-check">
        <input type="checkbox" name="tipos[]" value="diretor"
            {{ isset($pessoa) && $pessoa->diretor ? 'checked' : '' }}
            class="form-check-input"> Diretor
    </div>
    <div class="form-check">
        <input type="checkbox" name="tipos[]" value="escritor"
            {{ isset($pessoa) && $pessoa->escritor ? 'checked' : '' }}
            class="form-check-input"> Escritor
    </div>
    <div class="form-check">
        <input type="checkbox" name="tipos[]" value="produtor"
            {{ isset($pessoa) && $pessoa->produtor ? 'checked' : '' }}
            class="form-check-input"> Produtor
    </div>
</div>

<template id="template-vinculo-pessoaFilme">
    <div class="card mb-2 card-vinculoPessoaFilme">
        <div class="card-body p-2">
            <input type="text" class="form-control mb-2 campo-busca" placeholder="Buscar pelo filme...">
            <div class="lista-resultados list-group mb-2"></div>
            <input type="hidden" name="" class="campo-filme-id">
            <span class="nome-filme text-muted small"></span>
            <select name="" class="form-select form-select-sm mb-2 campo-tipo">
                <option value="ator">Ator</option>
                <option value="diretor">Diretor</option>
                <option value="produtor">Produtor</option>
                <option value="escritor">Escritor</option>
            </select>
            <input type="text" name="" class="form-control form-control-sm campo-personagem" placeholder="Nome do personagem">
            <button type="button" class="btn btn-sm btn-outline-danger mt-1 btn-remover">Remover vínculo</button>
        </div>
    </div>
</template>

<div class="mb-4">
    <label class="form-label fw-bold">Filmes vinculados</label>
    <div id="vinculos-filme-container"></div>
    <button type="button" id="btn-vincular-filme" class="btn btn-outline-secondary btn-sm mt-2">
        + Vincular filme
    </button>
</div>

@push('scripts')
<script>
    const container = document.getElementById('campos-imagem-pessoa');
    const btnAdicionarImagemPessoa = document.getElementById('btn-adicionar-imagem-pessoa');
    let indice = 1;
    btnAdicionarImagemPessoa.addEventListener('click', () => {
        const div = document.createElement('div');
        div.className = 'campo-imagem-pessoa mb-2 d-flex align-items-center gap-2';
        div.innerHTML = `<input type="file" name="imagens[]" class="form-control" accept="image/jpeg,image/png,image/webp">
                      <button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('.campo-imagem-pessoa').remove()">✕</button>`;
        container.appendChild(div);
        indice++;
    });

    const templateFilme = document.getElementById('template-vinculo-pessoaFilme');
    const containerFilme = document.getElementById('vinculos-filme-container');
    const btnVincularFilme = document.getElementById('btn-vincular-filme');
    let indiceFilme = 0;

    btnVincularFilme.addEventListener('click', () => {
        const card = templateFilme.content.cloneNode(true).querySelector('.card-vinculoPessoaFilme');

        card.querySelector('.campo-filme-id').name = `filmes_vinculados[${indiceFilme}][filme_id]`;
        card.querySelector('.campo-tipo').name = `filmes_vinculados[${indiceFilme}][tipo]`;
        card.querySelector('.campo-personagem').name = `filmes_vinculados[${indiceFilme}][papel]`;

        inicializarCardFilme(card);
        containerFilme.appendChild(card);
        indiceFilme++;
    });

    function inicializarCardFilme(card) {
        const campoBusca = card.querySelector('.campo-busca');
        const listaResultados = card.querySelector('.lista-resultados');
        let timer;

        campoBusca.addEventListener('input', () => {
            clearTimeout(timer);
            timer = setTimeout(() => buscarFilmes(campoBusca.value, listaResultados, card), 300);
        });

        card.querySelector('.campo-tipo').addEventListener('change', (e) => {
            card.querySelector('.campo-personagem').style.display =
                e.target.value === 'ator' ? 'block' : 'none';
        });

        card.querySelector('.btn-remover').addEventListener('click', () => {
            card.remove();
            reindexarVinculosFilme();
        });
    }

    function buscarFilmes(termo, lista, card) {
        if (termo.length < 2) {
            lista.innerHTML = '';
            return;
        }
        fetch(`/filmes/buscar?q=${encodeURIComponent(termo)}`, {
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(filmes => {
                lista.innerHTML = '';
                if (filmes.length === 0) {
                    lista.innerHTML = '<span class="list-group-item text-muted">Nenhum resultado</span>';
                    return;
                }
                filmes.forEach(f => {
                    const item = document.createElement('button');
                    item.type = 'button';
                    item.className = 'list-group-item list-group-item-action';
                    item.innerHTML = f.nome;
                    item.addEventListener('click', () => {
                        card.querySelector('.campo-filme-id').value = f.id;
                        card.querySelector('.campo-busca').value = '';
                        card.querySelector('.nome-filme').textContent = ' ' + f.nome;
                        lista.innerHTML = '';
                    });
                    lista.appendChild(item);
                });
            })
            .catch(err => console.error(err));
    }

    function reindexarVinculosFilme() {
        containerFilme.querySelectorAll('.card-vinculoPessoaFilme').forEach((card, i) => {
            card.querySelector('.campo-filme-id').name = `filmes_vinculados[${i}][filme_id]`;
            card.querySelector('.campo-tipo').name = `filmes_vinculados[${i}][tipo]`;
            card.querySelector('.campo-personagem').name = `filmes_vinculados[${i}][papel]`;
        });
        indiceFilme = containerFilme.querySelectorAll('.card-vinculoPessoaFilme').length;
    }
</script>
@endpush
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

<div id="generos">
    <label class="form-label">Gêneros</label>
    @foreach ($generos as $genero)
    <div class="form-check">
        <input type="checkbox" name="generos[]" value="{{ $genero->id }}"
        {{ ($filme->genero ?? collect())->contains($genero->id) ? 'checked' : '' }}
            class="form-check-input">
        <label class="form-check-label">{{ $genero->nome }}</label>
    </div>
    @endforeach
</div>

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
</script>
@endpush


<!-- <div class="mb-3">
    <label for="poster" class="form-label">poster</label>
    <input type="file" class="form-control" id="poster" name="poster">
    @error('poster') <div class="text-danger">{{ $message }}</div> @enderror
</div> -->
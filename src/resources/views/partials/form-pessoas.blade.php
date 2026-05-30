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
    <label for="imagem" class="form-label">Foto</label>
    <input type="file" name="imagem" id="imagem" class="form-control" accept="image/jpeg,image/png,image/webp">
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
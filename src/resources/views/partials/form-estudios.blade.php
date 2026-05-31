<div class="mb-3">
    <label for="nome" class="form-label">nome</label>
    <input type="text" name="nome" value="{{ old('nome', $estudio->nome ?? '') }}"
    class="form-control @error('nome') is-invalid @enderror">
    @error('nome')<div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="local" class="form-label">local</label>
    <input type="text" name="local" value="{{ old('local', $estudio->local ?? '') }}"
    class="form-control @error('local') is-invalid @enderror">  
    @error('local')<div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="imagem" class="form-label">Foto</label>
    <input type="file" name="imagem" id="imagem" class="form-control" accept="image/jpeg,image/png,image/webp">
</div>
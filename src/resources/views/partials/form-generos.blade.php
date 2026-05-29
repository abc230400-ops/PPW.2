<div class="mb-3">
    <label for="nome" class="form-label">nome</label>
    <input type="text" name="nome" value="{{ old('nome', $genero->nome ?? '') }}"
    class="form-control @error('nome') is-invalid @enderror">
    @error('nome')<div class="invalid-feedback">{{ $message }}</div> @enderror
</div>




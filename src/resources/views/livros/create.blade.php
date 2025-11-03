@extends('layouts.app')

@section('title', 'Novo Livro')

@section('content')
<h2 class="mb-4">Cadastrar Livro</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('livros.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="titulo" class="form-label">Título</label>
        <input type="text" name="titulo" id="titulo" class="form-control" value="{{ old('titulo') }}" required>
        @error('titulo')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="editora" class="form-label">Editora</label>
        <input type="text" name="editora" id="editora" class="form-control" value="{{ old('editora') }}">
        @error('editora')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label for="edicao" class="form-label">Edição</label>
            <input type="number" name="edicao" id="edicao" class="form-control" value="{{ old('edicao') }}">
            @error('edicao')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label for="ano_publicacao" class="form-label">Ano de Publicação</label>
            <input type="text" name="ano_publicacao" id="ano_publicacao" class="form-control" maxlength="4" value="{{ old('ano_publicacao') }}">
            @error('ano_publicacao')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label for="valor" class="form-label">Valor (R$)</label>
            <input type="text" name="valor" id="valor" class="form-control" value="{{ old('valor') }}">
            @error('valor')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="mb-3">
        <label for="autores" class="form-label">Autores</label>
        <select name="autores[]" id="autores" class="form-select" multiple>
        @foreach ($autores as $autor)
            <option value="{{ $autor->CodAu }}">{{ $autor->Nome }}</option>
            @endforeach
        </select>
        @error('autores')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
        <small class="text-muted">Segure Ctrl (Windows) ou Command (Mac) para selecionar múltiplos autores</small>
    </div>

    <div class="mb-3">
        <label for="assuntos" class="form-label">Assuntos</label>
        <select name="assuntos[]" id="assuntos" class="form-select" multiple>
        @foreach ($assuntos as $assunto)
            <option value="{{ $assunto->CodAs }}">{{ $assunto->Descricao }}</option>
            @endforeach
        </select>
        @error('assuntos')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
        <small class="text-muted">Segure Ctrl (Windows) ou Command (Mac) para selecionar múltiplos assuntos</small>
    </div>

    <button type="submit" class="btn btn-success">Salvar</button>
    <a href="{{ route('livros.index') }}" class="btn btn-secondary">Cancelar</a>
</form>

<script>
$(document).ready(function(){
  $('#valor').inputmask('currency', {
    prefix: 'R$ ',
    radixPoint: ',',
    groupSeparator: '.',
    digits: 2,
    autoGroup: true,
    rightAlign: false
  });
});
</script>
@endsection

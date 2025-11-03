@extends('layouts.app')

@section('title', 'Editar Livro')

@section('content')
<h2 class="mb-4">Editar Livro</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('livros.update', $livro) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="titulo" class="form-label">Título</label>
        <input type="text" name="titulo" id="titulo" class="form-control" value="{{ old('titulo', $livro->Titulo) }}" required>
        @error('titulo')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="editora" class="form-label">Editora</label>
        <input type="text" name="editora" id="editora" class="form-control" value="{{ old('editora', $livro->Editora) }}">
        @error('editora')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label for="edicao" class="form-label">Edição</label>
            <input type="number" name="edicao" id="edicao" class="form-control" value="{{ old('edicao', $livro->Edicao) }}">
            @error('edicao')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label for="ano_publicacao" class="form-label">Ano de Publicação</label>
            <input type="text" name="ano_publicacao" id="ano_publicacao" class="form-control" maxlength="4" value="{{ old('ano_publicacao', $livro->AnoPublicacao) }}">
            @error('ano_publicacao')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label for="valor" class="form-label">Valor (R$)</label>
            <input type="text" name="valor" id="valor" class="form-control" value="{{ old('valor', number_format($livro->Valor, 2, ',', '.')) }}">
            @error('valor')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="mb-3">
        <label for="autores" class="form-label">Autores</label>
        <select name="autores[]" id="autores" class="form-select" multiple>
            @foreach ($autores as $autor)
                <option value="{{ $autor->CodAu }}" {{ in_array($autor->CodAu, $livroAutores) ? 'selected' : '' }}>
                    {{ $autor->Nome }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="assuntos" class="form-label">Assuntos</label>
        <select name="assuntos[]" id="assuntos" class="form-select" multiple>
            @foreach ($assuntos as $assunto)
                <option value="{{ $assunto->CodAs }}" {{ in_array($assunto->CodAs, $livroAssuntos) ? 'selected' : '' }}>
                    {{ $assunto->Descricao }}
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-success">Atualizar</button>
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

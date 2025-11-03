@extends('layouts.app')

@section('title', 'Editar Autor')

@section('content')
<h2 class="mb-4">Editar Autor</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('autores.update', $autor) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="nome" class="form-label">Nome</label>
        <input type="text" name="nome" id="nome" class="form-control" value="{{ old('nome', $autor->Nome) }}" required>
        @error('nome')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-success">Atualizar</button>
    <a href="{{ route('autores.index') }}" class="btn btn-secondary">Cancelar</a>
</form>

@endsection

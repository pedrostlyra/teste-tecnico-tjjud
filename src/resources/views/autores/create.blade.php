@extends('layouts.app')

@section('title', 'Novo Autor')

@section('content')
<h2 class="mb-4">Cadastrar Autor</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('autores.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="nome" class="form-label">Nome</label>
        <input type="text" name="nome" id="nome" class="form-control" value="{{ old('nome') }}" required>
        @error('nome')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-success">Salvar</button>
    <a href="{{ route('autores.index') }}" class="btn btn-secondary">Cancelar</a>
</form>

@endsection

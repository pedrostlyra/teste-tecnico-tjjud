@extends('layouts.app')

@section('title', 'Novo Assunto')

@section('content')
<h2 class="mb-4">Cadastrar Assunto</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('assuntos.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="descricao" class="form-label">Descrição</label>
        <input type="text" name="descricao" id="descricao" class="form-control" value="{{ old('descricao') }}" required>
        @error('descricao')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-success">Salvar</button>
    <a href="{{ route('assuntos.index') }}" class="btn btn-secondary">Cancelar</a>
</form>

@endsection
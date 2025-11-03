@extends('layouts.app')

@section('title', 'Editar Assunto')

@section('content')
<h2 class="mb-4">Editar Assunto</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('assuntos.update', $assunto) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="descricao" class="form-label">Descrição</label>
        <input type="text" name="descricao" id="descricao" class="form-control" value="{{ old('descricao', $assunto->Descricao) }}" required>
        @error('descricao')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-success">Atualizar</button>
    <a href="{{ route('assuntos.index') }}" class="btn btn-secondary">Cancelar</a>
</form>

@endsection
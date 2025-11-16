@extends('layouts.app')

@section('title', 'Lista de Assuntos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Lista de Assuntos</h2>
    <a href="{{ route('assuntos.create') }}" class="btn btn-primary">Novo Assunto</a>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-striped">
    <thead>
        <tr>
            <th>Descrição</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($assuntos as $assunto)
            <tr>
                <td>{{ $assunto->Descricao }}</td>
                <td>
                    <a href="{{ route('assuntos.edit', $assunto) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('assuntos.destroy', $assunto) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" data-confirm data-confirm-message="Tem certeza que deseja excluir este assunto?">Excluir</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="mt-4">
    {{ $assuntos->links() }}
</div>
@endsection

@extends('layouts.app')

@section('title', 'Lista de Autores')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Lista de Autores</h2>
    <a href="{{ route('autores.create') }}" class="btn btn-primary">Novo Autor</a>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-striped">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($autores as $autor)
            <tr>
                <td>{{ $autor->Nome }}</td>
                <td>
                    <a href="{{ route('autores.edit', $autor) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('autores.destroy', $autor) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Excluir este autor?')">Excluir</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $autores->links() }}
@endsection

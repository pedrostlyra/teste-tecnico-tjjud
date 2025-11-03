@extends('layouts.app')

@section('title', 'Lista de Livros')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Lista de Livros</h2>
    <a href="{{ route('livros.create') }}" class="btn btn-primary">Novo Livro</a>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-striped">
    <thead>
        <tr>
            <th>Título</th>
            <th>Editora</th>
            <th>Edição</th>
            <th>Ano</th>
            <th>Valor (R$)</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($livros as $livro)
            <tr>
                <td>{{ $livro->Titulo }}</td>
                <td>{{ $livro->Editora }}</td>
                <td>{{ $livro->Edicao }}</td>
                <td>{{ $livro->AnoPublicacao }}</td>
                <td>{{ number_format($livro->Valor, 2, ',', '.') }}</td>
                <td>
                    <a href="{{ route('livros.edit', $livro) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('livros.destroy', $livro) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Excluir este livro?')">Excluir</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $livros->links() }}
@endsection

@extends('layouts.app')

@section('title', 'Relatório de Livros')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Relatório de Livros</h2>
    <div>
        <a href="{{ route('relatorio.gerar') }}" class="btn btn-primary" target="_blank">
            Gerar PDF
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Editora</th>
                        <th>Edição</th>
                        <th>Ano</th>
                        <th>Valor (R$)</th>
                        <th>Autores</th>
                        <th>Assuntos</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dados as $livro)
                        <tr>
                            <td>{{ $livro->livro_titulo }}</td>
                            <td>{{ $livro->livro_editora ?? '-' }}</td>
                            <td>{{ $livro->livro_edicao ?? '-' }}</td>
                            <td>{{ $livro->livro_ano ?? '-' }}</td>
                            <td>{{ number_format($livro->livro_valor, 2, ',', '.') }}</td>
                            <td>{{ $livro->autores ?? 'Sem autores' }}</td>
                            <td>{{ $livro->assuntos ?? 'Sem assuntos' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Nenhum livro encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="table-secondary">
                        <td colspan="4" class="text-end"><strong>Total:</strong></td>
                        <td><strong>{{ $dados->count() }} livros</strong></td>
                        <td colspan="2"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

@endsection


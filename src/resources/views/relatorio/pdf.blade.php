<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Livros</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            margin: 0;
            padding: 10px;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th {
            background-color: #333;
            color: white;
            padding: 8px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #000;
        }
        td {
            padding: 6px;
            border: 1px solid #ccc;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .valor {
            text-align: right;
        }
        .header-info {
            text-align: right;
            margin-bottom: 10px;
            font-size: 9pt;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header-info">
        Gerado em: {{ date('d/m/Y H:i:s') }}
    </div>
    <h1>Relatório de Livros</h1>
    
    <table>
        <thead>
            <tr>
                <th style="width: 20%;">Título</th>
                <th style="width: 15%;">Editora</th>
                <th style="width: 8%;">Edição</th>
                <th style="width: 8%;">Ano</th>
                <th style="width: 10%;" class="valor">Valor (R$)</th>
                <th style="width: 20%;">Autores</th>
                <th style="width: 19%;">Assuntos</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dados as $livro)
                <tr>
                    <td>{{ $livro->livro_titulo }}</td>
                    <td>{{ $livro->livro_editora ?? '-' }}</td>
                    <td>{{ $livro->livro_edicao ?? '-' }}</td>
                    <td>{{ $livro->livro_ano ?? '-' }}</td>
                    <td class="valor">{{ number_format($livro->livro_valor, 2, ',', '.') }}</td>
                    <td>{{ $livro->autores ?? 'Sem autores' }}</td>
                    <td>{{ $livro->assuntos ?? 'Sem assuntos' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px;">
                        Nenhum livro encontrado.
                    </td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr style="background-color: #e0e0e0; font-weight: bold;">
                <td colspan="4" style="text-align: right;">Total de Livros:</td>
                <td style="text-align: right;">{{ $dados->count() }}</td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>


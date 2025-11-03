<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('DROP VIEW IF EXISTS livros_relatorio_view');
        
        DB::statement("
            CREATE VIEW livros_relatorio_view AS
            SELECT 
                l.Codl as livro_id,
                l.Titulo as livro_titulo,
                l.Editora as livro_editora,
                l.Edicao as livro_edicao,
                l.AnoPublicacao as livro_ano,
                l.Valor as livro_valor,
                GROUP_CONCAT(DISTINCT a.Nome ORDER BY a.Nome SEPARATOR ', ') as autores,
                GROUP_CONCAT(DISTINCT s.Descricao ORDER BY s.Descricao SEPARATOR ', ') as assuntos
            FROM livros l
            LEFT JOIN livro_autor la ON l.Codl = la.Livro_Codl
            LEFT JOIN autores a ON la.Autor_CodAu = a.CodAu
            LEFT JOIN livro_assunto ls ON l.Codl = ls.Livro_Codl
            LEFT JOIN assuntos s ON ls.Assunto_CodAs = s.CodAs
            GROUP BY l.Codl, l.Titulo, l.Editora, l.Edicao, l.AnoPublicacao, l.Valor
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS livros_relatorio_view');
    }
};

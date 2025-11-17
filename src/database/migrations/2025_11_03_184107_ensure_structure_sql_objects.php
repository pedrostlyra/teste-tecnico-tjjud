<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Creates the vw_livros_autores_assuntos view as defined in structure.sql
     */
    public function up(): void
    {
        DB::statement('DROP VIEW IF EXISTS vw_livros_autores_assuntos');
        
        DB::statement("
            CREATE VIEW vw_livros_autores_assuntos AS
            SELECT 
                l.Codl AS livro_id,
                l.Titulo AS titulo,
                l.Editora AS editora,
                l.Edicao AS edicao,
                l.AnoPublicacao AS anopublicacao,
                l.Valor AS valor,
                a.Nome AS autor,
                s.Descricao AS assunto
            FROM livros l
            LEFT JOIN livro_autor la ON la.Livro_Codl = l.Codl
            LEFT JOIN autores a ON a.CodAu = la.Autor_CodAu
            LEFT JOIN livro_assunto ls ON ls.Livro_Codl = l.Codl
            LEFT JOIN assuntos s ON s.CodAs = ls.Assunto_CodAs
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS vw_livros_autores_assuntos');
    }
};

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class LivroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('livros')->insert([
            ['Titulo' => 'Dom Casmurro', 'Editora' => 'Garnier', 'Edicao' => 1, 'AnoPublicacao' => '1899', 'Valor' => 39.90],
            ['Titulo' => 'A Hora da Estrela', 'Editora' => 'Rocco', 'Edicao' => 1, 'AnoPublicacao' => '1977', 'Valor' => 29.90],
            ['Titulo' => 'Gabriela', 'Editora' => 'Record', 'Edicao' => 2, 'AnoPublicacao' => '1958', 'Valor' => 49.90],
        ]);
    }
}

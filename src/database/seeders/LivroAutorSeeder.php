<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class LivroAutorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('livro_autor')->insert([
            ['Livro_Codl' => 1, 'Autor_CodAu' => 1],
            ['Livro_Codl' => 2, 'Autor_CodAu' => 2],
            ['Livro_Codl' => 3, 'Autor_CodAu' => 3],
        ]);
    }
}
